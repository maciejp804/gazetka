<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Description;
use App\Models\Leaflet;
use App\Models\Marker;
use App\Models\PageClick;
use App\Models\Place;
use App\Models\Shop;
use App\Models\Voucher;
use App\Services\LeafletService;
use App\Services\ProductService;
use App\Services\SortOptionsService;
use App\Services\StaticDescriptions;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class MainController extends Controller
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
        $placesLimit40 = Place::orderByDesc('population')->limit(40)->get();

        $place = Place::where('id', '=', 1172)->first();
//        $location = Cookie::get('user_location');
//        if (!$location) {
//            $placesAll = Place::all();
//            $place = $placesAll->where('id', '=', 1172)->first();
//        } else {
//            $locationData = json_decode($location, true);
//            $place = (object)$locationData;
//        }

        [$leaflets, $counter_leaflets] = $this->leafletService->getLeaflets(40, null, null, [['pinned', 'desc']]);


        [ $leaflets_promo , $counter] = $this->leafletService->getLeaflets(20,  null, null, [['updated_at', 'desc']], 1);

        $shop_categories = Category::where([
            ['status', 'active'],
            ['type', 'shop']
        ])->get();


        $products = $this->productService->getHotSpots('medium', null, null, null, null, 20);

        $counter_products = 1253;

        $vouchers = $this->vouchers();

        $blogs = Blog::getAll();


        $leaflets_time = SortOptionsService::getSortOptions();

        $leaflets_category = Category::where([
            ['status', 'active'],
            ['type', 'product'],
            ['parent_id', null]
        ])->orderBy('name')->get();


        $info_description = StaticDescriptions::getDescriptions();

        [$shops, $counter_shops]= $this->shops(null, 'main.index');


        $breadcrumbs = [];

        $descriptions = Description::getByRouteAndPlace(Route::currentRouteName());
        $default_descriptions =  Description::getDefault(Route::currentRouteName());
