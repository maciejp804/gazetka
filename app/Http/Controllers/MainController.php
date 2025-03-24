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
use App\Services\ProductService;
use App\Services\SortOptionsService;
use App\Services\StaticDescriptions;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

class MainController extends Controller
{

    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function index()
    {
        $placesLimit40 = Place::orderByDesc('population')->limit(40)->get();

        $location = Cookie::get('user_location');
        if (!$location) {
            $place = Place::find(1172); // Szybsze niż `where('id', '=', 1172)->first();`
        } else {
            $locationData = json_decode($location, true);
            $place = Place::find($locationData['id']);
        }

        $leaflets = Leaflet::with(['shop', 'cover'])
            ->where('valid_to', '>=', now('Europe/Warsaw')->toDateTime())
            ->where('status', 'published')
            ->orderByDesc('updated_at') // Sortujemy od razu w bazie!
            ->limit(40) // Ograniczamy wynik od razu
            ->get();

        $leaflets_promo = Leaflet::with(['shop', 'cover'])
            ->where('valid_to', '>=', now('Europe/Warsaw')->toDateTime())
            ->where('status', 'published')
            ->where('pinned', 1)
            ->orderByDesc('priority')
            ->orderByDesc('updated_at')
            ->limit(20)
            ->get();

        $shop_categories = Category::where([
            ['status', 'active'],
            ['type', 'shop']
        ])->get();


        $products = $this->productService->getProducts('promo', null, null, null, null);

        $vouchers = $this->vouchers();

        $blogs = Blog::with('category')
            ->where('status', 'published')
            ->get();


        $leaflets_time = SortOptionsService::getSortOptions();

        $leaflets_category = Category::where([
            ['status', 'active'],
            ['type', 'product'],
            ['parent_id', null]
        ])->orderBy('name')->get();


        $info_description = StaticDescriptions::getDescriptions();

        $shops = $this->shops();

        $breadcrumbs = [];

        $descriptions = Description::getByRouteAndPlace(Route::currentRouteName())
            ?: Description::getDefault(Route::currentRouteName());



        return view('main.index', [

                //Lokalizacja
                'place' => $place->name,
                'places' => $placesLimit40,

                // Opisy i dane globalne
                'h1_title'=> $descriptions->h1_title,
                'page_title'=> $descriptions->meta_title,
                'meta_description' => $descriptions->meta_description,
                'info_description' => $info_description,
                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,

                //Gazetki
                'leaflets_promo' => $leaflets_promo,
                'leaflets' => $leaflets,
                'leaflets_category' => $leaflets_category,
                'shop_categories' => $shop_categories,
                'leaflets_time' => $leaflets_time,
                'products' => $products,
                'vouchers' => $vouchers,
                'shops' => $shops,
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
            ->get();

        $leaflets = Leaflet::with('shop', 'cover')
            ->where('valid_to', '>=', now('Europe/Warsaw')->toDateTime())
            ->where('status', '=', 'published')
            ->get(); // Gazetka musi być nadal ważna


        $leaflets_promo = $leaflets
            ->where('pinned', '=', 1)
            ->sortByDesc('priority')
            ->sortByDesc('updated_at')->take(20);



        $leaflets = $leaflets->sortByDesc('updated_at')->take(40);


        $categories = Category::where('status', 'active')->where('type', 'shop')->get();

        $products = $this->productService->getProducts('promo', null, null, null, null);

        $vouchers = $this->vouchers();

        $leaflets_time = SortOptionsService::getSortOptions();

        $leaflets_category = Category::where('status', 'active')
            ->where('type', 'product')
            ->get();

        $info_description = StaticDescriptions::getDescriptions();

        $shops = $this->shops();

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => $place->name, 'url' => ''],
        ];

        $blogs = Blog::with('category')->where('status', '=','published')->get();

        $descriptions = Description::getByRouteAndPlace(Route::currentRouteName(), $place) ?? Description::getDefault(Route::currentRouteName(), $place);

        return view('main.index_gps', data:
            [

                'place' => $place,
                'places' => $placesLimit40,

                'h1_title'=> $descriptions->h1_title,
                'page_title'=> $descriptions->meta_title,
                'meta_description' => $descriptions->meta_description,
                'info_description' => $info_description,
                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,

                'shop_categories' => $categories,

                //Gazetki
                'leaflets_promo' => $leaflets_promo,
                'leaflets' => $leaflets,
                'leaflets_category' => $leaflets_category,
                'leaflets_time' => $leaflets_time,
                'products' => $products,
                'vouchers' => $vouchers,
                'shops' => $shops,

                //Blogs
                'blogs' => $blogs,

                //Markers
                'markers' => $markers
            ]);
    }

