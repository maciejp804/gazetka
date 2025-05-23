<?php

namespace App\Http\Controllers;


use App\Models\Blog;
use App\Models\Category;
use App\Models\Description;
use App\Models\Leaflet;
use App\Models\Place;
use App\Models\Product;
use App\Models\Shop;
use App\Services\LeafletService;
use App\Services\ProductService;
use App\Services\SortOptionsService;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Jenssegers\Agent\Agent;


class LeafletController extends Controller
{
    protected $productService;
    protected $leafletService;

    public function __construct(ProductService $productService, LeafletService $leafletService)
    {
        $this->productService = $productService;
        $this->leafletService = $leafletService;
    }

    public function index()
    {
        Log::info('Current Route:', [Route::currentRouteName()]);

        $leaflets = $this->leafletService->getLeafletsSimplePaginate(15);

        $place = Place::where('id', '=', 1172)->first();
//        $location = Cookie::get('user_location');
//        if (!$location) {
//            $placesAll = Place::all();
//            $place = $placesAll->where('id', '=', 1172)->first();
//        } else {
//            $locationData = json_decode($location, true);
//            $place = (object)$locationData;
//        }

        $product_categories = Category::where('status', "active")
            ->where('type', 'product')
            ->where('parent_id', '=', null)
            ->orderBy('name')
            ->get();


        $products = $this->productService->getHotSpots('medium', null, null, null, null, 20);

        $leaflet_sort = SortOptionsService::getSortOptions();

        $leaflets_category = SortOptionsService::getCategoryOptions();

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Gazetki promocyjne', 'url' => ''],
        ];



        $descriptions = Description::getByRouteAndPlace(Route::currentRouteName());
        $default_descriptions = Description::getDefaultLeaflets(Route::currentRouteName());


//        dd($default_descriptions);

        return view('main.leaflets.index', data:
            [

                // Opisy i dane globalne
                'h1_title' => $descriptions->h1_title ?? $default_descriptions->h1_title ?? "DoMyślny",
                'meta_title'=> $descriptions->meta_title ?? $default_descriptions->meta_title ?? "DoMyślny",
                'meta_description' => $descriptions->meta_description ?? $default_descriptions->meta_description ?? "DoMyślny",
                'descriptions' => $descriptions,
                'excerpt' => $descriptions->excerpt ?? $default_descriptions->excerpt ?? "DoMyślny",
                'meta_robots' => 'noindex, follow',
                'breadcrumbs' => $breadcrumbs,

                'place' => $place->name,

                'leaflets' => $leaflets,
                'leaflets_category' => $leaflets_category,
                'leaflet_sort' => $leaflet_sort,
                'products' => $products,
                'product_categories' => $product_categories,
            ]);
    }

    public function indexCategory($category)
    {
        Log::info('Current Route:', [Route::currentRouteName()]);
        $product_categories = Category::where('status', 'active')
            ->where('type', 'product')
            ->where('parent_id', '=', null)
            ->orderBy('name')
            ->get();

        $category = $product_categories->where('slug', $category)->first();
//        dd($category);
        if (!$category) {
            abort(404);
        }

        $products = $this->productService->getHotSpots();

//        dd($products);
        $leaflets = $this->leafletService->getLeafletsSimplePaginate(10, $category->id);

        $place = Place::where('id', '=', 1172)->first();
//        $location = Cookie::get('user_location');
//        if (!$location) {
//            $placesAll = Place::all();
//            $place = $placesAll->where('id', '=', 1172)->first();
//        } else {
//            $locationData = json_decode($location, true);
//            $place = (object)$locationData;
//        }


        $leaflet_sort = SortOptionsService::getSortOptions();
        $leaflets_category = SortOptionsService::getCategoryOptions();


        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Gazetki Promocyjne', 'url' => route('main.leaflets')],
            ['label' => $category->name, 'url' => ''],
        ];

        $descriptions = Description::getByRouteAndPlace(Route::currentRouteName(), null, $place);

        $default_descriptions = Description::getDefaultLeaflets(Route::currentRouteName(), $category);

