<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Shop;
use App\Http\Controllers\Controller;
use App\Models\ShopCategory;
use App\Models\Voucher;
use App\Services\SortOptionsService;
use App\Services\StaticDescriptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

        $retailers_category = ShopCategory::where('status', 1)->get();
        $retailers = Shop::where('status', 1)->get();
        $retailers_time = SortOptionsService::getSortOptions();
        $static_description = StaticDescriptions::getDescriptions();

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Sieci handlowe', 'url' => ''],
        ];



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
                'retailers_category' => $retailers_category,
                'retailers_time' => $retailers_time,

            ]);
    }

    public function indexCategory($category, $descriptions, $leaflets)
    {
        $retailers_category = ShopCategory::where('status', 1)->get();
        $category = $retailers_category->where('slug', $category)->first();
        if (!$category)
        {
            abort(404);
        }

        $location = Cookie::get('user_location');
        if (!$location) {
            $placesAll = Place::all();
            $place = $placesAll->where('id', '=', 1172)->first();
        } else {
            $locationData = json_decode($location, true);
            $place = (object)$locationData;
        }

        $static_description = StaticDescriptions::getDescriptions();

        $retailers_time = SortOptionsService::getSortOptions();

        $retailers = Shop::where('status', 1)->where('shop_category_id', $category->id)->get();

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Sieci handlowe', 'url' => route('main.retailers')],
            ['label' => $category->name, 'url' => ''],
        ];



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
                'retailers_category' => $retailers_category,
                'retailers_time' => $retailers_time,
                'category' => $category,
            ]);
    }

    public function indexGps($community, $descriptions, $retailers, $retailers_category, $retailers_time, $leaflets, $products)
    {
        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Sieci handlowe', 'url' => route('main.retailers')],
            ['label' => $community, 'url' => ''],
        ];

        return view('main.retailers.index_gps', data:
            [
                'slug' => 'Poznań',
                'h1Title'=> 'Sieci <strong>handlowe</strong>',
                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,
                'leaflets' => $leaflets,
                'retailers' => $retailers,
                'retailers_category' => $retailers_category,
                'retailers_time' => $retailers_time,
                'products' => $products,
            ]);
    }

    public function subdomainShowAddress($subdomain, $community, $address, $leaflets)
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


        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => $shop->name, 'url' => route('subdomain.index', ['subdomain' => $subdomain])],
            ['label' => $shop->name.' '.$place->name, 'url' => route('subdomain.index_gps', ['subdomain' => $subdomain, 'community' => $community])],
            ['label' => 'os. Przytorze 36', 'url' => ''],
        ];

        // Filtrowanie według nazwy
        $leaflets = array_filter($leaflets, function ($item) use ($subdomain) {
            return str_starts_with(strtolower($item['name']), strtolower($subdomain)) !== false;
        });

        $leaflets_time = SortOptionsService::getSortOptions();
        $leaflets_category = SortOptionsService::getCategoryOptions();
        $vouchers = Voucher::with('voucherStore')->get();

        return view('subdomain.shop',
            [
                'subdomain' => $subdomain,

                'place' => $place,

                'h1_title'=> $shop->name.' '.$place->name.', os. Przytorze 36',
                'page_title'=> 'Gazetki promocyjne, nowe i nadchodzące promocje | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',


                'breadcrumbs' => $breadcrumbs,
                'leaflets_category' => $leaflets_category,
                'leaflets_time' => $leaflets_time,
                'leaflets' => $leaflets,
                'vouchers' => $vouchers,
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
