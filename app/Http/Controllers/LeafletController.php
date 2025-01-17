<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Shop;
use App\Services\SortOptionsService;
use App\Services\StaticDescriptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Jenssegers\Agent\Agent;
use function Webmozart\Assert\Tests\StaticAnalysis\object;

class LeafletController extends Controller
{
    public function index($descriptions, $leaflets)
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
        $products = Product::all();

        $leaflet_sort = SortOptionsService::getSortOptions();

        $leaflets_category = SortOptionsService::getCategoryOptions();

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Gazetki promocyjne', 'url' => ''],
        ];

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

    public function indexCategory($category, $descriptions, $leaflets)
    {
        $location = Cookie::get('user_location');
        if (!$location) {
            $placesAll = Place::all();
            $place = $placesAll->where('id', '=', 1172)->first();
        } else {
            $locationData = json_decode($location, true);
            $place = (object)$locationData;
        }

        $products = Product::all();

        $product_categories = ProductCategory::where('status', 1)->get();
        $category = $product_categories->where('slug', $category)->first();
        $leaflet_sort = SortOptionsService::getSortOptions();
        $leaflets_category = SortOptionsService::getCategoryOptions();


        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Gazetki Promocyjne', 'url' => route('main.leaflets')],
            ['label' => $category->name, 'url' => ''],
        ];
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

    public function indexGps($community, $descriptions, $leaflets_category, $leaflets)
    {
        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Gazetki Promocyjne', 'url' => route('main.leaflets')],
            ['label' => $community, 'url' => ''],
        ];

        $products = Product::all();

        $product_categories = ProductCategory::where('status', 1)->get();
        $leaflet_sort = SortOptionsService::getSortOptions();
        $leaflets_category = SortOptionsService::getCategoryOptions();
        return view('main.leaflets.index_gps', data:
            [
                'slug' => 'Poznań',
                'h1Title'=> 'Gazetki <strong>promocyjne</strong>',
                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,
                'leaflets' => $leaflets,
                'leaflets_category' => $leaflets_category,
                'leaflet_sort' => $leaflet_sort,
                'products' => $products,
                'product_categories' => $product_categories,
            ]);
    }

    public function subdomainLeaflet($subdomain, $id, $pages, $inserts, $insertData, $ads, $leaflets)
    {
        $shops = Shop::all();
        $shop = $shops->where('slug', $subdomain)->first();

        if (!$shop) {
            abort(404);
        }

        $averageRating = $shop->averageRating();
        $ratingCount = $shop->ratingCount();

        $placesAll = Place::all();
        $placesLimit40 = $placesAll->sortByDesc('population')->take(40);

        $location = Cookie::get('user_location');
        if (!$location) {
            $place = $placesAll->where('id', '=', 1172)->first();
        } else {
            $locationData = json_decode($location, true);
            $place = (object)$locationData;
        }

        $agent = new Agent();
        $isMobile = $agent->isMobile(); // Zwraca true, jeśli to urządzenie mobilne





        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => $shop->name, 'url' => route('subdomain.index', ['subdomain' => $subdomain])],
            ['label' => 'Gazetka promocyjna '. $shop->name, 'url' => '']
        ];



        // Filtrowanie według nazwy
        $leaflets = array_filter($leaflets, function ($item) use ($subdomain) {
            return str_starts_with(strtolower($item['name']), strtolower($subdomain)) !== false;
        });

        return view('subdomain.leaflet', data:
            [
                'place' => $place,
                'places' => $placesLimit40,

                'shop' => $shop,

                'h1_title'=> 'Gazetka promocyjna '.$shop->name.' od 12.11 do 24.12',
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

                'leaflets' => $leaflets


            ]);
    }
}