    public function subdomainIndex($subdomain)
    {

        $shop = Shop::where('slug', $subdomain)->first();

        if(!$shop)
        {
            abort(404);
        }
        $shops = $this->shops();
        $shops = $shops->where('slug', '!=', $shop->slug);

        $leaflets = Leaflet::with('shop')
            ->where('valid_to', '>=', now()->toDateString())
            ->where('shop_id',$shop->id)->get(); // Gazetka musi być nadal ważna



        $leaflets = $leaflets->sortByDesc('created_at')->take(40);

        $placesAll = Place::all();

        $placesLimit40 = $placesAll->sortByDesc('population')->take(40);

        $location = Cookie::get('user_location');

        if (!$location) {
            $place = $placesAll->where('id', '=', 1172)->first();
        } else {
            $locationData = json_decode($location, true);
            $place = $placesAll->where('id', '=', $locationData['id'])->first();
        }

        $averageRating = $shop->averageRating();
        $ratingCount = $shop->ratingCount();

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Gazetki '. $shop->name, 'url' => '']
        ];

        $vouchers = $this->vouchers();

        $leaflets_time = SortOptionsService::getSortOptions(false);

        $leaflets_category = Category::where('status', 'active')
            ->where('type', 'product')
            ->where('parent_id', '=', null)
            ->orderBy('name', 'asc')
            ->get();

        $products = $this->productService->getProducts('normal', null, null, $shop->slug, null);

        $blogs = Blog::with('category')->where('status', '=','published')->get();

        $descriptions = Description::getByRouteAndPlace(Route::currentRouteName(), $place) ?? Description::getDefault(Route::currentRouteName(), $place);

