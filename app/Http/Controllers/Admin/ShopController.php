<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Shop;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::query()
            ->orderByRaw("CASE WHEN status = 'active' THEN 0 ELSE 1 END")
            ->orderByRaw("CASE WHEN name IS NOT NULL AND name != '' THEN 0 ELSE 1 END")
            ->orderBy('name')->get();

        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Sieci handlowe', 'url' => '']
        ];

        return view('admin.shop.index', [
            'shops' => $shops,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function manage(Shop $shop)
    {
        $shop = Shop::with('category', 'description')->where('id', $shop->id)->first();

        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Sieci handlowe', 'url' => route('admin.shops.index')],
            ['label' => mb_ucfirst($shop->name), 'url' => '']
        ];


        $manage = [
            ['label' => 'Dane podstawowe', 'description' => 'nazwa, slug, meat_data (shop, descriptions)',
                'logo' => 'fa-solid fa-pen-to-square','url' => route('admin.shops.edit', $shop)],
//            ['label' => 'Parametry', 'description' => 'dodawanie, edycja i usuwanie parametrów (product_descriptions)',
//                'logo' => 'fa-solid fa-file-lines','url' => route('admin.products.description.parameters.edit', $product)],
            ['label' => 'Content', 'description' => 'dodawanie, edycja i usuwanie kontentu (descriptions)',
                'logo' => 'fa-solid fa-file-lines','url' => route('admin.shops.description.content.edit', $shop)],
            ['label' => 'FAQ', 'description' => 'dodawanie, edycja i usuwanie FAQ (descriptions)',
                'logo' => 'fa-solid fa-circle-question','url' => route('admin.shops.description.faq.edit', $shop)],
//            ['label' => 'Opisy dla miejscowości', 'description' => 'dane podstawowe, faq,  (product_descriptions)',
//                'logo' => 'fa-solid fa-arrow-pointer','url' => route('admin.shops.description.shop.indexShop', $shop)]
        ];

        return view('admin.shop.manage', [
            'shop' => $shop,
            'breadcrumbs' => $breadcrumbs,

            'manage' => $manage,
        ]);
    }

    public function create()
    {
        $categories = Category::where('status', 'active')
            ->where('type', 'shop')->get();
        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Sieci handlowe', 'url' => route('admin.shops.index')],
            ['label' => 'Nowa sieć', 'url' => ''],
        ];


        return view('admin.shop.create', [
            'breadcrumbs' => $breadcrumbs,
            'categories' => $categories,
        ]);
    }

    public function add(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:60',
            'name_genitive' => 'nullable|string|max:60',
            'name_locative' => 'nullable|string|max:60',
            'slug' => 'required|string|max:60',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive,draft',
        ]);

        if ($request->hasFile('image')) {
            $path = 'images/shops/logo/logo_' . uniqid();
            $result = app(ImageService::class)->convertAndStore(
                $request->file('image')->getContent(),
                $path,
                100,
                100
            );
            if (!empty($result)) {
                $validated['image'] = $path;
            }
        }

        Shop::create([
            'name' => $validated['name'],
            'name_genitive' => $validated['name_genitive'] ?: null,
            'name_locative' => $validated['name_locative'] ?: null,
            'slug' => $validated['slug'],
            'category_id' => $validated['category_id'],
            'status' => $validated['status'],
            'image' => $validated['image'] ?? null,
            'ranking' => 0
        ]);

        return redirect()->route('admin.shops.index')->with('success', 'Sieć została dodana.');

    }

    public function edit(Shop $shop)
    {

        $shop = Shop::query()->find($shop->id);
        $categories = Category::where('status', 'active')
            ->where('type', 'shop')->get();

        $breadcrumbs = [
            ['label' => 'Panel', 'url' => ''],
            ['label' => 'Sieci handlowe', 'url' => route('admin.shops.index')],
            ['label' => $shop->name, 'url' => ''],
        ];

        return view('admin.shop.edit', [
            'shop' => $shop,
            'categories' => $categories,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }



    public function update(Request $request, Shop $shop)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:60',
            'name_genitive' => 'required|string|max:60',
            'name_locative' => 'required|string|max:60',
            'slug' => 'required|string|max:60',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive,draft',
        ]);

        if ($request->hasFile('image')) {
            $path = 'images/shops/logo/logo_' . uniqid();
            $result = app(ImageService::class)->convertAndStore(
                $request->file('image')->getContent(),
                $path,
                100,
                100
            );
            if (!empty($result)) {
                $validated['image'] = $path;
            }
        }

        $shop->update($validated);

        return redirect()->route('admin.shops.manage', $shop)->with('update', 'Sieć została zaktualizowany.');

    }

    public function destroy(Shop $shop)
    {
        // Jeśli chcesz też usunąć obrazek ze storage
        if ($shop->image && Storage::disk('public')->exists($shop->image . '.webp')) {
            Storage::disk('public')->delete([$shop->image . '.webp', $shop->image . '.avif', $shop->image . '.jpg']);
        }

        $shop->delete();

        return redirect()->route('admin.shops.index')->with('success', 'Sieć została usunięta.');
    }
}
