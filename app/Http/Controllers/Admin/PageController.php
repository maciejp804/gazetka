<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Leaflet;
use App\Models\Page;
use App\Models\Shop;
use App\Services\ImageService;
use Illuminate\Http\Request;

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
            ['label' => 'Dodaj', 'description' => 'dodaj strony do gazetki (pages, leaflet_pages)',
                'logo' => 'fa-solid fa-plus','url' => route('admin.leaflets.page.create', $leaflet->id)],
            ['label' => 'Edytuj', 'description' => 'edytuj strony w gazetce (pages, leaflet_pages)',
                'logo' => 'fa-solid fa-pen-to-square','url' => route('admin.leaflets.page.edit', $leaflet->id)],
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
            ['label' => 'Dodaj', 'url' => ''],

        ];

        return view('admin.leaflet.page.create', [
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

        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Gazetki', 'url' => route('admin.leaflets.index')],
            ['label' => $leaflet->shop->name.'-'.$leaflet->title, 'url' => route('admin.leaflets.manage', $leaflet->id)],
            ['label' => 'Strony', 'url' => route('admin.leaflets.page.manage', $leaflet->id)],
            ['label' => 'Zmiana kolejności', 'url' => ''],

        ];

        return view('admin.leaflet.page.edit_order', [
            'leaflet' => $leaflet,
            "breadcrumbs" => $breadcrumbs,

        ]);
    }

    public function updateOrder(Request $request, Leaflet $leaflet)
    {
        $pages = $request->input('pages');
        $sortOrder = $request->input('sort_order');

        foreach ($pages as $index => $pageId) {
            $leaflet->pages()->updateExistingPivot($pageId, ['sort_order' => $sortOrder[$index]]);
        }

        return redirect()->route('admin.leaflets.page.manage', $leaflet)->with('success', 'Kolejność stron została zaktualizowana.');
    }

}
