<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class Description extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'content' => 'array',
        'faq' => 'array',
    ];

    public static function getByRouteAndPlace($route, $shop_id = null, $place = null)
    {
        $placeId = $place != null ? $place->id : null;

        return self::where('route_name',  $route)
            ->where('place_id',$placeId)
            ->where('shop_id', $shop_id)
            ->first();
    }
    public static function getDefault($routeName, $place = null, $shop = null, $category = 'default')
    {
        // Zamiana kropek na podkreślenia (zgodnie z config/descriptions.php)
        $routeKey = str_replace('.', '_', $routeName);
        // Pobranie domyślnych wartości dla danej trasy lub użycie "default"
        $defaults = config("descriptions.defaults.{$routeKey}.{$category}", config('descriptions.defaults.default'));

        if ($place == null) {
            $name_locative = null;
            $name = null;
        } else {
            $name_locative = $place->name_locative;
            $name  = $place->name;
        }

        return new self([
            'meta_title' => str_replace(['{city}', '{shop}'], [$name_locative, $shop], $defaults['meta_title']),
            'meta_description' => str_replace(['{city}', '{shop}'], [$name_locative, $shop], $defaults['meta_description']),
            'meta_keywords' => str_replace(['{city}', '{shop}'], [$name, $shop], $defaults['meta_keywords']),
            'h1_title' => str_replace(['{city}', '{shop}'], [$name_locative, $shop], $defaults['h1_title']),
            'excerpt' => str_replace(['{city}', '{shop}'], [$name_locative, $shop], $defaults['excerpt']),
        ]);
    }

    public static function getDefaultLeaflets($routeName, $category = 'default')
    {


        $routeKey = str_replace('.', '_', $routeName);
        // Pobranie domyślnych wartości dla danej trasy lub użycie "default"

        $category_slug = $category->slug ?? $category;
        $category_name = $category->name ?? $category;

        $defaults = config("descriptionsLeaflets.defaults.{$routeKey}.{$category_slug}", config("descriptionsLeaflets.defaults.{$routeKey}.default"));

        return new self([
            'meta_title' => str_replace(['{category}'], [$category_name], $defaults['meta_title']),
            'meta_description' => str_replace(['{category}'], [$category_name], $defaults['meta_description']),
            'meta_keywords' => str_replace(['{category}'], [$category_name], $defaults['meta_keywords']),
            'h1_title' => str_replace(['{category}'], [$category_name], $defaults['h1_title']),
            'excerpt' => str_replace(['{category}'], [$category_name], $defaults['excerpt']),
        ]);
    }

    public static function getDefaultShops($routeName, $category = 'default')
    {


        $routeKey = str_replace('.', '_', $routeName);
        // Pobranie domyślnych wartości dla danej trasy lub użycie "default"

        $category_slug = $category->slug ?? $category;
        $category_name = $category->name ?? $category;

        $defaults = config("descriptionsShops.defaults.{$routeKey}.{$category_slug}", config("descriptionsShops.defaults.{$routeKey}.default"));

        return new self([
            'meta_title' => str_replace(['{category}'], [$category_name], $defaults['meta_title']),
            'meta_description' => str_replace(['{category}'], [$category_name], $defaults['meta_description']),
            'meta_keywords' => str_replace(['{category}'], [$category_name], $defaults['meta_keywords']),
            'h1_title' => str_replace(['{category}'], [$category_name], $defaults['h1_title']),
            'excerpt' => str_replace(['{category}'], [$category_name], $defaults['excerpt']),
        ]);
    }

    public static function getDefaultProducts($routeName, $category = 'default', $subcategory = 'default')
    {


        $routeKey = str_replace('.', '_', $routeName);
        // Pobranie domyślnych wartości dla danej trasy lub użycie "default"

        $category_slug = $category->slug ?? $category;
        $category_name = $category->name ?? $category;
        $subcategory_name = $subcategory->name ?? $subcategory;

        $defaults = config("descriptionsProducts.defaults.{$routeKey}.{$category_slug}", config("descriptionsProducts.defaults.{$routeKey}.default"));

        return new self([
            'meta_title' => str_replace(['{category}', '{subcategory}'], [$category_name, $subcategory_name], $defaults['meta_title']),
            'meta_description' => str_replace(['{category}', '{subcategory}'], [strtolower($category_name), strtolower($subcategory_name)], $defaults['meta_description']),
            'meta_keywords' => str_replace(['{category}', '{subcategory}'], [$category_name, $subcategory_name], $defaults['meta_keywords']),
            'h1_title' => str_replace(['{category}', '{subcategory}'], [strtolower($category_name), strtolower($subcategory_name)], $defaults['h1_title']),
            'excerpt' => str_replace(['{category}', '{subcategory}'], [$category_name, $subcategory_name], $defaults['excerpt']),
        ]);
    }

    public static function getDefaultVouchers($routeName, $category = 'default')
    {


        $routeKey = str_replace('.', '_', $routeName);
        // Pobranie domyślnych wartości dla danej trasy lub użycie "default"

        $category_slug = $category->slug ?? $category;
        $category_name = $category->name ?? $category;

        $defaults = config("descriptionsVouchers.defaults.{$routeKey}.{$category_slug}", config("descriptionsVouchers.defaults.{$routeKey}.default"));

        return new self([
            'meta_title' => str_replace(['{category}', '{date}'], [$category_name,
                monthReplace(date('Y-m-d',strtotime('now')), 'full', 'm-Y')], $defaults['meta_title']),
            'meta_description' => str_replace(['{category}', '{date}'], [strtolower($category_name),
                monthReplace(date('Y-m-d',strtotime('now')), 'full', 'm-Y')], $defaults['meta_description']),
            'meta_keywords' => str_replace(['{category}', '{date}'], [$category_name,
                monthReplace(date('Y-m-d',strtotime('now')), 'full', 'm-Y')], $defaults['meta_keywords']),
            'h1_title' => str_replace(['{category}', '{date}'], [strtolower($category_name),
                monthReplace(date('Y-m-d',strtotime('now')), 'full', 'm-Y')], $defaults['h1_title']),
            'excerpt' => str_replace(['{category}', '{date}'], [$category_name,
                monthReplace(date('Y-m-d',strtotime('now')), 'full', 'm-Y')], $defaults['excerpt']),
        ]);
    }

    public static function getDefaultBlogs($routeName, $category = 'default')
    {


        $routeKey = str_replace('.', '_', $routeName);
        // Pobranie domyślnych wartości dla danej trasy lub użycie "default"

        $category_slug = $category->slug ?? $category;
        $category_name = $category->name ?? $category;

        $defaults = config("descriptionsBlogs.defaults.{$routeKey}.{$category_slug}", config("descriptionsBlogs.defaults.{$routeKey}.default"));

        return new self([
            'meta_title' => str_replace(['{category}', '{date}'], [mb_ucfirst($category_name),
                monthReplace(date('Y-m-d',strtotime('now')), 'full', 'm-Y')], $defaults['meta_title']),
            'meta_description' => str_replace(['{category}', '{date}'], [mb_ucfirst($category_name),
                monthReplace(date('Y-m-d',strtotime('now')), 'full', 'm-Y')], $defaults['meta_description']),
            'meta_keywords' => str_replace(['{category}', '{date}'], [$category_name,
                monthReplace(date('Y-m-d',strtotime('now')), 'full', 'm-Y')], $defaults['meta_keywords']),
            'h1_title' => str_replace(['{category}', '{date}'], [mb_ucfirst($category_name),
                monthReplace(date('Y-m-d',strtotime('now')), 'full', 'm-Y')], $defaults['h1_title']),
            'excerpt' => str_replace(['{category}', '{date}'], [$category_name,
                monthReplace(date('Y-m-d',strtotime('now')), 'full', 'm-Y')], $defaults['excerpt']),
        ]);
    }

}
