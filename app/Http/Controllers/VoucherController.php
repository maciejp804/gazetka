<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Description;
use App\Models\Place;
use App\Models\Shop;
use App\Models\Tag;
use App\Models\Voucher;
use App\Services\SortOptionsService;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

class VoucherController extends Controller
{


    public function index()
    {
        $placesAll = Place::all();

        $location = Cookie::get('user_location');

        if (!$location) {
            $place = $placesAll->where('id', '=', 1172)->first();
        } else {
            $locationData = json_decode($location, true);
            $place = $placesAll->where('id', '=', $locationData['id'])->first();
        }

        $shops = $this->shops(32);

        $categories = Category::where('status','active')->where('type', 'voucher')->get();
        $model = new Voucher(); // Przykład: szukamy tagów dla kuponów
        $tags = Tag::whereJsonContains('applies_to', class_basename($model))->where('start_date', '<', now())->where('end_date', '>', now())->get();
        $vouchers = Voucher::with('voucherStore')->paginate(9);
        $voucher_sort = SortOptionsService::getSortOptions();

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Kupony rabatowe', 'url' => ''],
        ];

        $descriptions = Description::getByRouteAndPlace(Route::currentRouteName(), $place) ?? Description::getDefault(Route::currentRouteName(), $place);

        return view('main.vouchers.index', data:
            [

                //Lokalizacja
                'place' => $place,

                'h1_title'=> 'Aktualne kody rabatowe '.monthReplace(date('Y-m-d',strtotime('now')), 'full', 'm-Y').' - kupony na zniżki promocyjne',
                'page_title'=> 'Aktualne kody rabatowe, promocje, zniżki '.monthReplace(date('Y-m-d',strtotime('now')), 'full', 'm-Y').' | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',

                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,

                'voucher_categories' => $categories,
                'tags' => $tags,
                'voucher_sort' => $voucher_sort,
                'vouchers' => $vouchers,
                'shops' => $shops,
            ]);
    }

    public function indexCategory($category, $descriptions, $retailers_category, $retailers_time, $products)
    {

        $categories = Category::where('status','active')->where('type', 'voucher')->get();
        $category = $categories->where('slug', $category)->first();

        if(!$category){
            abort(404);
        }

        $placesAll = Place::all();

        $location = Cookie::get('user_location');

        if (!$location) {
            $place = $placesAll->where('id', '=', 1172)->first();
        } else {
            $locationData = json_decode($location, true);
            $place = $placesAll->where('id', '=', $locationData['id'])->first();
        }

        $model = new Voucher(); // Przykład: szukamy tagów dla kuponów
        $tags = Tag::whereJsonContains('applies_to', class_basename($model))->get();

        $vouchers = Voucher::with('voucherStore')->where('category_id', $category->id)->get();

        $shops = $this->shops(32);

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Kupony rabatowe', 'url' => route('main.vouchers')],
            ['label' => $category->name, 'url' => ''],
        ];

        $voucher_sort = SortOptionsService::getSortOptions();

        $descriptions = Description::getByRouteAndPlace(Route::currentRouteName(), $place) ?? Description::getDefault(Route::currentRouteName(), $place);

        return view('main.vouchers.index_category', data:
            [
                'place' => $place,


                'h1_title'=> 'Aktualne kody rabatowe w kategorii <strong>'.mb_strtolower($category->name).'</strong> '.monthReplace(date('Y-m-d',strtotime('now')), 'full', 'm-Y').' - kupony na zniżki promocyjne',
                'page_title'=> 'Aktualne kody rabatowe, promocje, zniżki w kategorii '.$category->name.' '.monthReplace(date('Y-m-d',strtotime('now')), 'full', 'm-Y').' | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',

                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,
                'retailers_category' => $retailers_category,
                'retailers_time' => $retailers_time,
                'products' => $products,
                'voucher_categories' => $categories,
                'tags' => $tags,
                'voucher_sort' => $voucher_sort,
                'vouchers' => $vouchers,
                'category' => $category,
                'shops' => $shops,
            ]);
    }

    protected function shops($limit)
    {
        return Shop::withCount(['leaflets' => function ($query) {
            $query->where('valid_to', '>=',now('Europe/Warsaw')->toDateTime())
                ->where('status', '=', 'published')
                ->where('valid_from', '<=', now('Europe/Warsaw')->toDateTime());
        }])->where('status', '=', 1)
            ->orderBy('ranking', 'desc')->take($limit)->get();
    }
}
