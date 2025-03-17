<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class Description extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_name', 'place_id', 'type', 'content', 'faq',
        'meta_title', 'meta_description', 'meta_keywords', 'h1_title'
    ];

    protected $casts = [
        'content' => 'array',
        'faq' => 'array',
    ];

    public static function getByRouteAndPlace($route, $place = null)
    {
        if ($place != null) {
            $placeId = $place->id;
        } else {
            $placeId = null;
        }

        return self::where('route_name',  $route)
            ->where('place_id',$placeId)
            ->first();
    }

    public static function getDefault($routeName, $place = null)
    {
        // Zamiana kropek na podkreślenia (zgodnie z config/descriptions.php)
        $routeKey = str_replace('.', '_', $routeName);
        // Pobranie domyślnych wartości dla danej trasy lub użycie "default"
        $defaults = config("descriptions.defaults.{$routeKey}", config('descriptions.defaults.default'));

        return new self([
            'meta_title' => str_replace('{city}', $place->name_locative, $defaults['meta_title']),
            'meta_description' => str_replace('{city}', $place->name_locative, $defaults['meta_description']),
            'meta_keywords' => str_replace('{city}', $place->name, $defaults['meta_keywords']),
            'h1_title' => str_replace('{city}', $place->name_locative, $defaults['h1_title'])
        ]);
    }


}
