<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\Shop;
use App\Models\Tag;
use App\Models\Voucher;
use App\Models\VoucherCategory;
use App\Services\SortOptionsService;
use App\Services\StaticDescriptions;
use Illuminate\Http\Request;

class VoucherController extends Controller
{


    public function index( $descriptions, $retailers_category, $retailers_time, $products)
    {

        $places = Place::all();
        $places = $places->sortByDesc('population')->take(40);
        $place = $places->first();

        $shops = Shop::all();

        $voucher_categories = VoucherCategory::where('status',1)->get();
        $model = new Voucher(); // Przykład: szukamy tagów dla kuponów
        $tags = Tag::whereJsonContains('applies_to', class_basename($model))->where('start_date', '<', now())->where('end_date', '>', now())->get();
        $vouchers = Voucher::with('voucherStore')->get();

        $voucher_sort = SortOptionsService::getSortOptions();

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Kupony rabatowe', 'url' => ''],
        ];

        return view('main.vouchers.index', data:
            [
                'place' => $place->name,
                'places' => $places,

                'h1_title'=> 'Aktualne kody rabatowe '.monthReplace(date('Y-m-d',strtotime('now')), 'full', 'm-Y').' - kupony na zniżki promocyjne',
                'page_title'=> 'Aktualne kody rabatowe, promocje, zniżki '.monthReplace(date('Y-m-d',strtotime('now')), 'full', 'm-Y').' | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',

                'h1Title'=> '',
                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,
                'retailers_category' => $retailers_category,
                'retailers_time' => $retailers_time,
                'products' => $products,
                'voucher_categories' => $voucher_categories,
                'tags' => $tags,
                'voucher_sort' => $voucher_sort,
                'vouchers' => $vouchers,
                'shops' => $shops,
            ]);
    }

    public function indexCategory($category, $descriptions, $retailers_category, $retailers_time, $products)
    {

        $voucher_categories = VoucherCategory::where('status',1)->get();
        $category = $voucher_categories->where('slug', $category)->first();

        if(!$category){
            abort(404);
        }

        $model = new Voucher(); // Przykład: szukamy tagów dla kuponów
        $tags = Tag::whereJsonContains('applies_to', class_basename($model))->get();

        $vouchers = Voucher::with('voucherStore')->where('voucher_category_id', $category->id)->get();

        $places = Place::all();
        $places = $places->sortByDesc('population')->take(40);
        $place = $places->first();

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Kupony rabatowe', 'url' => ''],
            ['label' => $category->name, 'url' => ''],
        ];

        $voucher_sort = SortOptionsService::getSortOptions();

        return view('main.vouchers.index_category', data:
            [
                'place' => $place->name,
                'places' => $places,

                'h1_title'=> 'Aktualne kody rabatowe w kategorii <strong>'.mb_strtolower($category->name).'</strong> '.monthReplace(date('Y-m-d',strtotime('now')), 'full', 'm-Y').' - kupony na zniżki promocyjne',
                'page_title'=> 'Aktualne kody rabatowe, promocje, zniżki w kategorii '.$category->name.' '.monthReplace(date('Y-m-d',strtotime('now')), 'full', 'm-Y').' | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',

                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,
                'retailers_category' => $retailers_category,
                'retailers_time' => $retailers_time,
                'products' => $products,
                'voucher_categories' => $voucher_categories,
                'tags' => $tags,
                'voucher_sort' => $voucher_sort,
                'vouchers' => $vouchers,
                'category' => $category,
            ]);
    }
}