//        dd($leaflets);

        return view('main.index', [

                //Lokalizacja
                'place' => $place->name,
                'places' => $placesLimit40,

                // Opisy i dane globalne
                'h1_title' => $descriptions->h1_title ?? $default_descriptions->h1_title ?? "DoMyślny",
                'meta_title'=> $descriptions->meta_title ?? $default_descriptions->meta_title ?? "DoMyślny",
                'meta_description' => $descriptions->meta_description ?? $default_descriptions->meta_description ?? "DoMyślny",
                'descriptions' => $descriptions,
                'info_description' => $info_description,
                'breadcrumbs' => $breadcrumbs,

                //Gazetki
                'counter_leaflets' => $counter_leaflets,
                'leaflets_promo' => $leaflets_promo,
                'leaflets' => $leaflets,
                'leaflets_category' => $leaflets_category,
                'shop_categories' => $shop_categories,
                'leaflets_time' => $leaflets_time,


                //Produkty
                'products' => $products,
                'counter_products' => $counter_products,
                'vouchers' => $vouchers,

                //Sieci handlowe
                'shops' => $shops,
                'counter_shops' => $counter_shops,

                'blogs' => $blogs,

            ]);
    }

    public function indexGps($community)
    {
        $placesAll = Place::all();

        $place = $placesAll->where('slug', $community)->first();

        if(!$place)
        {
            abort(404);
        }

        // Zapisz lokalizację w ciasteczku
        Cookie::queue('user_location', json_encode([
            'id' => $place->id,
            'name' => $place->name,
            'latitude' => $place->lat,
            'longitude' => $place->lng,
        ],JSON_PRETTY_PRINT), 60 * 24 * 7, '/', '.'.config('app.main_domain'), false, false); // Zapis na 7 dni

        $placesLimit40 = $placesAll->where('slug', '!=', $place->slug)->sortByDesc('population')->take(40);

        $markers = Marker::with('shop', 'place', 'hours')
            ->whereHas('shop', function ($query) {
                $query->where('status', 1);
            })
            ->where('place_id', $place->id)
            ->where('slug', '!=', '')
            ->get();

        [$leaflets, $counter_leaflets] = $this->leafletService->getLeaflets(40);

        [ $leaflets_promo , $counter] = $this->leafletService->getLeaflets(20,  null, null, [['updated_at', 'desc']], 1);


        $categories = Category::where('status', 'active')->where('type', 'shop')->get();

        $products = $this->productService->getHotSpots('medium', null, null, null, null, 20);
        $counter_products = count($products);
        $vouchers = $this->vouchers();

        $leaflets_time = SortOptionsService::getSortOptions();

        $leaflets_category = Category::where('status', 'active')
            ->where('type', 'product')
            ->get();

        $info_description = StaticDescriptions::getDescriptions();

        [$shops, $counter_shops]= $this->shops(null, 'main.index_gps');

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => $place->name, 'url' => ''],
        ];

        $blogs = Blog::getAll();

        $descriptions = Description::getByRouteAndPlace(Route::currentRouteName(), null, $place);
        $default_descriptions = Description::getDefault(Route::currentRouteName(), $place);



        return view('main.index_gps', data:
            [

                'place' => $place,
                'places' => $placesLimit40,

                // Opisy i dane globalne
                'h1_title' => $descriptions->h1_title ?? $default_descriptions->h1_title ?? "DoMyślny",
                'meta_title'=> $descriptions->meta_title ?? $default_descriptions->meta_title ?? "DoMyślny",
                'meta_description' => $descriptions->meta_description ?? $default_descriptions->meta_description ?? "DoMyślny",
                'descriptions' => $descriptions,
                'info_description' => $info_description,
                'breadcrumbs' => $breadcrumbs,

                'shop_categories' => $categories,

                //Gazetki
                'counter_leaflets' => $counter_leaflets,
                'leaflets_promo' => $leaflets_promo,
                'leaflets' => $leaflets,
                'leaflets_category' => $leaflets_category,
                'leaflets_time' => $leaflets_time,

                //Produkty
                'products' => $products,
                'counter_products' => $counter_products,
                'vouchers' => $vouchers,

                //Sieci handlowe
                'shops' => $shops,
                'counter_shops' => $counter_shops,

                //Blogs
                'blogs' => $blogs,

                //Markers
                'markers' => $markers
            ]);
    }

    public function subdomainIndex($subdomain)
    {
        if (app()->environment('local')) {
    Log::info('Current Route:', [Route::currentRouteName()]);
}
        $shop = Shop::with('category')
            ->where('slug', $subdomain)
            ->where('status', 'active')
            ->first();

        if(!$shop)
        {
            abort(404);
        }

        [$shops, $counter_shops] = $this->shops($shop->slug);

        [$leaflets, $counter_leaflets] = $this->leafletService->getLeaflets('all', $shop->id);

        $leaflets_archive = $this->leafletService->getLeafletsSimplePaginate(10, 'all', 10, $shop->id);

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

        $averageRating = $shop->averageRating();
        $ratingCount = $shop->ratingCount();

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => $shop->name, 'url' => '']
        ];

        $vouchers = $this->vouchers();

        $leaflets_time = SortOptionsService::getSortOptions(false);
//        dd($leaflets_time);
        $leaflets_category = Category::where('status', 'active')
            ->where('type', 'product')
            ->where('parent_id', '=', null)
            ->orderBy('name', 'asc')
            ->get();

        $products = $this->productService->getHotSpots('low', null, null, $shop->slug, null, 20);

        $blogs = Blog::getAll();
//        dd($shop);
        $descriptions = Description::getByRouteAndPlace(Route::currentRouteName(), $shop->id);

        $category = $shop->category ? $shop->category->slug : 'default';
        $default_descriptions = Description::getDefault(Route::currentRouteName(), $place, $shop->name, $category);

        return view('subdomain.index', [
            //Zmienne globalne
            'subdomain' => $subdomain,

            // Lokalizacja
            'place' => $place,
            'places' => $placesLimit40,

            // Opisy i dane globalne
            'h1_title' => $descriptions->h1_title ?? $default_descriptions->h1_title ?? "DoMyślny",
            'meta_title'=> $descriptions->meta_title ?? $default_descriptions->meta_title ?? "DoMyślny",
            'meta_description' => $descriptions->meta_description ?? $default_descriptions->meta_description ?? "DoMyślny",
            'descriptions' => $descriptions,
            'excerpt' => $descriptions->excerpt ?? $default_descriptions->excerpt ?? "DoMyślny",

            'breadcrumbs' => $breadcrumbs,

            // Rating
            'averageRating' => $averageRating,
            'ratingCount' => $ratingCount,
            'model' => "Shop",


            // Produkty

            'products' => $products,
            'leaflets_category' => $leaflets_category, // gazetki
            'leaflets_time' => $leaflets_time,
            'leaflets' => $leaflets,
            'leaflets_archive' => $leaflets_archive,
            'vouchers' => $vouchers, // kupony
            'shops' => $shops, // sklepy
            'shop' => $shop,

            //Blog
            'blogs' => $blogs,


        ]);

    }

