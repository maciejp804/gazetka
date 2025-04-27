<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Description;
use App\Models\Leaflet;
use App\Models\Place;
use App\Models\Shop;
use App\Models\Tag;
use App\Models\Voucher;
use App\Models\VoucherStore;
use App\Services\ImageService;
use App\Services\SortOptionsService;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
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
        $vouchers = Voucher::with('voucherStore')
            ->where('valid_to', '>=', now('Europe/Warsaw'))->paginate(9);

        $voucher_sort = SortOptionsService::getSortOptions();

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Kupony rabatowe', 'url' => ''],
        ];

        $descriptions = Description::getByRouteAndPlace(Route::currentRouteName());
        $default_descriptions = Description::getDefaultVouchers(Route::currentRouteName());

        $leaflets = Leaflet::with('shop','cover', 'pages')
            ->where('valid_to','>=',now())
            ->whereHas('cover')
            ->whereHas('pages')
            ->orderBy('created_at', 'desc')
            ->limit(40)
            ->get();

        return view('main.vouchers.index', data:
            [

                //Lokalizacja
                'place' => $place,

                // Opisy i dane globalne
                'h1_title' => $descriptions->h1_title ?? $default_descriptions->h1_title ?? "DoMyślny",
                'meta_title'=> $descriptions->meta_title ?? $default_descriptions->meta_title ?? "DoMyślny",
                'meta_description' => $descriptions->meta_description ?? $default_descriptions->meta_description ?? "DoMyślny",
                'descriptions' => $descriptions,
                'excerpt' => $descriptions->excerpt ?? $default_descriptions->excerpt ?? "DoMyślny",
                'breadcrumbs' => $breadcrumbs,


                'voucher_categories' => $categories,
                'tags' => $tags,
                'voucher_sort' => $voucher_sort,
                'vouchers' => $vouchers,
                'shops' => $shops,
                'leaflets' => $leaflets,
            ]);
    }

    public function indexCategory($category)
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

        $vouchers = Voucher::with('voucherStore')->where('category_id', $category->id)
            ->where('valid_to', '>=', now('Europe/Warsaw'))->paginate(9);

        $shops = $this->shops(32);

        $leaflets = Leaflet::with('shop','cover', 'pages')
            ->where('valid_to','>=',now())
            ->whereHas('cover')
            ->whereHas('pages')
            ->orderBy('created_at', 'desc')
            ->limit(40)
            ->get();

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Kupony rabatowe', 'url' => route('main.vouchers')],
            ['label' => $category->name, 'url' => ''],
        ];

        $voucher_sort = SortOptionsService::getSortOptions();

        $descriptions = Description::getByRouteAndPlace(Route::currentRouteName());
        $default_descriptions = Description::getDefaultVouchers(Route::currentRouteName(), $category);

        return view('main.vouchers.index_category', data:
            [
                'place' => $place,

                // Opisy i dane globalne
                'h1_title' => $descriptions->h1_title ?? $default_descriptions->h1_title ?? "DoMyślny",
                'meta_title'=> $descriptions->meta_title ?? $default_descriptions->meta_title ?? "DoMyślny",
                'meta_description' => $descriptions->meta_description ?? $default_descriptions->meta_description ?? "DoMyślny",
                'descriptions' => $descriptions,
                'excerpt' => $descriptions->excerpt ?? $default_descriptions->excerpt ?? "DoMyślny",
                'breadcrumbs' => $breadcrumbs,

                'voucher_categories' => $categories,
                'tags' => $tags,
                'voucher_sort' => $voucher_sort,
                'vouchers' => $vouchers,
                'category' => $category,
                'shops' => $shops,
                "leaflets" => $leaflets,
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