        return view('subdomain.index', [
            //Zmienne globalne
            'subdomain' => $subdomain,

            // Lokalizacja
            'place' => $place,
            'places' => $placesLimit40,

            // Opisy i dane globalne
            'h1_title' => $shop->name . ' • gazetka promocyjna ' . date('d.m', strtotime('now')) . ' • aktualne promocje',
            'page_title' => $shop->name . ' gazetka aktualna • promocje, oferta ' . date('d.m', strtotime('now')) . ' | GazetkaPromocyjna.com.pl',
            'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',

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
            'vouchers' => $vouchers, // kupony
            'shops' => $shops, // sklepy
            'shop' => $shop,

            //Blog
            'blogs' => $blogs,

            //Opis strony
            'descriptions' => $descriptions,
        ]);

    }

    public function subdomainIndexGps($subdomain, $community)
    {
        $placesAll = Place::all();
        $place = $placesAll->where('slug', $community)->first();



        $shop = Shop::where('slug', $subdomain)->first();

        if(!$place || !$shop)
        {
            abort(404);
        }

        $shops = $this->shops();

        $markers = Marker::with('shop', 'place', 'hours')
            ->whereHas('shop', function ($query) use ($shop) {
                $query->where('status', 1);
            })
            ->where('shop_id', $shop->id)
            ->where('place_id', $place->id)
            ->get();

        $leaflets = Leaflet::with('shop')->where('valid_to','>=',now())->where('shop_id',$shop->id)->get();

        $leaflets = $leaflets->sortByDesc('created_at')->take(40);

        // Zapisz lokalizację w ciasteczku
        Cookie::queue('user_location', json_encode([
            'id' => $place->id,
            'name' => $place->name,
            'latitude' => $place->lat,
            'longitude' => $place->lng,
        ],JSON_PRETTY_PRINT), 60 * 24 * 7, '/', '.'.config('app.main_domain'), false, false); // Zapis na 7 dni

        $shopsOther = $shops->where('slug', '!=', $subdomain);

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

        $blogs = Blog::with('category')->where('status', '=','published')->get();

        $descriptions = Description::getByRouteAndPlace(Route::currentRouteName(), $place) ?? Description::getDefault(Route::currentRouteName(), $place);

         return view('subdomain.index_gps', [
                //Zmienne globalne
                'subdomain' => $subdomain,

                //Lokalizacja
                'place' => $place,
                'markers' => $markers,

                'h1_title'=> $shop->name. ' '. $place->name .' • gazetki promocyjne',
                'page_title'=> $shop->name. ' '. $place->name .' • gazetka, godziny otwarcia | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',

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
                'shopsOther' => $shopsOther,
                'shop' => $shop,

                //Blogs
                'blogs' => $blogs,

                //Opis strony
                'descriptions' => $descriptions,
            ]);
    }

    public function about()
    {

        $location = Cookie::get('user_location');

        if (!$location) {
            $place = Place::where('id', '=', 1172)->first();
        } else {
            $locationData = json_decode($location, true);
            $place = Place::where('id', '=', $locationData['id'])->first();
        }

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'O GazetkaPromocyjna', 'url' => ''],
        ];

        $descriptions = Description::getByRouteAndPlace(Route::currentRouteName()) ?? Description::getDefault(Route::currentRouteName());

        return view('main.about',[
                'place' => $place,

                // Opisy i dane globalne
                'h1_title'=> 'Najnowsze <strong>gazetki promocyjne</strong> - aktualne i nadchodzące promocje',
                'page_title'=> 'Masz pytanie? Wypróbuj kontakt do nas | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',

                'breadcrumbs' => $breadcrumbs,
                'descriptions' => $descriptions,
            ]
        );
    }

    public function privacy()
    {

        $location = Cookie::get('user_location');

        if (!$location) {
            $place = Place::where('id', '=', 1172)->first();
        } else {
            $locationData = json_decode($location, true);
            $place = Place::where('id', '=', $locationData['id'])->first();
        }

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Polityka prywatności', 'url' => ''],
        ];

        $descriptions = [
            ['img' => 'assets/images/statics/1.png',
                'h2Title' => 'Historia',
                'h3Title' => '',
                'p' => ['Strona gazetkapromocyjna.com.pl powstała w 2012 roku i jest własnością firmy Gazetka Promocyjna, która swoją siedzibę ma w Poznaniu.',
                    'Głównym celem serwisu jest gromadzenie i prezentowanie aktualnej oferty najpopularniejszych sieci handlowych w postaci - gazetek. W swojej bazie posiadamy promocje z różnych gałęzi handlu takich jak: artykuły spożywcze, artykuły gospodarstwa domowego, artykuły rtv i agd oraz wiele innych. Zasięgiem obejmujemy całą Polskę. Użytkownicy serwisu mogą przeglądać oferty wielu sieci i sklepów bez wychodzenia z domu. Sieci handlowe mają możliwość promowania swojej oferty na stronach naszego serwisu co pozwala trafić do domów przyszłych Klientów. Oferujemy możliwość wyświetlania reklamy na stronach oraz aktywne promowanie gazetki promocyjnej poprzez umieszczanie i eksponowanie jej w popularnych i często odwiedzanych miejscach naszej strony.',
                    'Sieci handlowe mają możliwość promowania swojej oferty na stronach naszego serwisu co pozwala trafić do domów przyszłych Klientów. Oferujemy możliwość wyświetlania reklamy na stronach oraz aktywne promowanie gazetki promocyjnej poprzez umieszczanie i eksponowanie jej w popularnych i często odwiedzanych miejscach naszej strony.',
                    'Strona gazetkapromocyjna.com.pl skierowana jest również do innych portali internetowych, które chcą aktywnie się promować w Internecie za pomocą naszego serwisu.',
                    'GazetkaPromocyjna.com.pl'
                ],
            ]
        ];

        return view('main.privacy-policy',[
                'place' => $place,

                // Opisy i dane globalne
                'h1_title'=> 'Polityka prywatności',
                'page_title'=> 'Polityka prywatności | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',

                'breadcrumbs' => $breadcrumbs,
                'descriptions' => $descriptions,
            ]
        );
    }

    public function cookies()
    {

        $location = Cookie::get('user_location');

        if (!$location) {
            $place = Place::where('id', '=', 1172)->first();
        } else {
            $locationData = json_decode($location, true);
            $place = Place::where('id', '=', $locationData['id'])->first();
        }

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Polityka cookies', 'url' => ''],
        ];


        return view('main.cookies-policy',[
                'place' => $place,

                // Opisy i dane globalne
                'h1_title'=> 'Polityka cookies',
                'page_title'=> 'Polityka cookies | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',

                'breadcrumbs' => $breadcrumbs,

            ]
        );
    }
    public function statute()
    {

        $location = Cookie::get('user_location');

        if (!$location) {
            $place = Place::where('id', '=', 1172)->first();
        } else {
            $locationData = json_decode($location, true);
            $place = Place::where('id', '=', $locationData['id'])->first();
        }

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Regulamin', 'url' => ''],
        ];


        return view('main.statute',[
                'place' => $place,

                // Opisy i dane globalne
                'h1_title'=> 'Regulamin',
                'page_title'=> 'Regulamin | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',

                'breadcrumbs' => $breadcrumbs,

            ]
        );
    }

    protected function shops()
    {
        $now = now('Europe/Warsaw')->toDateTime(); // Unikamy wielokrotnego wywoływania now()

        return Shop::withCount(['leaflets' => function ($query) use ($now) {
            $query->whereBetween('valid_to', [$now, '9999-12-31 23:59:59']) // Szybsza wersja zamiast >=
            ->where('status', 'published')
                ->where('valid_from', '<=', $now);
        }])
            ->where('status', 'active')
            ->orderByDesc('ranking')
            ->take(30)
            ->get();
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

