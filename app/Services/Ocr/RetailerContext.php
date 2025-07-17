<?php

namespace App\Services\Ocr;

class RetailerContext
{
    protected static ?string $forcedRetailer = null;

    /**
     * Pobiera aktualnie ustawioną nazwę sieci.
     */
    public static function current(): string
    {
        return static::$forcedRetailer
            ?? request('retailer')
            ?? request()->route('retailer')
            ?? request()->segment(3)
            ?? 'biedronka';
    }

    /**
     * Pozwala ręcznie ustawić nazwę sieci (np. z obiektu Leaflet)
     */
    public static function set(string $retailer): void
    {
        static::$forcedRetailer = strtolower($retailer);
    }
}
