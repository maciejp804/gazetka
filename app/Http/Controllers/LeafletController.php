<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Services\SortOptionsService;
use App\Services\StaticDescriptions;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class LeafletController extends Controller
{
    public function index($descriptions, $leaflets)
    {
        $places = Place::all();

        $places = $places->sortByDesc('population')->take(40);

        $place = $places->first();

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
                'places' => $places,
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
        $places = Place::all();

        $places = $places->sortByDesc('population')->take(40);

        $place = $places->first();

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
                'places' => $places,
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

    public function subdomainLeaflet($subdomain, $pages, $inserts, $insertData, $ads, $leaflets)
    {
        $agent = new Agent();
        $isMobile = $agent->isMobile(); // Zwraca true, jeśli to urządzenie mobilne

        $places = Place::all();
        $places = $places->sortByDesc('population')->take(40);
        $place = $places->first();

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Dino', 'url' => route('subdomain.index', ['subdomain' => $subdomain])],
            ['label' => 'Gazetka promocyjna z Dino', 'url' => '']
        ];

        $subdomain = 'lidl';

        // Filtrowanie według nazwy
        $leaflets = array_filter($leaflets, function ($item) use ($subdomain) {
            return str_starts_with(strtolower($item['name']), strtolower($subdomain)) !== false;
        });

        return view('subdomain.leaflet', data:
            [
                'place' => $place->name,
                'places' => $places,

                'h1_title'=> 'Gazetka promocyjna z Dino "Najbliżej Ciebie" (ważna od 10-10 do 16-10-2024)',
                'page_title'=> 'Gazetki promocyjne, nowe i nadchodzące promocje | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',

                'isMobile' => $isMobile,
                'pages' => $pages,
                'inserts' => $inserts,
                'insertData' => $insertData,
                'ads' => $ads,
                'subdomain' => $subdomain,
                'breadcrumbs' => $breadcrumbs,
                'leaflets' => $leaflets


            ]);
    }
}
