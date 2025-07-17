<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\HotSpot;
use App\Models\Leaflet;
use App\Models\LeafletCover;
use App\Models\Product;
use App\Models\Shop;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LeafletController extends Controller
{

    protected ImageService $imageService;
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }
    public function index()
    {

        $leaflets = $this->getLeaflets();

        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Gazetki', 'url' => '']
        ];



        return view('admin.leaflet.index', [
            'leaflets' => $leaflets,
            "breadcrumbs" => $breadcrumbs,

            ]);
    }

    public function create()
    {

        $shops = Shop::where('status', 1)->orderBy('name')->get();


        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Gazetki', 'url' => '']
        ];



        return view('admin.leaflet.create', [

            'shops' => $shops,
            "breadcrumbs" => $breadcrumbs,

        ]);
    }

    public function add(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'shop_id' => 'required|integer',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date',
            'display_from' => 'required|date',
            'display_to' => 'required|date',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:published,archive,draft',
            'require_age_verification' => 'nullable|in:0,1',
            'for_all_stores' => 'nullable|in:0,1',
            'pinned' => 'nullable|in:0,1',
            'priority' => 'nullable|in:0,1,2,3,4,5',
            'number' => 'nullable|integer',

        ]);

        $width = 250;
        $height = 335;

        $shop = Shop::find($request->shop_id);

        $number = $validated['number'] ?? 0;
        $require_age_verification = $validated['require_age_verification'] ?? 0;
        $for_all_stores = $validated['for_all_stores'] ?? 1;
        $pinned = $validated['pinned'] ?? 0;
        $priority = $validated['priority'] ?? 1;

        if ($request->hasFile('image')) {
            $path = 'leaflets/covers/' . uniqid();
            $result = app(ImageService::class)->convertAndStore(
                $request->file('image')->getContent(),
                $path,
                $width,
                $height
            );
            if (!empty($result)) {
                $validated['image'] = $path;
                $width = $result['width'];
                $height = $result['height'];
            }
        }



        $leaflet = Leaflet::create([
            'number' => $number,
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'shop_id' => $validated['shop_id'],
            'valid_from' => $validated['valid_from'],
            'valid_to' => $validated['valid_to'],
            'display_from' => $validated['display_from'],
            'display_to' => $validated['display_to'],
            'status' => $validated['status'],
            'require_age_verification' => $require_age_verification,
            'for_all_stores' => $for_all_stores,
            'pinned' => $pinned,
            'priority' => $priority,
        ]);



        LeafletCover::create([
            'leaflet_id' => $leaflet->id,
            'original_name' => '',
            'path' => $validated['image'],
            'webp_path' => $validated['image'],
            'avif_path' => $validated['image'],
            'width' => $width,
            'height' => $height,
            'alt_text' => $shop->name .' gazetka promocyjna '. $leaflet->title .' | Oferta ważna  ' . monthReplace($validated['valid_from'], 'excerpt') . ' - ' . monthReplace($validated['valid_to'], 'excerpt'),
        ]);

        return redirect()->route('admin.leaflets.index')->with('success', 'Dodano nową gazetkę!');
    }

    public function manage(Leaflet $leaflet)
    {
        $leaflet = Leaflet::with('shop', 'cover')->where('id', $leaflet->id)->first();


        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Gazetki', 'url' => route('admin.leaflets.index')],
            ['label' => $leaflet->shop->name.'-'.$leaflet->title, 'url' => '']

        ];

        $shops = Shop::where('status', 'active')->get();

        $manage = [
            ['label' => 'Opisz', 'description' => 'przypisanie produktów do gazetki (leaflet_products)',
                'logo' => 'fa-solid fa-keyboard','url' => route('admin.leaflets.hotspots.create', $leaflet->id)],
            ['label' => 'Opisz OCR', 'description' => 'przypisanie produktów do gazetki (leaflet_products)',
                'logo' => 'fa-solid fa-keyboard','url' => route('admin.leaflets.hotspots.add.auto', $leaflet->id)],
            ['label' => 'Strony', 'description' => 'zarządzanie stronami, dodawanie, usuwanie, kolejność (relacja leaflet_page z sort_order)',
                'logo' => 'fa-solid fa-file','url' => route('admin.leaflets.page.manage', $leaflet->id)],
            ['label' => 'Klikalne obszary', 'description' => 'współrzędne i ceny produktów (relacja page_click z page_id, leaflet_product_id)',
                'logo' => 'fa-solid fa-arrow-pointer','url' => route('admin.leaflets.edit', $leaflet->id)],
            ['label' => 'Reklamy', 'description' => 'reklamy i inserty (relacja leaflet_ads, leaflet_inserts)',
                'logo' => 'fa-solid fa-rectangle-ad','url' => route('admin.leaflets.edit', $leaflet->id)],
            ['label' => 'Pierwsza strona', 'description' => 'możliwość zmiany grafiki okładki (relacja leaflet_cover)',
                'logo' => 'fa-solid fa-book','url' => route('admin.leaflets.edit', $leaflet->id)]
        ];

        if ($leaflet->cover !== null) {
           $array =  ['label' => 'Edytuj', 'description' => 'dane podstawowe (tytuł, opis, status, powiązany sklep, daty)',
                'logo' => 'fa-solid fa-pen-to-square','url' => route('admin.leaflets.edit', $leaflet->id)];

            array_unshift( $manage, $array);

            }

        return view('admin.leaflet.manage', [
            'leaflet' => $leaflet,
            'breadcrumbs' => $breadcrumbs,
            'shops' => $shops,
            'manage' => $manage,
        ]);
    }

    public function edit(Leaflet $leaflet)
    {
        $leaflet = Leaflet::with('shop', 'cover')->where('id', $leaflet->id)->first();
        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Gazetki', 'url' => route('admin.leaflets.index')],
            ['label' => 'Gazetka ' . $leaflet->shop->name, 'url' => route('admin.leaflets.manage', $leaflet->id)],
            ['label' => 'Edytuj', 'url' => '']
        ];

        $shops = Shop::where('status', 'active')->get();

        return view('admin.leaflet.edit', [
            'leaflet' => $leaflet,
            'breadcrumbs' => $breadcrumbs,
            'shops' => $shops
        ]);

    }

    public function update(Request $request, Leaflet $leaflet)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:120',
            'slug' => 'required|string|max:120',
            'shop_id' => 'required|exists:shops,id',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date',
            'display_from' => 'required|date',
            'display_to' => 'required|date',
            'require_age_verification' => 'in:0,1',
            'pinned' => 'in:0,1',
            'priority' => 'in:0,1,2,3,4,5',
            'status' => 'in:published,draft,archive',
            'for_all_stores' => 'in:0,1',
            'description_short' => 'nullable|string',
            'description_long' => 'nullable|string',
            'number' => 'nullable|numeric',
        ]);



        $leaflet->update($validated);

        return redirect()->route('admin.leaflets.manage', $leaflet)->with('update', 'Dane gazetki zaktualizowane.');
    }

    public function destroy(Leaflet $leaflet)
    {

        $leaflet = Leaflet::with('pages.leaflets', 'cover')->find($leaflet->id);

        foreach ($leaflet->pages as $page) {
            if ($page->leaflets()->count() === 1) {
                // Strona tylko dla tej gazetki

                if ($page->image_path) {
                    foreach (['webp', 'avif', 'jpg'] as $ext) {
                        $file = $page->image_path . '.' . $ext;
                        if (Storage::disk('public')->exists($file)) {
                            Storage::disk('public')->delete($file);
                        }
                    }
                }

                $leaflet->pages()->detach($page->id);
                $page->delete();
            } else {
                // Powiązana z inną gazetką – tylko odpinamy
                $leaflet->pages()->detach($page->id);
            }

        }

        // Jeśli chcesz też usunąć obrazek ze storage
        if ($leaflet->cover && Storage::disk('public')->exists($leaflet->cover->path . '.jpg')) {
            Storage::disk('public')->delete([$leaflet->cover->webp_path . '.webp', $leaflet->cover->avif_path. '.avif', $leaflet->cover->path . '.jpg']);
        }



        $leaflet->delete();

        return redirect()->route('admin.leaflets.index')->with('success', 'Gazetka została usunięta.');
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        $items = $this->getLeaflets($query);

        return response()->json([
            'html' => view('components.admin.leaflet-item', compact('items'))->render()
        ]);
    }

    public function uploadImage(Request $request, Leaflet $leaflet)
    {
        try {
            // Walidacja pliku
            $request->validate([
                'image' => 'required|image|max:10000',
            ]);

            // Ścieżka do zapisania obrazu
            $path = 'leaflets/covers/' . uniqid();

            // Ładowanie istniejącego leaflet z powiązanym cover i shop
            $leaflet = Leaflet::with('cover', 'shop')->find($leaflet->id);

            // Upewnij się, że leaflet istnieje
            if (!$leaflet) {
                return back()->with('error', 'Nie znaleziono gazetki.');
            }

            // Przetwarzanie obrazu
            $result = app(ImageService::class)->convertAndStore(
                $request->file('image')->getContent(),
                $path,
                250,
                335
            );

            // Jeśli konwersja obrazu zakończyła się sukcesem
            if (!empty($result)) {
                // Sprawdzanie, czy istnieje powiązany cover i czy ma poprawną ścieżkę
                if ($leaflet->cover && $leaflet->cover->path && Storage::disk('public')->exists($leaflet->cover->path . '.webp')) {
                    // Usuwamy stare pliki, jeśli istnieją
                    Storage::disk('public')->delete([
                        $leaflet->cover->path . '.webp',
                        $leaflet->cover->path . '.avif',
                        $leaflet->cover->path . '.jpg'
                    ]);
                }

                // Uaktualniamy ścieżkę do nowego obrazu
                if ($leaflet->cover) {
                    $leaflet->cover->update([
                        'path' => $path,
                        'avif_path' => $path,
                        'webp_path' => $path
                    ]);
                } else {
                    // Jeśli brak cover, tworzymy nowy
                    LeafletCover::create([
                        'leaflet_id' => $leaflet->id,
                        'original_name' => '',
                        'path' => $path,
                        'avif_path' => $path,
                        'webp_path' => $path,
                        'width' => $result['width'],
                        'height' => $result['height'],
                        'alt_text' =>
                            $leaflet->shop->name .' gazetka promocyjna '. $leaflet->title .' | Oferta ważna  ' . monthReplace($leaflet->valid_from, 'excerpt') . ' - ' . monthReplace($leaflet->valid_to, 'excerpt'),
                    ]);
                }
            }

            // Zwracamy komunikat o sukcesie
            return back()->with('success', 'Grafika została zapisana.');
        } catch (\Throwable $e) {
            // Logowanie błędu
            Log::error('Błąd podczas aktualizacji zdjęcia produktu', [
                'product_id' => $leaflet->id,
                'message' => $e->getMessage()
            ]);

            // Zwracamy komunikat o błędzie
            return back()->with('error', 'Wystąpił błąd przy zapisie grafiki.');
        }
    }






    protected function getLeaflets($query = null)
    {
        $queryBuilder = Leaflet::with('shop', 'pages.hotSpots');

        if ($query !== null) {
            $queryBuilder->where(function ($q) use ($query) {
                $q->where('leaflets.title', 'like', "%{$query}%")
                    ->orWhereHas('shop', fn($q) => $q->where('name', 'like', "%{$query}%"));
            });
        }

        $queryBuilder->orderBy('created_at', 'desc');

        $leaflets = $queryBuilder->paginate(32);

        return $leaflets;
    }

}
