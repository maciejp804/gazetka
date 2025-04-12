<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Voucher;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(50);

        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Produkty', 'url' => '']
        ];



        return view('admin.product.index', [
            'products' => $products,
            "breadcrumbs" => $breadcrumbs,

        ]);
    }

    public function manage(Product $product)
    {
        $product = Product::with('category', 'globalDescription')->where('id', $product->id)->first();

        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Produkty', 'url' => route('admin.products.index')],
            ['label' => mb_ucfirst($product->name), 'url' => '']
        ];


        $manage = [
            ['label' => 'Dane podstawowe', 'description' => 'nazwa, slug, meat_data (product, product_descriptions)',
                'logo' => 'fa-solid fa-pen-to-square','url' => route('admin.products.description.edit', $product)],
            ['label' => 'Parametry', 'description' => 'dodawanie, edycja i usuwanie parametrów (product_descriptions)',
                'logo' => 'fa-solid fa-file-lines','url' => route('admin.products.description.parameters.edit', $product)],
            ['label' => 'Content', 'description' => 'dodawanie, edycja i usuwanie kontentu (product_descriptions)',
                'logo' => 'fa-solid fa-file-lines','url' => route('admin.products.description.content.edit', $product)],
            ['label' => 'FAQ', 'description' => 'dodawanie, edycja i usuwanie FAQ (product_descriptions)',
                'logo' => 'fa-solid fa-circle-question','url' => route('admin.products.description.faq.edit', $product)],
            ['label' => 'Opisy dla sieci handlowych', 'description' => 'dane podstawowe, faq,  (product_descriptions)',
                'logo' => 'fa-solid fa-arrow-pointer','url' => route('admin.products.description.shop.indexShop', $product)]
        ];

        return view('admin.product.manage', [
            'product' => $product,
            'breadcrumbs' => $breadcrumbs,

            'manage' => $manage,
        ]);
    }

    public function uploadImage(Request $request, Product $product)
    {

        try {
            $request->validate([
                'image' => 'required|image|max:10000',
            ]);


            $pathWithoutExtension = 'images/products/logo/logo_' . uniqid();

            $result = app(ImageService::class)->convertAndStore(
                $request->file('image')->getContent(),
                $pathWithoutExtension,
                200,
                200
            );

            if (!empty($result)) {
                // zapisujemy tylko path bez rozszerzenia

                if ($product->image && Storage::disk('public')->exists($product->image . '.webp')) {
                    Storage::disk('public')->delete([$product->image . '.webp', $product->image . '.avif', $product->image . '.jpg']);
                }

                $product->update([
                    'image' => $pathWithoutExtension
                ]);
            }

            return back()->with('success', 'Grafika została zapisana.');
        } catch (\Throwable $e) {
            Log::error('Błąd podczas aktualizacji zdjęcia produktu', [
                'product_id' => $product->id,
                'message' => $e->getMessage()
            ]);
            return back()->with('error', 'Wystąpił błąd przy zapisie grafiki.');
        }

    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        $items = Product::where('name', 'like', "{$query}%")->paginate(50);

        $items->setCollection(
            $items->getCollection()->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'image' => $product->image,
                ];
            })
        );


        
        return response()->json([
            'html' => view('components.admin.product-item', compact('items'))->render()
        ]);
    }

    public function destroy(Product $product)
    {
        // Jeśli chcesz też usunąć obrazek ze storage
        if ($product->image && Storage::disk('public')->exists($product->image . '.webp')) {
            Storage::disk('public')->delete([$product->image . '.webp', $product->image . '.avif', $product->image . '.jpg']);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produkt została usunięty.');
    }
}
