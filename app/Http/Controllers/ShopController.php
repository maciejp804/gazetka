<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Http\Controllers\Controller;
use App\Models\ShopCategory;
use App\Models\Voucher;
use App\Services\SortOptionsService;
use App\Services\StaticDescriptions;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($descriptions, $leaflets)
    {

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
                'h1_title'=> 'Sieci <strong>handlowe</strong>',
                'page_title'=> 'Gazetki promocyjne, nowe i nadchodzące promocje | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',
                'static_description' => $static_description,
                'slug' => 'Poznań',
                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,
                'leaflets' => $leaflets,
                'retailers' => $retailers,
                'retailers_category' => $retailers_category,
                'retailers_time' => $retailers_time,

            ]);
    }

    public function indexCategory($category, $descriptions, $retailers, $leaflets)
    {

        $retailers_category = ShopCategory::where('status', 1)->get();
        $category = $retailers_category->where('slug', $category)->first();
        $static_description = StaticDescriptions::getDescriptions();
        if ($category === null)
        {
            abort(404);
        }
        $retailers_time = SortOptionsService::getSortOptions();

        $retailers = Shop::where('status', 1)->where('shop_category_id', $category->id)->get();

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Sieci handlowe', 'url' => route('main.retailers')],
            ['label' => $category->name, 'url' => ''],
        ];



        return view('main.retailers.index_category', data:
            [
                'h1_title'=> 'Sieci handlowe - markety i sklepy spożywcze',
                'page_title'=> 'Gazetki promocyjne, nowe i nadchodzące promocje | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',
                'static_description' => $static_description,
                'slug' => 'Poznań',
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

    public function subdomainShowAddress($subdomain, $leaflets, $leaflets_time, $leaflets_category, $vouchers)
    {

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Dino', 'url' => route('subdomain.index', ['subdomain' => $subdomain])],
            ['label' => 'Dino Wieleń', 'url' => route('subdomain.index_gps', ['subdomain' => $subdomain, 'community' => 'wielen'])],
            ['label' => 'os. Przytorze 36', 'url' => ''],
        ];

        // Filtrowanie według nazwy
        $leaflets = array_filter($leaflets, function ($item) use ($subdomain) {
            return str_starts_with(strtolower($item['name']), strtolower($subdomain)) !== false;
        });

        $leaflets_time = SortOptionsService::getSortOptions();
        $leaflets_category = SortOptionsService::getCategoryOptions();
        $vouchers = Voucher::with('voucherStore')->get();
        return view('subdomain.shop', data:
            [
                'h1_title'=> 'Dino Wieleń, os. Przytorze 36',
                'page_title'=> 'Gazetki promocyjne, nowe i nadchodzące promocje | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',
                'slug' => 'Wieleń',
                'subdomain' => $subdomain,
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
