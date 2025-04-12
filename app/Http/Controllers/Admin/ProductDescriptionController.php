<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDescription;
use App\Models\Shop;
use App\Services\ImageService;
use Illuminate\Http\Request;

class ProductDescriptionController extends Controller
{
    public function edit(Request $request, Product $product)
    {
        $product = Product::with('globalDescription')->where('id', $product->id)->first();

        $categories = Category::where('type', 'product')
            ->where('status', 'active')
            ->where('parent_id', '!=', null)
            ->get();

        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Produkty', 'url' => route('admin.products.index')],
            ['label' => mb_ucfirst($product->name), 'url' => route('admin.products.manage', $product->slug)],
            ['label' => 'Dane podstawowe', 'url' => '']
        ];


        return view('admin.product.description.edit', [
            'product' => $product,
            'breadcrumbs' => $breadcrumbs,
            'categories' => $categories,


        ]);

    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'category' => 'required|int',
            'excerpt' => 'nullable|string|max:1000',
            'status' => 'required|in:0,1,2,3,4,5',
            'h1_title' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'manufacturer' => 'nullable|string|max:255',
            'sku' => 'nullable|string|max:255',
        ]);


        $product->update([
            'category_id' => $validated['category'],
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'status' => $validated['status'],
            'manufacturer' => $validated['manufacturer'],
            'sku' => $validated['sku'],
        ]);

        $product->globalDescription->update([
           'excerpt' => $validated['excerpt'],
           'h1_title' => $validated['h1_title'],
           'meta_title' => $validated['meta_title'],
           'meta_description' => $validated['meta_description'],
           'meta_keywords' => $validated['meta_keywords'],
        ]);

        return redirect()->route('admin.products.manage', $product)->with('update', 'Dane podstawowe zaktualizowane.');

    }

    public function editFaq(Product $product)
    {
        $product = Product::with('globalDescription')->where('id', $product->id)->first();


        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Produkty', 'url' => route('admin.products.index')],
            ['label' => mb_ucfirst($product->name), 'url' => route('admin.products.manage', $product->slug)],
            ['label' => 'FAQ', 'url' => '']
        ];


        return view('admin.product.description.edit_faq', [
            'product' => $product,
            'breadcrumbs' => $breadcrumbs,

        ]);

    }
    public function updateFaq(Request $request, Product $product)
    {
        $validated = $request->validate([
            'faq' => 'nullable|array',
            'faq.*.question' => 'nullable|string|max:255',
            'faq.*.answer' => 'nullable|string|max:1000',
        ]);


        $product->globalDescription->update([
            'faq' => $validated['faq'] ?? [],
        ]);

        return redirect()->route('admin.products.manage', $product)->with('update', 'Faq produktu zaktualizowany.');

    }

    public function editExcerpt(Product $product)
    {
        $product = Product::with('globalDescription')->where('id', $product->id)->first();


        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Produkty', 'url' => route('admin.products.index')],
            ['label' => mb_ucfirst($product->name), 'url' => route('admin.products.manage', $product->slug)],
            ['label' => 'Wstęp', 'url' => '']
        ];



        return view('admin.product.description.edit_excerpt', [
            'product' => $product,
            'breadcrumbs' => $breadcrumbs,

        ]);

    }
    public function updateExcerpt(Request $request, Product $product)
    {
        $validated = $request->validate([
            'excerpt' => 'nullable|string|max:1000'
        ]);


        $product->globalDescription->update([
            'excerpt' => $validated['excerpt']
        ]);

        return redirect()->route('admin.products.manage', $product)->with('update', 'Wstęp produktu zaktualizowany.');

    }

    public function editParameters(Product $product)
    {
        $product = Product::with('globalDescription')
            ->where('id', $product->id)
            ->first();


        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Produkty', 'url' => route('admin.products.index')],
            ['label' => mb_ucfirst($product->name), 'url' => route('admin.products.manage', $product->slug)],
            ['label' => 'Parametry', 'url' => '']
        ];



        return view('admin.product.description.edit_parameters', [
            'product' => $product,
            'breadcrumbs' => $breadcrumbs,

        ]);

    }
    public function updateParameters(Request $request, Product $product)
    {
        $validated = $request->validate([
            'parameters' => 'nullable|array',
            'parameters.*.key' => 'nullable|string|max:255',
            'parameters.*.value' => 'nullable|string|max:1000',
        ]);

        $parameters = collect($validated['parameters'] ?? [])
            ->filter(fn($item) => !empty($item['key']) || !empty($item['value']))
            ->pluck('value', 'key') // zamienia na tablicę ['klucz' => 'wartość']
            ->toArray();

        $product->globalDescription->update([
            'parameters' => $parameters,
        ]);

        return redirect()->route('admin.products.manage', $product)->with('update', 'Parametry zostały zaktualizowane.');
    }

    public function editContent(Product $product)
    {
        $product = Product::with('descriptions')->where('id', $product->id)->first();

        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Produkty', 'url' => route('admin.products.index')],
            ['label' => mb_ucfirst($product->name), 'url' => route('admin.products.manage', $product->slug)],
            ['label' => 'Tekst głowny', 'url' => '']
        ];



        return view('admin.product.description.edit_content', [
            'product' => $product,
            'breadcrumbs' => $breadcrumbs,

        ]);

    }

    public function updateContent(Request $request, Product $product)
    {
        $validated = $request->validate([
            'content' => 'required|array',
            'content.*.h2_title' => 'nullable|string|max:255',
            'content.*.h3_title' => 'nullable|string|max:255',
            'content.*.body' => 'nullable|string',
            'content.*.image' => 'nullable|string|max:2048',
        ]);

        $blocks = [];

        foreach ($validated['content'] as $index => $block) {

            $data = [
                'h2_title' => $block['h2_title'] ?? '',
                'h3_title' => $block['h3_title'] ?? '',
                'body' => $block['body'] ?? '',
                'image' => $block['image'] ?? '',
            ];

            $blocks[] = $data;
        }

        $product->descriptions->update([
            'content' => $blocks,
        ]);

        return back()->with('success', 'Zawartość została zaktualizowana.');
    }

    public function updateContentImage(Request $request, Product $product, int $index)
    {

        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $description = $product->globalDescription;

        if (!$description || !isset($description->content[$index])) {
            return back()->withErrors(['error' => 'Nie znaleziono bloku do edycji.']);
        }

        $block = $description->content[$index];

        // Przetwórz obrazek
        $path = 'images/products/content/image_' . uniqid();
        $result = app(ImageService::class)->convertAndStore(
            $request->file('image')->getContent(),
            $path,
            1200,
            800
        );

        if (!empty($result)) {
            // Podmień tylko pole image w konkretnym bloku
            $block['image'] = $path;

            $content = $description->content;
            $content[$index] = $block;

            $description->update([
                'content' => $content
            ]);
        }

        return back()->with('success', 'Obrazek został zaktualizowany.');
    }

    public function indexShop(Product $product)
    {
        $product = Product::with('shopDescriptions', 'shops')->where('id', $product->id)->first();

        $shops = Shop::where('status', 'active')
            ->whereNotNull('name')
            ->orderBy('name')
            ->get()
            ->map(function ($shop) use ($product) {
                $shop->hasDescription = $product->shopDescriptions->contains('shop_id', $shop->id);
                return $shop;
            });

        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Produkty', 'url' => route('admin.products.index')],
            ['label' => mb_ucfirst($product->name), 'url' => route('admin.products.manage', $product)],
            ['label' => 'Sieci handlowe', 'url' => '']
        ];



        return view('admin.product.description.shop.index', [
            'shops' => $shops,
            'product' => $product,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function manageShop(Product $product, Shop $shop)
    {
        $product = Product::with('category', 'shopDescriptions')
            ->where('id', $product->id)->first();

        $shop = Shop::where('slug', $shop->slug)
            ->where('status', 1)
            ->first();


        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Produkty', 'url' => route('admin.products.index')],
            ['label' => mb_ucfirst($product->name), 'url' => route('admin.products.manage', $product)],
            ['label' => 'Sieci handlowe', 'url' => route('admin.products.description.shop.indexShop', $product)],
            ['label' => $shop->name, 'url' => '']
        ];


        $manage = [
            ['label' => 'Dane podstawowe', 'description' => 'nazwa, slug, meat_data (product, product_descriptions)',
                'logo' => 'fa-solid fa-pen-to-square','url' => route('admin.products.description.shop.editShop', [$product, $shop])],
            ['label' => 'FAQ', 'description' => 'dodawanie, edycja i usuwanie FAQ (product_descriptions)',
                'logo' => 'fa-solid fa-circle-question','url' => route('admin.products.description.shop.editShopFaq', [$product, $shop])]
        ];

        return view('admin.product.description.shop.manage', [
            'product' => $product,
            'shop' => $shop,
            'breadcrumbs' => $breadcrumbs,
            'manage' => $manage,
        ]);
    }

    public function editShop(Request $request, Product $product, Shop $shop)
    {

        $product = Product::with('globalDescription', 'shopDescriptions')->where('id', $product->id)
            ->first();

        $shop = Shop::where('slug', $shop->slug)->first();

        $product_description = ProductDescription::where('product_id', $product->id)
            ->where('shop_id', $shop->id)->first();

        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Produkty', 'url' => route('admin.products.index')],
            ['label' => mb_ucfirst($product->name), 'url' => route('admin.products.manage', $product)],
            ['label' => 'Sieci handlowe', 'url' => route('admin.products.description.shop.indexShop', $product)],
            ['label' => $shop->name, 'url' => route('admin.products.description.shop.manageShop', [$product, $shop])],
            ['label' => 'Dane podstawowe', 'url' => '']
        ];

        return view('admin.product.description.shop.edit', [
            'product' => $product,
            'breadcrumbs' => $breadcrumbs,
            'shop' => $shop,
            'product_description' => $product_description,


        ]);

    }

    public function updateShop(Request $request, Product $product, Shop $shop)
    {

        $validated = $request->validate([
            'excerpt' => 'nullable|string|max:1000',
            'h1_title' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        $product_description = ProductDescription::where('product_id', $product->id)
            ->where('shop_id', $shop->id)
            ->first();

        $product_description->update([
            'excerpt' => $validated['excerpt'],
            'h1_title' => $validated['h1_title'],
            'meta_title' => $validated['meta_title'],
            'meta_description' => $validated['meta_description'],
            'meta_keywords' => $validated['meta_keywords'],
        ]);

        return redirect()->route('admin.products.description.shop.manageShop', [$product, $shop])->with('update', 'Dane podstawowe zaktualizowane.');

    }

    public function editShopFaq(Product $product, Shop $shop)
    {
        $product = Product::with('globalDescription', 'shopDescriptions')->where('id', $product->id)
            ->first();

        $shop = Shop::where('slug', $shop->slug)->first();

        $product_description = ProductDescription::where('product_id', $product->id)
            ->where('shop_id', $shop->id)->first();

        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Produkty', 'url' => route('admin.products.index')],
            ['label' => mb_ucfirst($product->name), 'url' => route('admin.products.manage', $product)],
            ['label' => 'Sieci handlowe', 'url' => route('admin.products.description.shop.indexShop', $product)],
            ['label' => $shop->name, 'url' => route('admin.products.description.shop.manageShop', [$product, $shop])],
            ['label' => 'FAQ', 'url' => '']
        ];

        return view('admin.product.description.shop.edit_faq', [
            'product' => $product,
            'breadcrumbs' => $breadcrumbs,
            'shop' => $shop,
            'product_description' => $product_description,


        ]);
    }

    public function updateShopFaq(Request $request, Product $product, Shop $shop)
    {

        $validated = $request->validate([
            'faq' => 'nullable|array',
            'faq.*.question' => 'nullable|string|max:255',
            'faq.*.answer' => 'nullable|string|max:1000',
        ]);

        $product_description = ProductDescription::where('product_id', $product->id)
            ->where('shop_id', $shop->id)
            ->first();

        $product_description->update([
            'faq' => $validated['faq'] ?? [],
        ]);

        return redirect()->route('admin.products.description.shop.manageShop', [$product, $shop])->with('update', 'Faq produktu zaktualizowany.');

    }



    public function addShop(Request $request, Product $product, Shop $shop)
    {

       ProductDescription::create([
           'product_id' => $product->id,
           'shop_id' => $shop->id,
       ]);

        return redirect()->back()->with('success', 'Wpis został dodany.');

    }



}