//        dd($descriptions);

        return view('main.leaflets.index_category', data:
            [
                'place' => $place->name,

                // Opisy i dane globalne
                'h1_title' => $descriptions->h1_title ?? $default_descriptions->h1_title ?? "DoMyślny",
                'meta_title'=> $descriptions->meta_title ?? $default_descriptions->meta_title ?? "DoMyślny",
                'meta_description' => $descriptions->meta_description ?? $default_descriptions->meta_description ?? "DoMyślny",
                'descriptions' => $descriptions,
                'excerpt' => $descriptions->excerpt ?? $default_descriptions->excerpt ?? "DoMyślny",
                'meta_robots' => 'noindex, follow',

                'breadcrumbs' => $breadcrumbs,
                'leaflets' => $leaflets,
                'leaflets_category' => $leaflets_category,
                'leaflet_sort' => $leaflet_sort,
                'products' => $products,
                'product_categories' => $product_categories,
                'category' => $category,
            ]);
    }
    public function subdomainLeaflet($subdomain, $data, $id)
    {
        Log::info('Current Route:', [Route::currentRouteName()]);
        $shop = Shop::where('slug', $subdomain)->first();

        $leaflet = Leaflet::with('shop', 'pages.hotSpots', 'products', 'inserts.clicks', 'leafletAds','products')
            ->find($id);




        $productIds = $leaflet->pages
            ->flatMap(fn ($page) => $page->hotSpots)   // zbierz wszystkie hotspoty
            ->pluck('product_id')                      // wyciągnij product_id
            ->unique()                                 // tylko unikalne ID
            ->filter();                                // usuń null, jeśli jakieś są

        $products = Product::whereIn('id', $productIds)->get();



        if (!$shop || !$leaflet) {
            abort(404);
        }
        $pages = $leaflet->pages->sortByDesc('sort_order');
        $pages = $pages->chunk(1);

        $inserts = $leaflet->inserts;
        $ads = $leaflet->leafletAds;


        [$leaflets, $counter ] = $this->leafletService->getLeaflets('all', $shop->id);

        $leaflets = $leaflets->whereNotIn('id', $leaflet->id);

        // Pobranie identyfikatorów podobnych sklepów
        $similarShopIds = Shop::where('category_id', $shop->category_id)
            ->where('id', '!=', $shop->id)
            ->pluck('id');

        // Paginacja gazetek dla sieci podobnych sklepów
        $similarLeaflets = Leaflet::with('shop')
            ->whereIn('shop_id', $similarShopIds)
            ->where('display_to', '>=', now('Europe/Warsaw'))
            ->whereHas('cover') // dodane: tylko jeśli istnieje cover
            ->whereHas('pages')
            ->where('status', 'published')
            ->get();

        $averageRating = $shop->averageRating();
        $ratingCount = $shop->ratingCount();

        $placesAll = Place::all();

        $placesLimit40 = $placesAll->sortByDesc('population')->take(40);

        $place = Place::where('id', '=', 1172)->first();
//        $location = Cookie::get('user_location');
//        if (!$location) {
//            $placesAll = Place::all();
//            $place = $placesAll->where('id', '=', 1172)->first();
//        } else {
//            $locationData = json_decode($location, true);
//            $place = (object)$locationData;
//        }

        $agent = new Agent();
        $isMobile = $agent->isMobile(); // Zwraca true, jeśli to urządzenie mobilne

        $blogs = Blog::getAll();



        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => $shop->name, 'url' => route('subdomain.index', ['subdomain' => $subdomain])],
            ['label' => 'Gazetka promocyjna '. $shop->name, 'url' => '']
        ];

        $descriptions = Description::getByRouteAndPlace(Route::currentRouteName());
        $default_descriptions = Description::getDefaultLeaflets(Route::currentRouteName());
//        dd(monthReplace($leaflet->valid_from,'full_gen'));

        $products_excerpt = 'W ofercie znajdują się promocje na:';

        if($products->count()){
            $count_products = count($products);
            if ($count_products >= 5){
                $counter = 5;
            } else {
                $counter = $count_products;
            }

            for ($i = 0; $i < $counter; $i++){
                if ($i == $counter - 1){
                    $products_excerpt .= ' <strong>'.$products[$i]->name.'</strong>.';
                } else {
                    $products_excerpt .= ' <strong>'.$products[$i]->name.'</strong>,';
                }
            }
        } else {
            $products_excerpt = 'Nie czekaj! Sprawdź, co jeszcze '. $shop->name .' ma do zaoferowania w ' .(monthReplace(date("Y-m-d"),'full_loc', 'm')).'!';
        }

        return view('subdomain.leaflet', data:
            [
                'place' => $place,
                'places' => $placesLimit40,

                'shop' => $shop,

                // Opisy i dane globalne
                'h1_title' => $descriptions->h1_title ?? str_replace(['{title}', '{shop}', '{valid_from}', '{valid_to}'],
                        [$leaflet->title,$shop->name, date('d.m.Y', strtotime($leaflet->valid_from)), monthReplace($leaflet->valid_to,'full_gen')],
                        $default_descriptions->h1_title) ?? "DoMyślny",
                'meta_title'=> $descriptions->meta_title ?? str_replace(['{title}','{shop}', '{valid_from}', '{valid_to}'],
                        [$leaflet->title, $shop->name, date('d.m', strtotime($leaflet->valid_from)), date('d.m.Y', strtotime($leaflet->valid_to))],
                        $default_descriptions->meta_title) ?? "DoMyślny",
                'meta_description' => $descriptions->meta_description ?? str_replace(['{title}','{shop}', '{valid_from}', '{valid_to}'],
                        [$leaflet->title, $shop->name, monthReplace($leaflet->valid_from, 'full_gen', 'd-m'), monthReplace($leaflet->valid_to,'full_gen', 'd-m')],
                        $default_descriptions->meta_description) ?? "DoMyślny",
                'descriptions' => $descriptions,
                'excerpt' => $descriptions->excerpt ?? str_replace(['{title}','{shop}', '{valid_from}', '{valid_to}', '{month}', '{products}'],
                        [$leaflet->title, $shop->name, monthReplace($leaflet->valid_from, 'full_gen', 'd-m'),
                            monthReplace($leaflet->valid_to,'full_gen', 'd-m'),
                            monthReplace($leaflet->valid_to,'full_loc', 'm'), $products_excerpt],
                        $default_descriptions->excerpt) ?? "DoMyślny",
                'breadcrumbs' => $breadcrumbs,

                'isMobile' => $isMobile,
                'pages' => $pages,
                'inserts' => $inserts,

                'ads' => $ads,
                'subdomain' => $subdomain,
                'id' => $id,


                // Rating
                'averageRating' => $averageRating,
                'ratingCount' => $ratingCount,
                'model' => "Shop",

                //Gazetki
                'leaflet' => $leaflet,
                'leaflets' => $leaflets,
                'similarLeaflets' => $similarLeaflets,

                //Produkty
                'products' => $products,

                //Blogs
                'blogs' => $blogs,



            ]);
    }

}