//    public function subdomainIndexArchive($subdomain)
//    {
//
//        $shop = Shop::with('category')->where('slug', $subdomain)->first();
//
//        if(!$shop)
//        {
//            abort(404);
//        }
//
//        [$shops, $counter_shops] = $this->shops($shop->slug);
//
//        [$leaflets, $counter_leaflets] = $this->leafletService->getLeaflets('all', $shop->id, 'archive');
//
//        $placesAll = Place::all();
//
//        $placesLimit40 = $placesAll->sortByDesc('population')->take(40);
//
//        $location = Cookie::get('user_location');
//
//        if (!$location) {
//            $place = $placesAll->where('id', '=', 1172)->first();
//        } else {
//            $locationData = json_decode($location, true);
//            $place = $placesAll->where('id', '=', $locationData['id'])->first();
//        }
//
//        $averageRating = $shop->averageRating();
//        $ratingCount = $shop->ratingCount();
//
//        $breadcrumbs = [
//            ['label' => 'Strona główna', 'url' => route('main.index')],
//            ['label' => 'Gazetki '. $shop->name, 'url' => '']
//        ];
//
//        $vouchers = $this->vouchers();
//
//        $leaflets_time = SortOptionsService::getSortOptions(false);
////        dd($leaflets_time);
//        $leaflets_category = Category::where('status', 'active')
//            ->where('type', 'product')
//            ->where('parent_id', '=', null)
//            ->orderBy('name', 'asc')
//            ->get();
//
//        $products = $this->productService->getHotSpots('low', null, null, $shop->slug, null);
//
//        $blogs = Blog::getAll();
////        dd($shop);
//        $descriptions = Description::getByRouteAndPlace(Route::currentRouteName(), $shop->id);
//
//        $category = $shop->category ? $shop->category->slug : 'default';
//
//        $default_descriptions = Description::getDefault(Route::currentRouteName(), null, $shop->name);
//
//        return view('subdomain.index', [
//            //Zmienne globalne
//            'subdomain' => $subdomain,
//
//            // Lokalizacja
//            'place' => $place,
//            'places' => $placesLimit40,
//
//            // Opisy i dane globalne
//            'h1_title' => $descriptions->h1_title ?? $default_descriptions->h1_title ?? "DoMyślny",
//            'meta_title'=> $descriptions->meta_title ?? $default_descriptions->meta_title ?? "DoMyślny",
//            'meta_description' => $descriptions->meta_description ?? $default_descriptions->meta_description ?? "DoMyślny",
//            'descriptions' => $descriptions,
//            'excerpt' => $descriptions->excerpt ?? $default_descriptions->excerpt ?? "DoMyślny",
//
//            'breadcrumbs' => $breadcrumbs,
//
//            // Rating
//            'averageRating' => $averageRating,
//            'ratingCount' => $ratingCount,
//            'model' => "Shop",
//
//
//            // Produkty
//
//            'products' => $products,
//            'leaflets_category' => $leaflets_category, // gazetki
//            'leaflets_time' => $leaflets_time,
//            'leaflets' => $leaflets,
//            'vouchers' => $vouchers, // kupony
//            'shops' => $shops, // sklepy
//            'shop' => $shop,
//
//            //Blog
//            'blogs' => $blogs,
//
//
//        ]);
//
//    }

    public function subdomainIndexGps($subdomain, $community)
    {
        $placesAll = Place::all();
        $place = $placesAll->where('slug', $community)->first();

        $shop = Shop::with('category')
            ->where('slug', $subdomain)
            ->where('status', 'active')
            ->first();

        if(!$place || !$shop)
        {
            abort(404);
        }

        [$shops, $counter_shops] = $this->shops($shop->slug);

        $markers = Marker::with('shop', 'place', 'hours')
            ->whereHas('shop', function ($query) use ($shop) {
                $query->where('status', 1);
            })
            ->where('shop_id', $shop->id)
            ->where('place_id', $place->id)
            ->where('slug', '!=', '')
            ->get();


        [$leaflets, $counter_leaflets] = $this->leafletService->getLeaflets('all', $shop->id);

        // Zapisz lokalizację w ciasteczku
        Cookie::queue('user_location', json_encode([
            'id' => $place->id,
            'name' => $place->name,
            'latitude' => $place->lat,
            'longitude' => $place->lng,
        ],JSON_PRETTY_PRINT), 60 * 24 * 7, '/', '.'.config('app.main_domain'), false, false); // Zapis na 7 dni

        $averageRating = $shop->averageRating();
        $ratingCount = $shop->ratingCount();

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Gazetki '. $shop->name, 'url' => route('subdomain.index', ['subdomain' => $subdomain])],
            ['label' => $shop->name.' '.$place->name, 'url' => ""]
        ];

        $vouchers = $this->vouchers();

        $leaflets_time = SortOptionsService::getSortOptions(false);

        $leaflets_category = Category::where('status', 'active')
            ->where('type', 'product')
            ->where('parent_id', '=', null)
            ->orderBy('name', 'asc')
            ->get();

        $blogs = Blog::getAll();

        $descriptions = Description::getByRouteAndPlace(Route::currentRouteName(), $shop->id) ?? Description::getDefault(Route::currentRouteName(), $place, $shop->name);
        $category = $shop->category ? $shop->category->slug : 'default';

        $default_descriptions = Description::getDefault(Route::currentRouteName(), $place, $shop->name, $category);

         return view('subdomain.index_gps', [
             //Zmienne globalne
             'subdomain' => $subdomain,

             //Lokalizacja
             'place' => $place,
             'markers' => $markers,

             // Opisy i dane globalne
             'h1_title' => $descriptions->h1_title ?? $default_descriptions->h1_title ?? "DoMyślny",
             'meta_title'=> $descriptions->meta_title ?? $default_descriptions->meta_title ?? "DoMyślny",
             'meta_description' => $descriptions->meta_description ?? $default_descriptions->meta_description ?? "DoMyślny",
             'descriptions' => $descriptions,
             'excerpt' => $descriptions->excerpt ?? $default_descriptions->excerpt ?? "DoMyślny",
             'breadcrumbs' => $breadcrumbs,

             // Rating
             'averageRating' => $averageRating,
             'ratingCount' => $ratingCount,
             'model' => "Shop",

             //Gazetki
             'leaflets_category' => $leaflets_category,
             'leaflets_time' => $leaflets_time,
             'leaflets' => $leaflets,
             'vouchers' => $vouchers,
             'shopsOther' => $shops,
             'shop' => $shop,

             //Blogs
             'blogs' => $blogs,

            ]);
    }

    public function about()
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

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'O GazetkaPromocyjna', 'url' => ''],
        ];

        $descriptions = [
            'content' => [
                    ['image' => 'assets/images/statics/1.png',
                        'h2_title' => 'Historia',
                        'h3_title' => '',
                        'body' => "<p>Strona gazetkapromocyjna.com.pl powstała w 2012 roku i jest własnością firmy Gazetka Promocyjna, która swoją siedzibę ma w Poznaniu.</p>
                            <p>Głównym celem serwisu jest gromadzenie i prezentowanie aktualnej oferty najpopularniejszych sieci handlowych w postaci - gazetek. W swojej bazie posiadamy promocje z różnych gałęzi handlu takich jak: artykuły spożywcze, artykuły gospodarstwa domowego, artykuły rtv i agd oraz wiele innych. Zasięgiem obejmujemy całą Polskę. Użytkownicy serwisu mogą przeglądać oferty wielu sieci i sklepów bez wychodzenia z domu. Sieci handlowe mają możliwość promowania swojej oferty na stronach naszego serwisu co pozwala trafić do domów przyszłych Klientów. Oferujemy możliwość wyświetlania reklamy na stronach oraz aktywne promowanie gazetki promocyjnej poprzez umieszczanie i eksponowanie jej w popularnych i często odwiedzanych miejscach naszej strony.</p>
                            <p>Sieci handlowe mają możliwość promowania swojej oferty na stronach naszego serwisu co pozwala trafić do domów przyszłych Klientów. Oferujemy możliwość wyświetlania reklamy na stronach oraz aktywne promowanie gazetki promocyjnej poprzez umieszczanie i eksponowanie jej w popularnych i często odwiedzanych miejscach naszej strony.</p>
                            <p>Strona gazetkapromocyjna.com.pl skierowana jest również do innych portali internetowych, które chcą aktywnie się promować w Internecie za pomocą naszego serwisu.</p>
                            <p>GazetkaPromocyjna.com.pl</p>",

                    ]
                ]
        ];


        return view('main.about',[
                'place' => $place,

                // Opisy i dane globalne
                'h1_title'=> 'Najnowsze <strong>gazetki promocyjne</strong> - aktualne i nadchodzące promocje',
                'meta_title'=> 'Masz pytanie? Wypróbuj kontakt do nas | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',

                'breadcrumbs' => $breadcrumbs,
                'descriptions' => $descriptions,
            ]
        );
    }

    public function privacy()
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

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Polityka prywatności', 'url' => ''],
        ];

        return view('main.privacy-policy',[
                'place' => $place,

                // Opisy i dane globalne
                'h1_title'=> 'Polityka prywatności',
                'meta_title'=> 'Polityka prywatności | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',

                'breadcrumbs' => $breadcrumbs,

            ]
        );
    }

    public function cookies()
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

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Polityka cookies', 'url' => ''],
        ];


        return view('main.cookies-policy',[
                'place' => $place,

                // Opisy i dane globalne
                'h1_title'=> 'Polityka cookies',
                'meta_title'=> 'Polityka cookies | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',

                'breadcrumbs' => $breadcrumbs,

            ]
        );
    }
    public function statute()
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

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Regulamin', 'url' => ''],
        ];


        return view('main.statute',[
                'place' => $place,

                // Opisy i dane globalne
                'h1_title'=> 'Regulamin',
                'meta_title'=> 'Regulamin | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',

                'breadcrumbs' => $breadcrumbs,

            ]
        );
    }

    protected function shops(string $slug = null, $route = null)
    {
        $now = now('Europe/Warsaw')->toDateTime(); // Unikamy wielokrotnego wywoływania now()

        // Tworzymy zapytanie
        $shopsQuery = Shop::withCount(['leaflets' => function ($query) use ($now) {
            $query->whereBetween('valid_to', [$now, '9999-12-31 23:59:59']) // Szybsza wersja zamiast >=
            ->where('status', 'published')
                ->where('valid_from', '<=', $now);
        }])
            ->where('status', 'active')
            ->orderByDesc('ranking');

        // Jeśli slug jest podany, filtrujemy
        if (!is_null($slug)) {
            $shopsQuery->where('slug', '!=',$slug);
        }

        if ($route == 'main.index' || $route == 'main.index_gps') {
            $counter_shops = $shopsQuery->count() ?? 0;
        } else {
            $counter_shops = 0;
        }
        // Liczymy łączną liczbę sklepów spełniających warunki


        // Ograniczamy wyniki do 30
        $shops = $shopsQuery->take(30)->get();

        return [$shops, $counter_shops];
    }


    protected function leaflets($limit = 'all', $shop_id = null)
    {
        $leaflets = Leaflet::with(['shop', 'cover', 'pages'])
            ->where('display_to', '>=', now('Europe/Warsaw')->toDateTime())
            ->where('status', 'published')
            ->whereHas('cover') // dodane: tylko jeśli istnieje cover
            ->whereHas('pages');

            if(!is_null($shop_id)){
                $leaflets = $leaflets->where('shop_id', '=', $shop_id);
            }

        $leaflets = $leaflets->orderByDesc('updated_at')->get(); // Sortujemy od razu w bazie!

        if(is_null($shop_id)) {
            $counter_leaflets = $leaflets->count();
        } else {
            $counter_leaflets = 0;
        }

        if ($limit != 'all') {
            $leaflets->take($limit);
        }

        return [$leaflets, $counter_leaflets];

    }


    protected function vouchers()
    {
        $now = now('Europe/Warsaw')->toDateTime();

        return Voucher::with('voucherStore')
            ->where('valid_from', '<=', $now)
            ->where('valid_to', '>=', $now)
            ->where('status', 'active')
            ->limit(20)
            ->get();
    }

}

