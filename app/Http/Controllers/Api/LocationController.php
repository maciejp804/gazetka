<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function findNearestLocation(Request $request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $mainDomain = $request->input('mainDomain'); // Odbierz mainDomain

        if (!$latitude || !$longitude || !$mainDomain) {
            return response()->json(['error' => 'Brak wymaganych danych.'], 400);
        }

        // Znalezienie najbliższej lokalizacji w bazie danych
        $nearestLocation = DB::table('places')
            ->select('*', DB::raw("
            (6371 * acos(
                cos(radians($latitude)) *
                cos(radians(lat)) *
                cos(radians(lng) - radians($longitude)) +
                sin(radians($latitude)) *
                sin(radians(lat))
            )) AS distance
        "))
            ->orderBy('distance', 'asc')
            ->first();

        if (!$nearestLocation) {
            return response()->json(['error' => 'Brak lokalizacji w bazie.'], 404);
        }

        // Zapisz lokalizację w ciasteczku
        $cookie = Cookie::make(
            'user_location',
            json_encode([
                'id' => $nearestLocation->id,
                'name' => $nearestLocation->name,
                'latitude' => $nearestLocation->lat,
                'longitude' => $nearestLocation->lng,
            ], JSON_PRETTY_PRINT),
            60 * 24 * 7, // 7 dni
            '/',         // Ścieżka
            '.' . $mainDomain, // Domena z kropką na początku
            false,       // Czy wymaga HTTPS (ustaw `true` w środowisku produkcyjnym)
            false        // HttpOnly (ustaw `false`, jeśli ciasteczko ma być dostępne w JavaScript)
        );

        return response()->json([
            'location' => $nearestLocation,
        ])->withCookie($cookie);
    }

}
