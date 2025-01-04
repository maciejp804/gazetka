<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Shop;
use App\Models\ShopCategory;
use App\Models\Voivodeship;
use App\Models\Voucher;
use App\Services\SortOptionsService;
use App\Services\StaticDescriptions;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function index($descriptions, $leaflets, $mainDomain)
    {
        $voivodeships = Voivodeship::all();
        $voivodeship = $voivodeships->where('slug', '=','lodzkie')->first();

        $places = Place::with('voivodeship')->orderBy('name')->get();


        $place = $places->first();

        $shop_categories = ShopCategory::where('status', 1)->get();

        $products = Product::all();

        $vouchers = Voucher::with('voucherStore')->get();

        $leaflets_time = SortOptionsService::getSortOptions();

        $leaflets_category = ProductCategory::where('status', 1)->get();

        $static_description = StaticDescriptions::getDescriptions();

        $shops = Shop::all();

        $breadcrumbs = [];
        return view('main.places.index', data:
            [
                'mainDomain' => $mainDomain,
                'place' => $place->name,
                'places' => $places,
                'voivodeships' => $voivodeships,
                'latitude' => $voivodeship->lat,
                'longitude' => $voivodeship->lng,

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

    public function indexVoivodeship($slug, $descriptions, $leaflets, $mainDomain)
    {
        $voivodeships = Voivodeship::all();
        $voivodeship = $voivodeships->where('slug', $slug)->first();

        $places = Place::with('voivodeship')->where('voivodeship_id', $voivodeship->id) ->orderBy('name')->get();

        $place = $places->first();

        $shop_categories = ShopCategory::where('status', 1)->get();

        $products = Product::all();

        $vouchers = Voucher::with('voucherStore')->get();

        $leaflets_time = SortOptionsService::getSortOptions();

        $leaflets_category = ProductCategory::where('status', 1)->get();

        $static_description = StaticDescriptions::getDescriptions();

        $shops = Shop::all();

        $breadcrumbs = [];


        return view('main.places.indexVoivodeship', data:
            [
                'mainDomain' => $mainDomain,
                'place' => $place->name,
                'places' => $places,
                'voivodeships' => $voivodeships,
                'voivodeship' => $voivodeship,
                'latitude' => $voivodeship->lat,
                'longitude' => $voivodeship->lng,

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
}
