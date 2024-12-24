<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Voucher;
use App\Services\SortOptionsService;
use App\Services\StaticDescriptions;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index($descriptions, $retailers_category, $leaflets)
    {

        $places = Place::all();
        $places = $places->sortByDesc('population')->take(40);
        $place = $places->first();

        $product_categories = ProductCategory::where('status', 1)->get();
        $products = Product::all();
        $product_sort = SortOptionsService::getSortOptions();
        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Produkty', 'url' => ''],
        ];

        return view('main.products.index', data:
            [
                'place' => $place->name,
                'places' => $places,

                'h1_title'=> '<strong>Produkty</strong> w gazetkach promocyjnych',
                'page_title'=> 'Gazetki promocyjne, nowe i nadchodzące promocje | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',

                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,
                'retailers_category' => $retailers_category,
                'product_sort' => $product_sort,
                'products' => $products,
                'leaflets' => $leaflets,
                'product_categories' => $product_categories,
            ]);
    }

    public function indexCategory($category, $descriptions, $leaflets)
    {
        $product_categories = ProductCategory::where('status', 1)->get();
        $category = $product_categories->where('slug', $category)->first();

        if(!$category){
            abort(404);
        }

        $places = Place::all();
        $places = $places->sortByDesc('population')->take(40);
        $place = $places->first();


        $products = Product::where('product_category_id', $category->id)->get();


        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Produkty', 'url' => route('main.products')],
            ['label' => $category->name, 'url' => '']
        ];

        $product_sort = SortOptionsService::getSortOptions();
        $static_description = StaticDescriptions::getDescriptions();
        return view('main.products.index_category', data:
            [
                'place' => $place->name,
                'places' => $places,

                'h1_title'=> 'Produkty w gazetkach promocyjnych - kategoria <strong>'.strtolower($category->name).'</strong>',
                'page_title'=> 'Gazetki promocyjne, nowe i nadchodzące promocje | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',
                'static_description' => $static_description,
                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,
                'product_sort' => $product_sort,
                'products' => $products,
                'leaflets' => $leaflets,
                'product_categories' => $product_categories,
                'category' => $category,
            ]);
    }

    public function show($slug, $descriptions, $vouchers)
    {
        $products = Product::all();
        $product = $products->where('slug', $slug)->first();

        if(!$product)
        {
            abort(404);
        }

        $places = Place::all();
        $places = $places->sortByDesc('population')->take(40);
        $place = $places->first();

        $products = $products->where('product_category_id', $product->product_category_id);
        $vouchers = Voucher::with('voucherStore')->get();

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Produkty', 'url' => route('main.products')],
            ['label' => $product->name, 'url' => ''],
        ];


        return view('main.products.show', data:
            [
                'place' => $place->name,
                'places' => $places,

                'h1_title'=> $product->name.' - promocje w sklepach',
                'page_title'=> $product->name.' - promocje, aktualna cena w sklepach | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',
                'name' => $slug,
                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,
                'products' => $products,
                'product' => $product,
                'vouchers' => $vouchers,
            ]);
    }

    public function showSubdomain($subdomain, $product, $leaflets)
    {

        $products = Product::all();
        $product = $products->where('slug', $product)->first();

        if(!$product)
        {
            abort(404);
        }


        $places = Place::all();
        $places = $places->sortByDesc('population')->take(40);
        $place = $places->first();

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Dino', 'url' => route('subdomain.index', ['subdomain' => $subdomain])],
            ['label' => $product->name, 'url' => ""]
        ];
        $subdomain = 'lidl';

        // Filtrowanie według nazwy
        $leaflets_filtred = array_filter($leaflets, function ($item) use ($subdomain) {
            return str_starts_with(strtolower($item['name']), strtolower($subdomain)) !== false;
        });

        return view('subdomain.products.show', data:
            [
                'place' => $place->name,
                'places' => $places,

                'h1_title'=> $product->name.' w Dino',
                'page_title'=> 'Gazetki promocyjne, nowe i nadchodzące promocje | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',
                'subdomain' => $subdomain,
                "breadcrumbs" => $breadcrumbs,
                'leaflets' => $leaflets_filtred,
                "leaflets_others" => $leaflets,
            ]);
    }
}
