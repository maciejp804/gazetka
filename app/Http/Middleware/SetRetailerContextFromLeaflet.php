<?php

namespace App\Http\Middleware;

use App\Models\Leaflet;
use App\Services\Ocr\RetailerContext;
use Closure;
use Illuminate\Http\Request;

class SetRetailerContextFromLeaflet
{
    public function handle(Request $request, Closure $next)
    {
        $leafletId = $request->route('leaflet')             // jeśli masz {leaflet} w trasie
            ?? $request->route('leaflet_id')                // jeśli masz {leaflet_id}
            ?? $request->input('leaflet_id')                // z formularza
            ?? $request->input('leaflet.id');               // z nested inputu

        if ($leafletId) {
            $leaflet = Leaflet::with('shop')->find($leafletId->id);
            if ($leaflet->shop->slug) {

                RetailerContext::set($leaflet->shop->slug);
            }
        }

        return $next($request);
    }
}
