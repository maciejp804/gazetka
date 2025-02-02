<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Leaflet;
use App\Models\Page;
use App\Models\PageClick;
use App\Models\Place;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Shop;
use App\Models\Voucher;
use App\Services\SortOptionsService;
use App\Services\StaticDescriptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ProductController extends Controller
{
    public function index($descriptions)
    {

        $location = Cookie::get('user_location');
        if (!$location) {
            $placesAll = Place::all();
            $place = $placesAll->where('id', '=', 1172)->first();
        } else {
            $locationData = json_decode($location, true);
            $place = (object)$locationData;
        }

        $product_categories = ProductCategory::where('status', 1)->get();

        $products = PageClick::with('page.leaflets.shop', 'leafletProduct.product')
            ->where('valid_from', '<=', now())
            ->where('valid_to', '>=', now())
            ->paginate(10);

        $flattenedCollection = $products->getCollection()->flatMap(function ($click) {
            return $click->page->leaflets->map(function ($leaflet) use ($click) {
                return [
                    'click_id'      => $click->id,
                    'valid_from'    => $click->valid_from,
                    'valid_to'      => $click->valid_to,
                    'page_id'       => $click->page->id,
                    'leaflet_id'    => $leaflet->id,
                    'logo_xs'       => $leaflet->shop ? $leaflet->shop->logo_xs : null,
                    'shop_name'     => $leaflet->shop ? $leaflet->shop->name : null,
                    'shop_slug'     => $leaflet->shop ? $leaflet->shop->slug : null,
                    'product_id'    => $click->leafletProduct->product ? $click->leafletProduct->product->id : null,
                    'product_name'  => $click->leafletProduct->product ? $click->leafletProduct->product->name : null,
                    'product_slug'  => $click->leafletProduct->product ? $click->leafletProduct->product->slug : null,
                    'product_image'  => $click->leafletProduct->product ? $click->leafletProduct->product->image : null,
                    'price'         => $click->leafletProduct ? $click->leafletProduct->price : null,
                    'promo_price'   => $click->leafletProduct ? $click->leafletProduct->promo_price : null,
                ];
            });
        });

        // Podmiana kolekcji w paginatorze – zachowujemy metadane paginacji
        $products->setCollection($flattenedCollection);


        $product_sort = SortOptionsService::getSortOptions();


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

                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,

                'product_sort' => $product_sort,
                'products' => $products,
                'leaflets' => $leaflets,
                'product_categories' => $product_categories,
            ]);
    }

    public function indexCategory($category, $descriptions)
    {
        $product_categories = ProductCategory::where('status', 1)->get();
        $category = $product_categories->where('slug', $category)->first();

        if(!$category){
            abort(404);
        }

        $location = Cookie::get('user_location');
        if (!$location) {
            $placesAll = Place::all();
            $place = $placesAll->where('id', '=', 1172)->first();
        } else {
            $locationData = json_decode($location, true);
            $place = (object)$locationData;
        }


        $products = PageClick::with('page.leaflets.shop', 'leafletProduct.product')
            ->where('valid_from', '<=', now())
            ->where('valid_to', '>=', now())
            ->whereHas('leafletProduct.product', function ($query) use ($category) {
                $query->where('product_category_id', $category->id);
            })
            ->paginate(10);

        $flattenedCollection = $products->getCollection()->flatMap(function ($click) {
            return $click->page->leaflets->map(function ($leaflet) use ($click) {
                return [
                    'click_id'      => $click->id,
                    'valid_from'    => $click->valid_from,
                    'valid_to'      => $click->valid_to,
                    'page_id'       => $click->page->id,
                    'leaflet_id'    => $leaflet->id,
                    'logo_xs'       => $leaflet->shop ? $leaflet->shop->logo_xs : null,
                    'shop_name'     => $leaflet->shop ? $leaflet->shop->name : null,
                    'shop_slug'     => $leaflet->shop ? $leaflet->shop->slug : null,
                    'product_id'    => $click->leafletProduct->product ? $click->leafletProduct->product->id : null,
                    'product_name'  => $click->leafletProduct->product ? $click->leafletProduct->product->name : null,
                    'product_slug'  => $click->leafletProduct->product ? $click->leafletProduct->product->slug : null,
                    'product_image'  => $click->leafletProduct->product ? $click->leafletProduct->product->image : null,
                    'price'         => $click->leafletProduct ? $click->leafletProduct->price : null,
                    'promo_price'   => $click->leafletProduct ? $click->leafletProduct->promo_price : null,
                ];
            });
        });

        // Podmiana kolekcji w paginatorze – zachowujemy metadane paginacji
        $products->setCollection($flattenedCollection);

        $leaflets = Leaflet::with('shop')->where('valid_to','>=',now())->get();
        $leaflets = $leaflets->sortByDesc('created_at')->take(40);

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Produkty', 'url' => route('main.products')],
            ['label' => $category->name, 'url' => '']
        ];

        $product_sort = SortOptionsService::getSortOptions();
        $static_description = StaticDescriptions::getDescriptions();
        return view('main.products.index_category', data:
            [
                'place' => $place->name,


                'h1_title'=> 'Produkty w gazetkach promocyjnych - kategoria <strong>'.strtolower($category->name).'</strong>',
                'page_title'=> 'Gazetki promocyjne, nowe i nadchodzące promocje | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',
                'static_description' => $static_description,
                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,
                'product_sort' => $product_sort,
                'products' => $products,
                'leaflets' => $leaflets,
                'product_categories' => $product_categories,
                'category' => $category,
            ]);
    }

    public function show($slug, $descriptions)
    {
        $products = Product::with('ratings', 'leaflets')->get();
        $product = $products->where('slug', $slug)->first();


        if(!$product)
        {
            abort(404);
        }

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

        $products = PageClick::with('page.leaflets.shop', 'leafletProduct.product')
            ->where('valid_from', '<=', now())
            ->where('valid_to', '>=', now())
            ->whereHas('leafletProduct', function($query) use ($product) {
                $query->where('product_id', '!=', $product->id);
            })
            ->get()
            ->flatMap(function ($click) {
                return $click->page->leaflets->map(function ($leaflet) use ($click) {
                    return [
                        'click_id'      => $click->id,
                        'valid_from'    => $click->valid_from,
                        'valid_to'      => $click->valid_to,
                        'page_id'       => $click->page->id,
                        'leaflet_id'    => $leaflet->id,
                        'logo_xs'       => $leaflet->shop ? $leaflet->shop->logo_xs : null,
                        'shop_name'     => $leaflet->shop ? $leaflet->shop->name : null,
                        'shop_slug'     => $leaflet->shop ? $leaflet->shop->slug : null,
                        'product_id'    => $click->leafletProduct->product ? $click->leafletProduct->product->id : null,
                        'product_name'  => $click->leafletProduct->product ? $click->leafletProduct->product->name : null,
                        'product_slug'  => $click->leafletProduct->product ? $click->leafletProduct->product->slug : null,
                        'product_image'  => $click->leafletProduct->product ? $click->leafletProduct->product->image : null,
                        'price'         => $click->leafletProduct ? $click->leafletProduct->price : null,
                        'promo_price'   => $click->leafletProduct ? $click->leafletProduct->promo_price : null,
                    ];
                });
            });
        $vouchers = Voucher::with('voucherStore')->get();

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Produkty', 'url' => route('main.products')],
            ['label' => $product->name, 'url' => ''],
        ];


        return view('main.products.show', data:
            [
                //Lokalizacja
                'place' => $place->name,


                'h1_title'=> $product->name.' - promocje w sklepach',
                'page_title'=> $product->name.' - promocje, aktualna cena w sklepach | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',
                'name' => $slug,
                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,
                'products' => $products,
                'product' => $product,

                // Rating
                'averageRating' => $averageRating,
                'ratingCount' => $ratingCount,
                'model' => "Product",

                'vouchers' => $vouchers,
            ]);
    }

    public function showSubdomain($subdomain, $slug, $leaflets)
    {

        $products = Product::with('ratings');
        $product = $products->where('slug', $slug)->first();
        $shops = Shop::all();
        $shop = $shops->where('slug', $subdomain)->first();

        if(!$product || !$shop)
        {
            abort(404);
        }

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
                    'logo'=> $leaflet->shop->logo_xs,
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
                    'logo'=> $leaflet->shop->logo_xs,
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
            ['label' => $product->name, 'url' => ""]
        ];


        return view('subdomain.products.show', data:
            [
                //Zmienne globalne strony
                'subdomain' => $subdomain,
                'product' => $product,
                'shop' => $shop,

                //Lokalizacja
                'place' => $place,

                'h1_title'=> $product->name.' w '.$shop->name.' - aktualne promocje',
                'page_title'=> $product->name.' '.$shop->name.' - '.monthReplace(date('Y-m-d',strtotime('now')), 'full', 'm-Y').' • GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',

                "breadcrumbs" => $breadcrumbs,
                'leaflets' => $leaflets,
                "leaflets_others" => $leaflets,

                'productsInShopLeaflets' => $productsInShopLeaflets,
                'productsInNoShopLeaflets' => $productsInNoShopLeaflets,
            ]);
    }
}
