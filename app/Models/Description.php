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

    public static function getByRouteAndPlace($route, $shop_id = null, $place = null)
    {
        $placeId = $place != null ? $place->id : null;

        return self::where('route_name',  $route)
            ->where('place_id',$placeId)
            ->where('shop_id', $shop_id)
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
//            Aktualna oferta sieci Biedronka Wipsowo to nie jedyny atut naszego serwisu. W dostępnych na naszej stronie gazetkach promocyjnych Biedronki znajdziesz produkty potrzebne w domu każdego dnia. Aktualna gazetka Biedronka Wipsowo jest zawsze pełna świeżych warzyw i owoców - zarówno tych egzotycznych, jak i polskich. Najnowsze ulotki Biedronki w mieście Wipsowo pokazują smaki z różnych zakątków świata. Biedronka chętnie sprowadza artykuły spożywcze inspirowane kuchnią amerykańską, japońską czy śródziemnomorską. Biedronka gazetka Wipsowo przedstawiają także niskie ceny chlebów, pączków czy kajzerek, które zachwycą Cię świeżością. W serwisie GazetkaPromocyjna.com.pl znajdziesz też godziny otwarcia sklepów Biedronka Wipsowo pod konkretnymi adresami w tym mieście.
        ]);
    }


}
