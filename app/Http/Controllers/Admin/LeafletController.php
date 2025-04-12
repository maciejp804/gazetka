<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Leaflet;
use App\Models\LeafletCover;
use App\Models\Shop;
use App\Services\ImageService;
use Illuminate\Http\Request;
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

        $leaflets = $this->getLeaflets();

        $shops = Shop::where('status', 1)->get();
        $categories = Category::where('status', 'active')->where('type', 'shop')->get();

        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Gazetki', 'url' => '']
        ];



        return view('admin.leaflet.create', [
            'leaflets' => $leaflets,
            'shops' => $shops,
            'categories' => $categories,
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
            ['label' => 'Edytuj', 'description' => 'dane podstawowe (tytuł, opis, status, powiązany sklep, daty)',
              'logo' => 'fa-solid fa-pen-to-square','url' => route('admin.leaflets.edit', $leaflet->id)],
            ['label' => 'Opisz', 'description' => 'przypisanie produktów do gazetki (leaflet_products)',
                'logo' => 'fa-solid fa-keyboard','url' => route('admin.leaflets.page.product.create', $leaflet->id)],
            ['label' => 'Strony', 'description' => 'zarządzanie stronami, dodawanie, usuwanie, kolejność (relacja leaflet_page z sort_order)',
                'logo' => 'fa-solid fa-file','url' => route('admin.leaflets.page.manage', $leaflet->id)],
            ['label' => 'Klikalne obszary', 'description' => 'współrzędne i ceny produktów (relacja page_click z page_id, leaflet_product_id)',
                'logo' => 'fa-solid fa-arrow-pointer','url' => route('admin.leaflets.edit', $leaflet->id)],
            ['label' => 'Reklamy', 'description' => 'reklamy i inserty (relacja leaflet_ads, leaflet_inserts)',
                'logo' => 'fa-solid fa-rectangle-ad','url' => route('admin.leaflets.edit', $leaflet->id)],
            ['label' => 'Pierwsza strona', 'description' => 'możliwość zmiany grafiki okładki (relacja leaflet_cover)',
                'logo' => 'fa-solid fa-book','url' => route('admin.leaflets.edit', $leaflet->id)]
        ];

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
        ]);



        $leaflet->update($validated);

        return redirect()->route('admin.leaflets.manage', $leaflet)->with('update', 'Dane gazetki zaktualizowane.');
    }

    public function destroy(Leaflet $leaflet)
    {
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

    protected function getLeaflets($query = null)
    {
        $queryBuilder = Leaflet::with('shop', 'cover')
            ->join('leaflet_covers', 'leaflets.id', '=', 'leaflet_covers.leaflet_id')
            ->select('leaflets.*'); // Dodaj to, aby uniknąć konfliktu kolumn z join

        if ($query !== null) {
            $queryBuilder->where(function ($q) use ($query) {
                $q->where('leaflets.title', 'like', "%{$query}%")
                    ->orWhereHas('shop', fn($q) => $q->where('name', 'like', "%{$query}%"));
            });
        }

        $queryBuilder->orderBy('leaflets.created_at', 'desc');

        $leaflets = $queryBuilder->get()->map(fn($leaflet) => [
            'id' => $leaflet->id,
            'title' => $leaflet->title,
            'cover' => optional($leaflet->cover)->webp_path,
            'valid_from' => $leaflet->valid_from,
            'valid_to' => $leaflet->valid_to,
            'shop_name' => optional($leaflet->shop)->name,
        ]);

        return $leaflets;
    }

}
