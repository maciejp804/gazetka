<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Leaflet;
use App\Models\PageClick;
use App\Models\Place;
use App\Models\Product;
use App\Models\ProductDescription;
use App\Models\Shop;
use App\Models\Voucher;
use App\Services\ProductService;
use App\Services\SortOptionsService;
use App\Services\StaticDescriptions;
use Illuminate\Support\Facades\Cookie;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function index()
    {

        $location = Cookie::get('user_location');
        if (!$location) {
            $placesAll = Place::all();
            $place = $placesAll->where('id', '=', 1172)->first();
        } else {
            $locationData = json_decode($location, true);
            $place = (object)$locationData;
        }

        $product_categories = Category::where('status', 'active')
            ->where('type', 'product')
            ->where('parent_id', null)->get();

        $products = $this->productService->getProducts('normal', null, null,null,10);

        $product_sort = SortOptionsService::getSortOptionsProducts();


        $leaflets = Leaflet::with('shop')->where('valid_to','>=',now())->get();
        $leaflets = $leaflets->sortByDesc('created_at')->take(40);

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Produkty', 'url' => ''],
        ];

        return view('main.products.index', data:
            [
                'place' => $place->name,


                'h1_title'=> '<strong>Produkty</strong> w gazetkach promocyjnych',
                'page_title'=> 'Gazetki promocyjne, nowe i nadchodzące promocje | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',

                'descriptions' => null,
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

        $location = Cookie::get('user_location');
        if (!$location) {
            $placesAll = Place::all();
            $place = $placesAll->where('id', '=', 1172)->first();
        } else {
            $locationData = json_decode($location, true);
            $place = (object)$locationData;
        }


        $products = $this->productService->getProducts('normal', $category->id, null,null,10);


        $leaflets = Leaflet::with('shop')->where('valid_to','>=',now())->get();
        $leaflets = $leaflets->sortByDesc('created_at')->take(40);

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Produkty', 'url' => route('main.products')],
            ['label' => $category->name, 'url' => '']
        ];

        $product_sort = SortOptionsService::getSortOptionsProducts();
        $static_description = StaticDescriptions::getDescriptions();
        return view('main.products.index_category', data:
            [
                'place' => $place->name,


                'h1_title'=> 'Produkty w gazetkach promocyjnych - kategoria <strong>'.strtolower($category->name).'</strong>',
                'page_title'=> 'Gazetki promocyjne, nowe i nadchodzące promocje | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',
                'static_description' => $static_description,
                'descriptions' => null,
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

        $location = Cookie::get('user_location');
        if (!$location) {
            $placesAll = Place::all();
            $place = $placesAll->where('id', '=', 1172)->first();
        } else {
            $locationData = json_decode($location, true);
            $place = (object)$locationData;
        }

        $products = $this->productService->getProducts('normal',null, $subcategory->id, null,10);

        $leaflets = Leaflet::with('shop')->where('valid_to','>=',now())->get();
        $leaflets = $leaflets->sortByDesc('created_at')->take(40);

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Produkty', 'url' => route('main.products')],
            ['label' => $category->name, 'url' => route('main.products.category', $category->slug)],
            ['label' => $subcategory->name, 'url' => '']
        ];

        $product_sort = SortOptionsService::getSortOptionsProducts();
        $static_description = StaticDescriptions::getDescriptions();
        return view('main.products.index_category', data:
            [
                'place' => $place->name,


                'h1_title'=> 'Produkty w gazetkach promocyjnych - kategoria <strong>'.strtolower($category->name).'</strong>',
                'page_title'=> 'Gazetki promocyjne, nowe i nadchodzące promocje | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',
                'static_description' => $static_description,
                'descriptions' => null,
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
        $product = Product::with('ratings', 'leaflets', 'category')->where('slug', $slug)->first();

        if(!$product)
        {
            abort(404);
        }

        $productInLeaflets = $this->productService->getProductOccurrences($product->id);

        $averageRating = $product->averageRating();
        $ratingCount = $product->ratingCount();

        $location = Cookie::get('user_location');
        if (!$location) {
            $placesAll = Place::all();
            $place = $placesAll->where('id', '=', 1172)->first();
        } else {
            $locationData = json_decode($location, true);
            $place = (object)$locationData;
        }

        $products = $this->productService->getProducts('normal',null, $product->category_id, null,null);

        $vouchers = Voucher::with('voucherStore')->get();

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Produkty', 'url' => route('main.products')],
            ['label' => mb_ucfirst($product->name), 'url' => ''],
        ];

        $descriptions = ProductDescription::with('products')
            ->where('product_id', $product->id)
            ->first();

        return view('main.products.show', data:
            [
                //Lokalizacja
                'place' => $place->name,

                'h1_title'=> mb_ucfirst($product->name).' - promocje w sklepach',
                'page_title'=> mb_ucfirst($product->name).' - promocje, aktualna cena w sklepach | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',
                'name' => $slug,
                'descriptions' => $descriptions,
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
        $shops = Shop::all();
        $shop = $shops->where('slug', $subdomain)->first();

        $product = Product::with(['category', 'descriptions' => function($q) use ($shop) {
            $q->where('shop_id', $shop->id);
        }])
            ->where('slug', $slug)
            ->first();

        if(!$product || !$shop)
        {
            abort(404);
        }
        $leaflets = Leaflet::with('shop')->get();

        $productsInShopLeaflets = Leaflet::with('shop')
            ->where('shop_id', $shop->id)
            ->where('valid_to', '>=', now()->toDateString()) // Gazetka musi być nadal ważna
            ->whereHas('pages.clicks.leafletProduct', function ($query) use ($product) {
                $query->where('product_id', $product->id)
                    ->where('valid_from', '<=', now()->toDateString()) // Oferta już aktywna
                    ->where('valid_to', '>=', now()->toDateString()); // Oferta nadal ważna
            })->with([
                'pages' => function ($query) use ($product) {
                    $query->whereHas('clicks.leafletProduct', function ($q) use ($product) {
                        $q->where('product_id', $product->id)
                            ->where('valid_from', '<=', now()->toDateString())
                            ->where('valid_to', '>=', now()->toDateString());
                    });
                },
                'pages.clicks' => function ($query) use ($product) {
                    $query->whereHas('leafletProduct', function ($q) use ($product) {
                        $q->where('product_id', $product->id)
                            ->where('valid_from', '<=', now()->toDateString())
                            ->where('valid_to', '>=', now()->toDateString());
                    });
                },
                'pages.clicks.leafletProduct.product'
            ])
            ->get()
            ->map(function ($leaflet) {
                return [
                    'leaflet_id' => $leaflet->id,
                    'name' => $leaflet->shop->name ?? 'Brak sklepu',
                    'slug' => $leaflet->shop->slug ?? 'Brak sklepu',
                    'shop_image'=> $leaflet->shop->image,
                    'pages' => $leaflet->pages->map(function ($page) {
                        return [
                            'page_number' => $page->page_number,
                            'page_image' => $page->image_path,
                            'clicks' => $page->clicks->map(function ($click) {
                                return [
                                    'valid_from' => $click->valid_from,
                                    'valid_to' => $click->valid_to,
                                ];
                            }),
                        ];
                    }),
                ];
            });


        $productsInNoShopLeaflets = Leaflet::with('shop')
            ->where('shop_id','!=', $shop->id)
            ->where('valid_to', '>=', now()->toDateString()) // Gazetka musi być nadal ważna
            ->whereHas('pages.clicks.leafletProduct', function ($query) use ($product) {
                $query->where('product_id', $product->id)
                    ->where('valid_from', '<=', now()->toDateString()) // Oferta już aktywna
                    ->where('valid_to', '>=', now()->toDateString()); // Oferta nadal ważna
            })->with([
                'pages' => function ($query) use ($product) {
                    $query->whereHas('clicks.leafletProduct', function ($q) use ($product) {
                        $q->where('product_id', $product->id)
                            ->where('valid_from', '<=', now()->toDateString())
                            ->where('valid_to', '>=', now()->toDateString());
                    });
                },
                'pages.clicks' => function ($query) use ($product) {
                    $query->whereHas('leafletProduct', function ($q) use ($product) {
                        $q->where('product_id', $product->id)
                            ->where('valid_from', '<=', now()->toDateString())
                            ->where('valid_to', '>=', now()->toDateString());
                    });
                },
                'pages.clicks.leafletProduct.product'
            ])
            ->get()
            ->map(function ($leaflet) {
                return [
                    'leaflet_id' => $leaflet->id,
                    'name' => $leaflet->shop->name ?? 'Brak sklepu',
                    'slug' => $leaflet->shop->slug ?? 'Brak sklepu',
                    'shop_image'=> $leaflet->shop->image,
                    'pages' => $leaflet->pages->map(function ($page) {
                        return [
                            'page_number' => $page->page_number,
                            'page_image' => $page->image_path,
                            'clicks' => $page->clicks->map(function ($click) {
                                return [
                                    'valid_from' => $click->valid_from,
                                    'valid_to' => $click->valid_to,
                                ];
                            }),
                        ];
                    }),
                ];
            });

        $location = Cookie::get('user_location');
        if (!$location) {
            $placesAll = Place::all();
            $place = $placesAll->where('id', '=', 1172)->first();
        } else {
            $locationData = json_decode($location, true);
            $place = (object)$locationData;
        }


        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => $shop->name, 'url' => route('subdomain.index', ['subdomain' => $shop->slug])],
            ['label' => mb_ucfirst($product->name), 'url' => ""]
        ];


//        dd($product->descriptions);

        return view('subdomain.products.show', data:
            [
                //Zmienne globalne strony
                'subdomain' => $subdomain,
                'product' => $product,
                'shop' => $shop,

                //Lokalizacja
                'place' => $place,

                'h1_title'=> mb_ucfirst($product->name).' w '.$shop->name.' - aktualne promocje',
                'page_title'=> mb_ucfirst($product->name).' '.$shop->name.' - '.monthReplace(date('Y-m-d',strtotime('now')), 'full', 'm-Y').' • GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',

                "breadcrumbs" => $breadcrumbs,
                'leaflets' => $leaflets,
                "leaflets_others" => $leaflets,

                'productsInShopLeaflets' => $productsInShopLeaflets,
                'productsInNoShopLeaflets' => $productsInNoShopLeaflets,

                //Opis strony
                'descriptions' => $product->descriptions
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
