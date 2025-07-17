<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Models\Lemma;

class LemmaController extends Controller
{

    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function corrected()
    {
        $products = Product::whereNull('lemmat')->get();

        foreach ($products as $product) {
           $lemma =  $this->productService->lemmatTextLocal($product->name);

           $product->lemmat = $lemma;
           $product->save();

        }

        return response()->json(['✅ Wszystkie produkty zlematyzowane.']);
    }
}
