<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index($descriptions, $retailers_category, $retailers_time, $products, $leaflets)
    {
        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Produkty', 'url' => ''],
        ];

        $product_categories = ProductCategory::where('status', 1)->get();
        return view('main.products.index', data:
            [
                'data' => '',
                'image' => '',
                'slug' => 'Warszawa',
                'h1Title'=> '<strong>Produkty</strong> w gazetkach promocyjnych',
                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,
                'retailers_category' => $retailers_category,
                'retailers_time' => $retailers_time,
                'products' => $products,
                'leaflets' => $leaflets,
                'product_categories' => $product_categories,
            ]);
    }

    public function showCategory($category, $descriptions, $retailers_time, $products, $leaflets)
    {
        $product_categories = ProductCategory::where('status', 1)->get();
        $category = $product_categories->where('slug', $category)->first();


        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Produkty', 'url' => route('main.products')],
            ['label' => $category->name, 'url' => '']
        ];


        return view('main.products.index_category', data:
            [
                'slug' => 'Warszawa',
                'h1Title'=> 'Kategoria <strong>'.strtolower($category->name).'</strong> - produkty w gazetkach promocyjnych',
                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,
                'retailers_time' => $retailers_time,
                'products' => $products,
                'leaflets' => $leaflets,
                'product_categories' => $product_categories,
                'category' => $category->name,
            ]);
    }
}
