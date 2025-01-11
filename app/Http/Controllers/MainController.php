<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Shop;
use App\Models\ShopCategory;
use App\Models\Voucher;
use App\Services\SortOptionsService;
use App\Services\StaticDescriptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class MainController extends Controller
{
    public function index($descriptions, $leaflets)
    {

        $placesAll = Place::all();

        $placesLimit40 = $placesAll->sortByDesc('population')->take(40);

        $location = Cookie::get('user_location');

        if (!$location) {
            $place = $placesAll->where('id', '=', 1172)->first();
        } else {
            $locationData = json_decode($location, true);
            $place = $placesAll->where('id', '=', $locationData['id'])->first();
        }

        $shop_categories = ShopCategory::where('status', 1)->get();

        $products = Product::all();

        $vouchers = Voucher::with('voucherStore')->get();

        $leaflets_time = SortOptionsService::getSortOptions();

        $leaflets_category = ProductCategory::where('status', 1)->get();

        $static_description = StaticDescriptions::getDescriptions();

        $shops = Shop::all();

        $breadcrumbs = [];

        return view('main.index', data:
            [

                'place' => $place->name,
                'places' => $placesLimit40,

                'h1_title'=> 'Najnowsze <strong>gazetki promocyjne</strong> - aktualne i nadchodzące promocje',
                'page_title'=> 'Gazetki promocyjne, nowe i nadchodzące promocje | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',
                'static_description' => $static_description,
                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,
                'leaflets' => $leaflets,
                'leaflets_category' => $leaflets_category,
                'shop_categories' => $shop_categories,
                'leaflets_time' => $leaflets_time,
                'products' => $products,
                'vouchers' => $vouchers,
                'shops' => $shops,

            ]);
    }

    public function indexGps($community, $descriptions, $leaflets)
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

        $shop_categories = ShopCategory::where('status', 1)->get();

        $products = Product::all();

        $vouchers = Voucher::with('voucherStore')->get();

        $leaflets_time = SortOptionsService::getSortOptions();

        $leaflets_category = ProductCategory::where('status', 1)->get();

        $static_description = StaticDescriptions::getDescriptions();

        $shops = Shop::all();

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => $place->name, 'url' => ''],
        ];

        return view('main.index_gps', data:
            [

                'place' => $place,
                'places' => $placesLimit40,

                'h1_title'=> 'Wszystkie <strong>gazetki promocyjne</strong> w jednym miejscu w '.$place->name_locative,
                'page_title'=> 'Gazetki promocyjne, nowe i nadchodzące promocje | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',
                'static_description' => $static_description,
                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,
                'leaflets' => $leaflets,
                'shop_categories' => $shop_categories,
                'leaflets_category' => $leaflets_category,
                'leaflets_time' => $leaflets_time,
                'products' => $products,
                'vouchers' => $vouchers,
                'shops' => $shops,
            ]);
    }

    public function subdomainIndex($subdomain, $leaflets)
    {

        $placesAll = Place::all();

        $placesLimit40 = $placesAll->sortByDesc('population')->take(40);

        $location = Cookie::get('user_location');

        if (!$location) {
            $place = $placesAll->where('id', '=', 1172)->first();
        } else {
            $locationData = json_decode($location, true);
            $place = $placesAll->where('id', '=', $locationData['id'])->first();
        }

        $shops = Shop::all();
        $shop = $shops->where('slug', $subdomain)->first();
        $shops->where('slug', '!=', $subdomain);

        if(!$shop)
        {
            abort(404);
        }

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Gazetki '. $shop->name, 'url' => '']
        ];

        $vouchers = Voucher::with('voucherStore')->get();

        $leaflets_time = SortOptionsService::getSortOptions();

        $leaflets_category = ProductCategory::where('status', 1)->get();


        // Filtrowanie według nazwy
        $leaflets = array_filter($leaflets, function ($item) use ($subdomain) {
            return str_starts_with(strtolower($item['name']), strtolower($subdomain)) !== false;
        });

        $products = Product::all();

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

            // Produkty

            'products' => $products,
            'leaflets_category' => $leaflets_category, // gazetki
            'leaflets_time' => $leaflets_time,
            'leaflets' => $leaflets,
            'vouchers' => $vouchers, // kupony
            'shops' => $shops, // sklepy
            'shop' => $shop,
        ]);

    }

    public function subdomainIndexGps($subdomain, $community, $leaflets)
    {
        $placesAll = Place::all();
        $place = $placesAll->where('slug', $community)->first();
        $shops = Shop::all();
        $shop = $shops->where('slug', $subdomain)->first();

        if(!$place || !$shop)
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

        $shopsOther = $shops->where('slug', '!=', $subdomain);


        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Gazetki '. $shop->name, 'url' => route('subdomain.index', ['subdomain' => $subdomain])],
            ['label' => $shop->name.' '.$place->name, 'url' => ""]
        ];

        $vouchers = Voucher::with('voucherStore')->get();

        $leaflets_time = SortOptionsService::getSortOptions();

        $leaflets_category = ProductCategory::where('status', 1)->get();

        // Filtrowanie według nazwy
        $leaflets = array_filter($leaflets, function ($item) use ($subdomain) {
            return str_starts_with(strtolower($item['name']), strtolower($subdomain)) !== false;
        });


        return view('subdomain.index_gps', data:
            [
                'place' => $place,

                'h1_title'=> $shop->name. ' '. $place->name .' • gazetki promocyjne',
                'page_title'=> $shop->name. ' '. $place->name .' • gazetka, godziny otwarcia | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',
                'subdomain' => $subdomain,
                'breadcrumbs' => $breadcrumbs,
                'leaflets_category' => $leaflets_category,
                'leaflets_time' => $leaflets_time,
                'leaflets' => $leaflets,
                'vouchers' => $vouchers,
                'shopsOther' => $shopsOther,
                'shop' => $shop,
            ]);
    }
}
