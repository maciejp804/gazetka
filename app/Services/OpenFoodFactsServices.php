<?php

namespace App\Services;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class OpenFoodFactsServices
{

    protected TextServices $textServices;

    public function __construct(TextServices $textServices)
    {
        $this->textServices = $textServices;
    }
    public function connect($product)
    {

        $product = Product::with('brands')->where('slug', $product)->first();

        $products = Http::get('https://pl.openfoodfacts.org/cgi/search.pl', [
            'search_terms' => $product->name,
            'search_simple' => 1,
            'action' => 'process',
            'json' => 1,
            'page_size' => 100,

        ])->json()['products'] ?? [];

        $brands = collect($products)
            ->pluck('brands')
            ->flatMap(fn($b) => explode(',', $b))
            ->map(fn($b) => trim($b))
            ->unique()
            ->values();

        foreach ($brands as $brandName) {

            $brandName = trim($brandName);
            if ($brandName === '') continue;

            $aliases = $this->textServices->generateAliases($brandName);
            $slug = $this->textServices->slugify($brandName);

            if (Brand::where('slug', $slug)->exists()) {
                $slug .= '-' . Str::random(4);
            }

            $brand = Brand::updateOrCreate(
                ['name' => $brandName],
                [   'aliases' => json_encode($aliases),
                    'slug' => $slug
                ]
            );

            if (!$product->brands->contains($brand->id)) {
                $product->brands()->syncWithoutDetaching($brand->id);
            }

        }

    }
}
