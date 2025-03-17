<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Description;
use App\Models\Leaflet;
use App\Models\Place;
use App\Models\Shop;
use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Services\SortOptionsService;
use App\Services\StaticDescriptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

        $categories = Category::where('status', 'active')->where('type', 'shop')->get();

        $retailers = Shop::withCount(['leaflets' => function ($query) {
            $query->where('valid_to', '>=',now('Europe/Warsaw')->toDateTime())
                ->where('status', '=', 'published')
                ->where('valid_from', '<=', now('Europe/Warsaw')->toDateTime());
        }])->where('status', 'active')->paginate(10);
        $retailers_time = SortOptionsService::getSortPopularity();
        $static_description = StaticDescriptions::getDescriptions();

        $leaflets = Leaflet::with('shop')
            ->where('valid_to','>=', now())
            ->orderBy('created_at', 'desc')
            ->limit(40)
            ->get();

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Sieci handlowe', 'url' => ''],
        ];

        $descriptions = Description::getByRouteAndPlace(Route::currentRouteName(), $place) ?? Description::getDefault(Route::currentRouteName(), $place);

        return view('main.retailers.index', data:
            [

                'place' => $place->name,
                'h1_title'=> 'Sieci <strong>handlowe</strong>',
                'page_title'=> 'Gazetki promocyjne, nowe i nadchodzące promocje | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',
                'static_description' => $static_description,

                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,
                'leaflets' => $leaflets,
                'retailers' => $retailers,
                'retailers_category' => $categories,
                'retailers_time' => $retailers_time,

            ]);
    }

    public function indexCategory($category)
    {
        $categories = Category::where('status', 'active')->where('type', 'shop')->get();
        $category = $categories->where('slug', $category)->where('type', 'shop')->first();

        if (!$category)
        {
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

        $static_description = StaticDescriptions::getDescriptions();

        $retailers_time = SortOptionsService::getSortPopularity();

        $retailers = Shop::where('status', 1)->where('category_id', $category->id)->paginate(10);

        $leaflets = Leaflet::with('shop')
            ->where('valid_to','>=', now())
            ->orderBy('created_at', 'desc')
            ->limit(40)
            ->get();

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Sieci handlowe', 'url' => route('main.retailers')],
            ['label' => $category->name, 'url' => ''],
        ];

        $descriptions = Description::getByRouteAndPlace(Route::currentRouteName(), $place) ?? Description::getDefault(Route::currentRouteName(), $place);

        return view('main.retailers.index_category', data:
            [

                'place' => $place,
                'h1_title'=> 'Sieci handlowe - markety i sklepy spożywcze',
                'page_title'=> 'Gazetki promocyjne, nowe i nadchodzące promocje | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',
                'static_description' => $static_description,

                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,
                'leaflets' => $leaflets,
                'retailers' => $retailers,
                'retailers_category' => $categories,
                'retailers_time' => $retailers_time,
                'category' => $category,
            ]);
    }

    public function subdomainShowAddress($subdomain, $community)
    {
        $placesAll = Place::all();
        $place = $placesAll->where('slug', '=', $community)->first();

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

        $averageRating = $shop->averageRating();
        $ratingCount = $shop->ratingCount();

        $leaflets = Leaflet::with('shop')
            ->where('shop_id', $shop->id)
            ->where('valid_to','>=', now())
            ->orderBy('created_at', 'desc')
            ->limit(40)
            ->get();

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => $shop->name, 'url' => route('subdomain.index', ['subdomain' => $subdomain])],
            ['label' => $shop->name.' '.$place->name, 'url' => route('subdomain.index_gps', ['subdomain' => $subdomain, 'community' => $community])],
            ['label' => 'os. Przytorze 36', 'url' => ''],
        ];


        $leaflets_time = SortOptionsService::getSortOptions(false);
        $categories = Category::where('status', 'active')->where('type', 'shop')->get();

        $vouchers = Voucher::with('voucherStore')
            ->where('vouchers.valid_from', '<=', now('Europe/Warsaw')->toDateTime())
            ->where('vouchers.valid_to', '>=', now('Europe/Warsaw')->toDateTime())
            ->where('status', '=', 'active')
            ->limit(20)
            ->get();

        $blogs = Blog::with('category')->where('status', '=','published')->get();

        return view('subdomain.shop',
            [
                'subdomain' => $subdomain,

                'place' => $place,

                'h1_title'=> $shop->name.' '.$place->name.', os. Przytorze 36',
                'page_title'=> 'Gazetki promocyjne, nowe i nadchodzące promocje | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',


                'breadcrumbs' => $breadcrumbs,

                // Rating
                'averageRating' => $averageRating,
                'ratingCount' => $ratingCount,
                'model' => "Place",

                'leaflets_category' => $categories,
                'leaflets_time' => $leaflets_time,
                'leaflets' => $leaflets,
                'vouchers' => $vouchers,

                //Blog
                'blogs' => $blogs,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Shop $shop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shop $shop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shop $shop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shop $shop)
    {
        //
    }
}
