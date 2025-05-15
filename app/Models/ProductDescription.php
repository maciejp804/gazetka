<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDescription extends Model
{

   protected $guarded = [];

    protected $casts = [
        'content' => 'array',
        'body' => 'array',
        'faq' => 'array',
        'parameters' => 'array'
    ];

    public function products()
    {
        return $this->belongsTo(Product::class);
    }

    public function shops()
    {
        return $this->belongsTo(Shop::class);
    }

    public static function getByProductAndShop($product_id, $shop_id = null)
    {

        return self::where('product_id',  $product_id)
            ->where('shop_id', $shop_id)
            ->first();
    }


    public static function getDefaultProduct($routeName, $product = null, $shop = null, $category = 'default')
    {
        // Zamiana kropek na podkreślenia (zgodnie z config/descriptions.php)
        $routeKey = str_replace('.', '_', $routeName);
        // Pobranie domyślnych wartości dla danej trasy lub użycie "default"
        $defaults = config("descriptionsProducts.defaults.{$routeKey}.{$category}", config("descriptionsProducts.defaults.{$routeKey}.default"));

        if ($shop != null) {
            $shop_name = $shop->name;
        } else {
            $shop_name = $shop;
        }




        return new self([
            'meta_title' => str_replace(['{product}', '{shop}', '{data}'], [mb_ucfirst($product->name), $shop_name, monthReplace(date('d-m-Y'), 'full', 'm-Y')], $defaults['meta_title']),
            'meta_description' => str_replace(['{product}', '{shop}'], [$product->name, $shop_name], $defaults['meta_description']),
            'meta_keywords' => str_replace(['{product}', '{shop}'], [$product->name, $shop_name], $defaults['meta_keywords']),
            'h1_title' => str_replace(['{product}', '{shop}'], [mb_ucfirst($product->name), $shop_name], $defaults['h1_title']),
            'excerpt' => str_replace(['{product}', '{shop}'], [$product->name, $shop_name], $defaults['excerpt']),
        ]);
    }


}
