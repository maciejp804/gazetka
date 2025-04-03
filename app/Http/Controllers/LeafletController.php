<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Description;
use App\Models\Leaflet;
use App\Models\PageClick;
use App\Models\Place;
use App\Models\Shop;
use App\Services\ProductService;
use App\Services\SortOptionsService;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Jenssegers\Agent\Agent;

class LeafletController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $leaflets = $this->getLeafletsSimplePaginate(10);

        $placesAll = Place::all();

        $location = Cookie::get('user_location');

        if (!$location) {
            $place = $placesAll->where('id', '=', 1172)->first();
        } else {
            $locationData = json_decode($location, true);
            $place = $placesAll->where('id', '=', $locationData['id'])->first();
        }

        $product_categories = Category::where('status', "active")
            ->where('type', 'product')
            ->where('parent_id', '=', null)
            ->orderBy('name', 'asc')
            ->get();

        $products = $this->productService->getProducts();

        $leaflet_sort = SortOptionsService::getSortOptions();

        $leaflets_category = SortOptionsService::getCategoryOptions();

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Gazetki promocyjne', 'url' => ''],
        ];

        $descriptions = Description::getByRouteAndPlace(Route::currentRouteName(), $place) ?? Description::getDefault(Route::currentRouteName(), $place);

        return view('main.leaflets.index', data:
            [
                'h1_title'=> 'Gazetki <strong>promocyjne</strong> - aktualne gazetki i katalogi',
                'page_title'=> 'Gazetki promocyjne, nowe i nadchodzące promocje | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',

                'place' => $place->name,
                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,
                'leaflets' => $leaflets,
                'leaflets_category' => $leaflets_category,
                'leaflet_sort' => $leaflet_sort,
                'products' => $products,
                'product_categories' => $product_categories,
            ]);
    }

    public function indexCategory($category)
    {

        $product_categories = Category::where('status', 'active')
            ->where('type', 'product')
            ->where('parent_id', '=', null)
            ->orderBy('name', 'asc')
            ->get();

        $category = $product_categories->where('slug', $category)->first();
//        dd($category);
        if (!$category) {
            abort(404);
        }

        $products = $this->productService->getProducts();

//        dd($products);

        $leaflets = $this->getLeafletsSimplePaginate(10, $category->id);

        $placesAll = Place::all();

        $location = Cookie::get('user_location');

        if (!$location) {
            $place = $placesAll->where('id', '=', 1172)->first();
        } else {
            $locationData = json_decode($location, true);
            $place = $placesAll->where('id', '=', $locationData['id'])->first();
        }


        $leaflet_sort = SortOptionsService::getSortOptions();
        $leaflets_category = SortOptionsService::getCategoryOptions();


        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Gazetki Promocyjne', 'url' => route('main.leaflets')],
            ['label' => $category->name, 'url' => ''],
        ];

        $descriptions = Description::getByRouteAndPlace(Route::currentRouteName(), $place) ?? Description::getDefault(Route::currentRouteName(), $place);

        return view('main.leaflets.index_category', data:
            [
                'h1_title'=> 'Gazetki <strong>promocyjne</strong> - aktualne gazetki i katalogi',
                'page_title'=> 'Gazetki promocyjne, nowe i nadchodzące promocje | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',

                'place' => $place->name,

                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,
                'leaflets' => $leaflets,
                'leaflets_category' => $leaflets_category,
                'leaflet_sort' => $leaflet_sort,
                'products' => $products,
                'product_categories' => $product_categories,
                'category' => $category,
            ]);
    }
    public function subdomainLeaflet($subdomain, $id, $insertData)
    {
        $shop = Shop::where('slug', $subdomain)->first();

        $leaflet = Leaflet::with('shop', 'pages.clicks.leafletProduct.product', 'inserts.clicks', 'leafletAds','products')
            ->find($id);

//        dd($leaflet);
        if (!$shop || !$leaflet) {
            abort(404);
        }
        $pages = $leaflet->pages->sortByDesc('sort_order');
        $pages = $pages->chunk(1);
        $inserts = $leaflet->inserts;
        $ads = $leaflet->leafletAds;
        $products = $leaflet->products->unique('id');

        $leaflets = Leaflet::with('shop')->where('valid_to','>=',now())->where('shop_id',$shop->id)->get();

        // Pobranie identyfikatorów podobnych sklepów
        $similarShopIds = Shop::where('category_id', $shop->category_id)
            ->where('id', '!=', $shop->id)
            ->pluck('id');

        // Paginacja gazetek dla sieci podobnych sklepów
        $similarLeaflets = Leaflet::with('shop')
            ->whereIn('shop_id', $similarShopIds)
            ->where('valid_to', '>=', now())
            ->get();

        $averageRating = $shop->averageRating();
        $ratingCount = $shop->ratingCount();

        $placesAll = Place::all();
        $placesLimit40 = $placesAll->sortByDesc('population')->take(40);

        $location = Cookie::get('user_location');

        if (!$location) {
            $place = $placesAll->where('id', '=', 1172)->first();
        } else {
            $locationData = json_decode($location, true);
            $place = $placesAll->where('id', '=', $locationData['id'])->first();
        }

        $agent = new Agent();
        $isMobile = $agent->isMobile(); // Zwraca true, jeśli to urządzenie mobilne

        $blogs = Blog::with('category')->where('status', '=','published')->get();



        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => $shop->name, 'url' => route('subdomain.index', ['subdomain' => $subdomain])],
            ['label' => 'Gazetka promocyjna '. $shop->name, 'url' => '']
        ];

        $descriptions = Description::getByRouteAndPlace(Route::currentRouteName(), $place) ?? Description::getDefault(Route::currentRouteName(), $place);

        return view('subdomain.leaflet', data:
            [
                'place' => $place,
                'places' => $placesLimit40,

                'shop' => $shop,

                'h1_title'=> 'Gazetka promocyjna '.$shop->name.' od '.monthReplace($leaflet->valid_from, 'full_gen', 'd-m').' do '.monthReplace($leaflet->valid_to,'full_gen'),
                'page_title'=> 'Gazetka promocyjna '.$shop->name.' od 12.11 do 24.12 | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',

                'isMobile' => $isMobile,
                'pages' => $pages,
                'inserts' => $inserts,
                'insertData' => $insertData,
                'ads' => $ads,
                'subdomain' => $subdomain,
                'id' => $id,
                'breadcrumbs' => $breadcrumbs,

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

                //Opis strony
                'descriptions' => $descriptions,
            ]);
    }

    protected function getLeafletsSimplePaginate($pages, $category = 'all')
    {

        $leaflets = Leaflet::with('shop', 'cover', 'products.category')
            ->where('valid_to', '>=', now('Europe/Warsaw')->toDateTime())
            ->where('leaflets.status', '=', 'published');

        if ($category != 'all')
        {
            $leaflets->whereHas('products.category', function ($queryProduct) use ($category) {
                $queryProduct->where('id', $category)
                ->orWhere('parent_id', $category);
            });
        }

        return $leaflets->paginate($pages, ['*'], 'page');
    }

    protected function products()
    {
        return PageClick::with('page.leaflets.shop', 'leafletProduct.product')
            ->where('valid_from', '<=', now())
            ->where('valid_to', '>=', now())
            ->get()
            ->flatMap(function ($click) {
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
    }

}
