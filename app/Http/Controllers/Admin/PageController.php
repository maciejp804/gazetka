<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\HotSpot;
use App\Models\Leaflet;
use App\Models\Page;
use App\Models\Shop;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{

    public function manage(Leaflet $leaflet)
    {
        $leaflet = Leaflet::with('shop', 'cover')->where('id', $leaflet->id)->first();


        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Gazetki', 'url' => route('admin.leaflets.index')],
            ['label' => $leaflet->shop->name.'-'.$leaflet->title, 'url' => route('admin.leaflets.manage', $leaflet->id)],
            ['label' => 'Strony', 'url' => ''],

        ];
        $shops = Shop::where('status', 'active')->get();

        $manage = [
            ['label' => 'Dodaj ręcznie', 'description' => 'dodaj strony do gazetki (pages, leaflet_pages)',
                'logo' => 'fa-solid fa-plus','url' => route('admin.leaflets.page.create', $leaflet->id)],
            ['label' => 'Dodaj z linku', 'description' => 'dodaj strony do gazetki (pages, leaflet_pages)',
                'logo' => 'fa-solid fa-file-circle-plus','url' => route('admin.leaflets.page.create.api', $leaflet->id)],
//            ['label' => 'Dodaj z innej gazetki', 'description' => 'edytuj strony w gazetce (pages, leaflet_pages)',
//                'logo' => 'fa-solid fa-pen-to-square','url' => route('admin.leaflets.page.import', $leaflet->id)],
            ['label' => 'Zmień kolejność', 'description' => 'zarządzanie przypisanymi stronami, kolejność (relacja leaflet_page z sort_order)',
                'logo' => 'fa-solid fa-sort','url' => route('admin.leaflets.page.edit.order', $leaflet->id)]
        ];

        return view('admin.leaflet.manage', [
            'leaflet' => $leaflet,
            'breadcrumbs' => $breadcrumbs,
            'shops' => $shops,
            'manage' => $manage,
        ]);
    }

    public function create(Leaflet $leaflet)
    {
        $leaflet = Leaflet::with('shop', 'cover', 'pages')->where('id', $leaflet->id)->first();

        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Gazetki', 'url' => route('admin.leaflets.index')],
            ['label' => $leaflet->shop->name.'-'.$leaflet->title, 'url' => route('admin.leaflets.manage', $leaflet->id)],
            ['label' => 'Strony', 'url' => route('admin.leaflets.page.manage', $leaflet->id)],
            ['label' => 'Dodaj ręcznie', 'url' => ''],

        ];

        return view('admin.leaflet.page.create', [
            'leaflet' => $leaflet,
            "breadcrumbs" => $breadcrumbs,

        ]);
    }

    public function createApi(Leaflet $leaflet)
    {
        $leaflet = Leaflet::with('shop', 'cover', 'pages')->where('id', $leaflet->id)->first();

        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Gazetki', 'url' => route('admin.leaflets.index')],
            ['label' => $leaflet->shop->name.'-'.$leaflet->title, 'url' => route('admin.leaflets.manage', $leaflet->id)],
            ['label' => 'Strony', 'url' => route('admin.leaflets.page.manage', $leaflet->id)],
            ['label' => 'Dodaj z linku', 'url' => ''],

        ];

        return view('admin.leaflet.page.createApi', [
            'leaflet' => $leaflet,
            "breadcrumbs" => $breadcrumbs,

        ]);
    }

    public function add(Request $request, Leaflet $leaflet)
    {

        $request->validate([
            'files' => 'nullable|array', // Walidacja dla tablicy stron
            'files.*' => 'image|mimes:jpg,jpeg,png,pdf,webp,avid|max:10240', // Walidacja plików (np. JPG, PNG, PDF)
        ]);

        $leaflet = Leaflet::with('shop', 'cover')->where('id', $leaflet->id)->first();

        // Sprawdzenie, czy strony zostały przesłane
        if ($request->hasFile('files')) {
            $files = $request->file('files');

            $existingPagesCount = $leaflet->pages->count(); // Liczba już przypisanych stron

            // Przechowywanie plików i dodawanie ich do tabeli 'pages'
            foreach ($files as $index => $pageFile) {
                // Generowanie unikalnej ścieżki
                $path = 'leaflets/pages/' . uniqid();
                $sort_order = $existingPagesCount + $index + 1;
                // Użycie serwisu do konwersji i zapisania pliku
                $result = app(ImageService::class)->convertAndStore(
                    $pageFile->getContent(), // Przesyłamy zawartość pliku
                    $path
                );

                // Sprawdzamy, czy konwersja się powiodła
                if (!empty($result)) {
                    // Utworzenie strony w tabeli 'pages' z zapisaną ścieżką do pliku
                    $page = Page::create([
                        'page_number' => $sort_order,
                        'image_path' => $path,
                        'height' => $result['height'],
                        'width' => $result['width'],
                    ]);

                    // Dodanie strony do gazetki z przypisaną kolejnością (sort_order)
                    $leaflet->pages()->attach($page->id, ['sort_order' => $sort_order]);
                }
            }
        }

        return redirect()->route('admin.leaflets.page.manage', $leaflet)->with('success', 'Gazetka została zaktualizowana.');

    }

    public function addApi(Request $request, Leaflet $leaflet)
    {


        $validated = $request->validate([
            'base' => 'required|string', // Walidacja dla tablicy stron
            'ext' => 'required|string',
            'pad' => 'required|numeric|min:0',
            'start' => 'required|numeric|min:0',
            'pages' => 'required|numeric|min:0',
        ]);

        $leaflet = Leaflet::with('shop', 'cover')->where('id', $leaflet->id)->first();
        $existingPagesCount = $leaflet->pages->count();

        for ($i = 1; $i <= $validated['pages']; $i++) {
            // formatowanie numeru strony
            $pageNumber = $validated['pad'] > 0
                ? str_pad($validated['start'], $validated['pad'], '0', STR_PAD_LEFT)
                : $validated['start'];

            $url = $validated['base'] . $pageNumber . $validated['ext'];



            $path = 'leaflets/pages/' . uniqid();
            $sort_order = $existingPagesCount + $i;
            // Użycie serwisu do konwersji i zapisania pliku
            $result = app(ImageService::class)->convertAndStore(
                $url, // Przesyłamy zawartość pliku
                $path
            );

            // Sprawdzamy, czy konwersja się powiodła
            if (!empty($result)) {
                // Utworzenie strony w tabeli 'pages' z zapisaną ścieżką do pliku
                $page = Page::create([
                    'page_number' => $sort_order,
                    'image_path' => $path,
                    'height' => $result['height'],
                    'width' => $result['width'],
                ]);

                // Dodanie strony do gazetki z przypisaną kolejnością (sort_order)
                $leaflet->pages()->attach($page->id, ['sort_order' => $sort_order]);
            }

            $validated['start']++;
        }

        return redirect()->route('admin.leaflets.page.manage', $leaflet)->with('success', 'Gazetka została zaktualizowana.');

    }
    public function edit(Leaflet $leaflet)
    {
        $leaflet = Leaflet::with('shop', 'cover')->where('id', $leaflet->id)->first();

        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Gazetki', 'url' => route('admin.leaflets.index')],
            ['label' => $leaflet->shop->name.'-'.$leaflet->title, 'url' => route('admin.leaflets.manage', $leaflet->id)],
            ['label' => 'Strony', 'url' => route('admin.leaflets.page.manage', $leaflet->id)],
            ['label' => 'Dodaj', 'url' => ''],

        ];

        $shops = Shop::where('status', 'active')->get();

        return view('admin.leaflet.edit', [
            'leaflet' => $leaflet,
            'breadcrumbs' => $breadcrumbs,
            'shops' => $shops
        ]);

    }

    public function editOrder(Leaflet $leaflet)
    {
        $leaflet = Leaflet::with('shop', 'cover', 'pages')->where('id', $leaflet->id)->first();
        $shops = Shop::where('status', 'active')->get();
        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Gazetki', 'url' => route('admin.leaflets.index')],
            ['label' => $leaflet->shop->name.'-'.$leaflet->title, 'url' => route('admin.leaflets.manage', $leaflet->id)],
            ['label' => 'Strony', 'url' => route('admin.leaflets.page.manage', $leaflet->id)],
            ['label' => 'Zmiana kolejności', 'url' => ''],

        ];

        return view('admin.leaflet.page.edit_order', [
            'leaflet' => $leaflet,
            'shops' => $shops,
            "breadcrumbs" => $breadcrumbs,

        ]);
    }

    public function updateOrder(Request $request, Leaflet $leaflet)
    {
        $pages = $request->input('pages', []);
        $sortOrder = $request->input('sort_order', []);
        $toDelete = $request->input('selected_pages', []);

        // ✅ 1. Usuń zaznaczone strony
        if (!empty($toDelete)) {
            $pagesToDelete = $leaflet->pages()->whereIn('pages.id', $toDelete)->get();

            foreach ($pagesToDelete as $page) {
                $hotspots = HotSpot::where('page_id', $page->id)->get();
                foreach ($hotspots as $hotspot) {
                    Storage::disk('public')->delete([$hotspot->image . '.webp', $hotspot->image . '.jpg', $hotspot->image . '.avif']);
                    $hotspot->delete();
                }
                Storage::disk('public')->delete([$page->image_path . '.webp', $page->image_path . '.jpg', $page->image_path . '.avif']);
                $leaflet->pages()->detach($page->id);
                $page->delete();
            }
        }

        // ✅ 2. Zaktualizuj sort_order tylko dla istniejących
        foreach ($pages as $index => $pageId) {
            if (in_array($pageId, $toDelete)) {
                continue; // pomiń usunięte
            }

            $leaflet->pages()->updateExistingPivot($pageId, [
                'sort_order' => (int) $sortOrder[$index],
            ]);
        }

        // ✅ 3. PRZELICZ sort_order od nowa (ciągiem 1, 2, 3...)
        $leaflet->pages()
            ->orderBy('leaflet_page.sort_order')
            ->get()
            ->values() // resetuje klucze
            ->each(function ($page, $index) use ($leaflet) {
                $leaflet->pages()->updateExistingPivot($page->id, [
                    'sort_order' => $index + 1,
                ]);
            });

        return redirect()
            ->route('admin.leaflets.page.manage', $leaflet)
            ->with('success', 'Zaktualizowano kolejność i usunięto zaznaczone strony.');
    }

    public function import(Request $request, Leaflet $leaflet)
    {
        $pageIds = $request->input('selected_pages', []);

        if (empty($pageIds)) {
            return redirect()->route('admin.leaflets.page.manage');
        }

        // Ustal ostatni sort_order
        $lastOrder = $leaflet->pages()->max('pivot.sort_order') ?? 0;

        foreach ($pageIds as $index => $pageId) {
            $leaflet->pages()->attach($pageId, [
                'sort_order' => $lastOrder + $index + 1,
            ]);
        }

        return redirect()
            ->route('admin.leaflets.page.manage', $leaflet)
            ->with('success', 'Strony zostały dodane.');
    }



}
