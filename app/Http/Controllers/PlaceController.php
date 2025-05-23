<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Place;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Voivodeship;
use App\Models\Voucher;
use App\Services\SortOptionsService;
use App\Services\StaticDescriptions;
use Illuminate\Support\Facades\Cookie;

class PlaceController extends Controller
{
    public function index()
    {

        $voivodeships = Voivodeship::all();

        $voivodeship = $voivodeships->where('slug', '=','lodzkie')->first();

        $placesAll = Place::with('voivodeship')->orderBy('name')->get();

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
            ['label' => 'Cała Polska', 'url' => ''],

        ];
        return view('main.places.index', data:
            [
                'place' => $place->name,
                'places' => $placesAll,
                'voivodeships' => $voivodeships,
                'latitude' => $voivodeship->lat,
                'longitude' => $voivodeship->lng,

                'h1_title'=> 'Najnowsze <strong>gazetki promocyjne</strong> - aktualne i nadchodzące promocje',
                'meta_title'=> 'Gazetki promocyjne, nowe i nadchodzące promocje | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',

                'breadcrumbs' => $breadcrumbs,

            ]);
    }

    public function indexVoivodeship($category)
    {
        $voivodeships = Voivodeship::all();
        $voivodeship = $voivodeships->where('slug', $category)->first();

        $placesAll = Place::with('voivodeship')->orderBy('name')->get();
        $placesVoivodeship = $placesAll->where('voivodeship_id', $voivodeship->id) ->sortBy('name');

        $location = Cookie::get('user_location');
        $place = Place::where('id', '=', 1172)->first();
//        $location = Cookie::get('user_location');
//        if (!$location) {
//            $placesAll = Place::all();
//            $place = $placesAll->where('id', '=', 1172)->first();
//        } else {
//            $locationData = json_decode($location, true);
//            $place = (object)$locationData;
//        }
//        if (!$location) {
//            $place = $placesAll->where('id', '=', 1172)->first();
//        } else {
//            $locationData = json_decode($location, true);
//            $place = $placesAll->where('id', '=', $locationData['id'])->first();
//        }


        $categories = Category::where('status', 'active')->where('type', 'shop')->get();

        $products = Product::all();

        $vouchers = Voucher::with('voucherStore')->get();

        $leaflets_time = SortOptionsService::getSortOptions();

        $leaflets_category = Category::where('status', 'active')->where('type', 'product')->get();

        $static_description = StaticDescriptions::getDescriptions();

        $shops = Shop::all();

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Cała Polska', 'url' => route('main.maps')],
            ['label' => mb_ucfirst($voivodeship->name), 'url' => ''],
        ];


        return view('main.places.indexVoivodeship', data:
            [

                'place' => $place->name,
                'places' => $placesVoivodeship,
                'voivodeships' => $voivodeships,
                'voivodeship' => $voivodeship,
                'latitude' => $voivodeship->lat,
                'longitude' => $voivodeship->lng,

                'h1_title'=> 'Najnowsze <strong>gazetki promocyjne</strong> - aktualne i nadchodzące promocje',
                'meta_title'=> 'Gazetki promocyjne, nowe i nadchodzące promocje | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',

                'breadcrumbs' => $breadcrumbs,

                'products' => $products,
                'vouchers' => $vouchers,
                'shops' => $shops,

            ]);
    }
}
