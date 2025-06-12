<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Description;
use App\Models\HotSpot;
use App\Models\Leaflet;
use App\Models\Place;
use App\Models\Product;
use App\Models\ProductDescription;
use App\Models\Shop;
use App\Models\Voucher;
use App\Services\LeafletService;
use App\Services\ProductService;
use App\Services\SortOptionsService;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

class ProductController extends Controller
{
    protected ProductService $productService;
    protected LeafletService $leafletService;

    public function __construct(ProductService $productService, LeafletService $leafletService)
    {
        $this->productService = $productService;
        $this->leafletService = $leafletService;
    }
    public function index()
    {


        $place = Place::where('id', '=', 1172)->first();
//        $location = Cookie::get('user_location');
//        if (!$location) {
//            $placesAll = Place::all();
//            $place = $placesAll->where('id', '=', 1172)->first();
//        } else {
//            $locationData = json_decode($location, true);
//            $place = (object)$locationData;
//        }

        $product_categories = Category::where('status', 'active')
            ->where('type', 'product')
            ->where('parent_id', null)->get();

        $products = $this->productService->getHotSpots(null, null, null,null,15);

        $product_sort = SortOptionsService::getSortOptionsProducts();

        [$leaflets, $count_leaflets] = $this->leafletService->getLeaflets(20);



        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Produkty', 'url' => ''],
        ];

        $descriptions = Description::getByRouteAndPlace(Route::currentRouteName());

        $default_descriptions = Description::getDefaultProducts(Route::currentRouteName());

        return view('main.products.index', data:
            [
                'place' => $place->name,


                // Opisy i dane globalne
                'h1_title' => $descriptions->h1_title ?? $default_descriptions->h1_title ?? "DoMyślny",
                'meta_title'=> $descriptions->meta_title ?? $default_descriptions->meta_title ?? "DoMyślny",
                'meta_description' => $descriptions->meta_description ?? $default_descriptions->meta_description ?? "DoMyślny",
                'descriptions' => $descriptions,
                'excerpt' => $descriptions->excerpt ?? $default_descriptions->excerpt ?? "DoMyślny",


                'breadcrumbs' => $breadcrumbs,

                'product_sort' => $product_sort,
                'products' => $products,
                'leaflets' => $leaflets,
                'product_categories' => $product_categories,
            ]);
    }

    public function indexCategory($category)
    {
        $product_categories = Category::with('children')
            ->where('status', 'active')
            ->where('type', 'product')
            ->where('parent_id', null)
            ->get();


        $category = $product_categories->where('slug', $category)->first();

        if(!$category){
            abort(404);
        }

        $subcategories = $category->children;

        $place = Place::where('id', '=', 1172)->first();
//        $location = Cookie::get('user_location');
//        if (!$location) {
//            $placesAll = Place::all();
//            $place = $placesAll->where('id', '=', 1172)->first();
//        } else {
//            $locationData = json_decode($location, true);
//            $place = (object)$locationData;
//        }


        $products = $this->productService->getHotSpots(null, $category->id, null,null,15);


        [$leaflets, $count_leaflets] = $this->leafletService->getLeaflets(20);

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Produkty', 'url' => route('main.products')],
            ['label' => $category->name, 'url' => '']
        ];

        $product_sort = SortOptionsService::getSortOptionsProducts();


        $descriptions = Description::getByRouteAndPlace(Route::currentRouteName());
        $default_descriptions = Description::getDefaultProducts(Route::currentRouteName(), $category);



        return view('main.products.index_category', data:
            [
                'place' => $place->name,

                // Opisy i dane globalne
                'h1_title' => $descriptions->h1_title ?? $default_descriptions->h1_title ?? "DoMyślny",
                'meta_title'=> $descriptions->meta_title ?? $default_descriptions->meta_title ?? "DoMyślny",
                'meta_description' => $descriptions->meta_description ?? $default_descriptions->meta_description ?? "DoMyślny",
                'descriptions' => $descriptions,
                'excerpt' => $descriptions->excerpt ?? $default_descriptions->excerpt ?? "DoMyślny",


                'breadcrumbs' => $breadcrumbs,
                'product_sort' => $product_sort,
                'products' => $products,
                'leaflets' => $leaflets,
                'product_categories' => $product_categories,
                'category' => $category,
                'subcategories' => $subcategories,
                'subcategory' => 'all',
            ]);
    }

    public function indexSubCategory($category, $subcategory)
    {
        $product_categories = Category::with('children')
            ->where('type', 'product')
            ->where('status', 'active')
            ->where('parent_id', null)
            ->get();


        $category = $product_categories->where('slug', $category)->first();

        $subcategory = $category->children->where('slug', $subcategory)->first();

        if(!$subcategory || !$category) {
            abort(404);
        }
        $sucategories = $category->children;

        $place = Place::where('id', '=', 1172)->first();
//        $location = Cookie::get('user_location');
//        if (!$location) {
//            $placesAll = Place::all();
//            $place = $placesAll->where('id', '=', 1172)->first();
//        } else {
//            $locationData = json_decode($location, true);
//            $place = (object)$locationData;
//        }

        $products = $this->productService->getHotSpots(null,null, $subcategory->id, null,15);

        [$leaflets, $count_leaflets] = $this->leafletService->getLeaflets(20);

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Produkty', 'url' => route('main.products')],
            ['label' => $category->name, 'url' => route('main.products.category', $category->slug)],
            ['label' => $subcategory->name, 'url' => '']
        ];

        $product_sort = SortOptionsService::getSortOptionsProducts();

        $descriptions = Description::getByRouteAndPlace(Route::currentRouteName());
        $default_descriptions = Description::getDefaultProducts(Route::currentRouteName(), $category, $subcategory);



        return view('main.products.index_category', data:
            [
                'place' => $place->name,

                // Opisy i dane globalne
                'h1_title' => $descriptions->h1_title ?? $default_descriptions->h1_title ?? "DoMyślny",
                'meta_title'=> $descriptions->meta_title ?? $default_descriptions->meta_title ?? "DoMyślny",
                'meta_description' => $descriptions->meta_description ?? $default_descriptions->meta_description ?? "DoMyślny",
                'descriptions' => $descriptions,
                'excerpt' => $descriptions->excerpt ?? $default_descriptions->excerpt ?? "DoMyślny",


                'breadcrumbs' => $breadcrumbs,
                'product_sort' => $product_sort,
                'products' => $products,
                'leaflets' => $leaflets,
                'product_categories' => $product_categories,
                'category' => $category,
                'subcategories' => $sucategories,
                'subcategory' => $subcategory->id,
            ]);
    }

    public function show($slug)
    {
        $product = Product::with('ratings', 'leaflets', 'category')
            ->where('slug', $slug)
            ->where('status', 1)
            ->first();



        if(!$product)
        {
            abort(404);
        }


        $productInLeaflets = $this->productService->getProductOccurrences($product->id);

//        dd($productInLeaflets);

        $averageRating = $product->averageRating();
        $ratingCount = $product->ratingCount();

        $place = Place::where('id', '=', 1172)->first();
//        $location = Cookie::get('user_location');
//        if (!$location) {
//            $placesAll = Place::all();
//            $place = $placesAll->where('id', '=', 1172)->first();
//        } else {
//            $locationData = json_decode($location, true);
//            $place = (object)$locationData;
//        }

        $products = $this->productService->getHotSpots(null,null, $product->category_id, null,null);

        $vouchers = Voucher::with('voucherStore')->get();

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Produkty', 'url' => route('main.products')],
            ['label' => mb_ucfirst($product->name), 'url' => ''],
        ];

        $descriptions = ProductDescription::getByProductAndShop($product->id);

        $default_descriptions = ProductDescription::getDefaultProduct(Route::currentRouteName(), $product);

        return view('main.products.show', data:
            [
                //Lokalizacja
                'place' => $place->name,

                // Opisy i dane globalne
                'h1_title' => $descriptions->h1_title ?? $default_descriptions->h1_title ?? "DoMyślny",
                'meta_title'=> $descriptions->meta_title ?? $default_descriptions->meta_title ?? "DoMyślny",
                'meta_description' => $descriptions->meta_description ?? $default_descriptions->meta_description ?? "DoMyślny",
                'descriptions' => $descriptions,
                'excerpt' => $descriptions->excerpt ?? $default_descriptions->excerpt ?? "DoMyślny",
                'name' => $slug,
                'breadcrumbs' => $breadcrumbs,

                //Products
                'products' => $products,
                'product' => $product,
                'productInLeaflets' => $productInLeaflets,

                // Rating
                'averageRating' => $averageRating,
                'ratingCount' => $ratingCount,
                'model' => "Product",

                'vouchers' => $vouchers,
            ]);
    }

    public function showSubdomain($subdomain, $slug)
    {

        $shop = Shop::where('slug', $subdomain)
            ->where('status', 'active')
            ->first();

        $product = Product::with(['category', 'descriptions' => function($q) use ($shop) {
            $q->where('shop_id', $shop->id);
        }])
            ->where('slug', $slug)
            ->first();

        if(!$product || !$shop)
        {
            abort(404);
        }


        $productsInShopLeaflets = $this->productService->productInLeaflet($product, $shop)->filter(function ($item) {
                return $item['is_in_shop'];  // Tylko produkty z tego sklepu
            });


        $productsInNoShopLeaflets = $this->productService->productInLeaflet($product, $shop)->filter(function ($item) {
            return !$item['is_in_shop'];  // Tylko produkty z tego sklepu
        });


        $place = Place::where('id', '=', 1172)->first();
//        $location = Cookie::get('user_location');
//        if (!$location) {
//            $placesAll = Place::all();
//            $place = $placesAll->where('id', '=', 1172)->first();
//        } else {
//            $locationData = json_decode($location, true);
//            $place = (object)$locationData;
//        }


        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => $shop->name, 'url' => route('subdomain.index', ['subdomain' => $shop->slug])],
            ['label' => mb_ucfirst($product->name), 'url' => ""]
        ];


        $descriptions = ProductDescription::getByProductAndShop($product->id, $shop->id);

        $default_descriptions = ProductDescription::getDefaultProduct(Route::currentRouteName(), $product, $shop);

        return view('subdomain.products.show', data:
            [
                //Zmienne globalne strony
                'subdomain' => $subdomain,
                'product' => $product,
                'shop' => $shop,

                //Lokalizacja
                'place' => $place,

                // Opisy i dane globalne
                'h1_title' => $descriptions->h1_title ?? $default_descriptions->h1_title ?? "DoMyślny",
                'meta_title'=> $descriptions->meta_title ?? $default_descriptions->meta_title ?? "DoMyślny",
                'meta_description' => $descriptions->meta_description ?? $default_descriptions->meta_description ?? "DoMyślny",
                'descriptions' => $descriptions,
                'excerpt' => $descriptions->excerpt ?? $default_descriptions->excerpt ?? "DoMyślny",
                'name' => $slug,
                'breadcrumbs' => $breadcrumbs,


                'productsInShopLeaflets' => $productsInShopLeaflets,
                'productsInNoShopLeaflets' => $productsInNoShopLeaflets,


            ]);
    }

    protected function flattenedCollection($products)
    {
        $flattenedCollection = $products->getCollection()->flatMap(function ($click) {
            return $click->page->leaflets->map(function ($leaflet) use ($click) {
                return [
                    'click_id'      => $click->id,
                    'valid_from'    => $click->valid_from,
                    'valid_to'      => $click->valid_to,
                    'page_id'       => $click->page->id,
                    'page_image'    => $click->page->image_path,
                    'leaflet_id'    => $leaflet->id,
                    'shop_image'    => $leaflet->shop ? $leaflet->shop->image : null,
                    'shop_name'     => $leaflet->shop ? $leaflet->shop->name : null,
                    'shop_slug'     => $leaflet->shop ? $leaflet->shop->slug : null,
                    'product_id'    => $click->leafletProduct->product ? $click->leafletProduct->product->id : null,
                    'product_name'  => $click->leafletProduct->product ? $click->leafletProduct->product->name : null,
                    'product_slug'  => $click->leafletProduct->product ? $click->leafletProduct->product->slug : null,
                    'product_image' => $click->leafletProduct->product ? $click->leafletProduct->product->image : null,
                    'price'         => $click->leafletProduct ? $click->leafletProduct->price : null,
                    'promo_price'   => $click->leafletProduct ? $click->leafletProduct->promo_price : null,
                ];
            });
        });

        // Podmiana kolekcji w paginatorze – zachowujemy metadane paginacji
        return $products->setCollection($flattenedCollection);
    }


}
