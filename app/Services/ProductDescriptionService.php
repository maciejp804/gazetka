<?php

namespace App\Services;

use App\Jobs\GenerateDescriptionJob;
use App\Jobs\GenerateProductShopDescriptionJob;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductDescriptionService
{
    public function writesonicGeneral()
    {
        $products = Product::whereHas('hotSpots') // produkty z hotspotami
        ->where(function ($query) {
            $query->doesntHave('descriptions')
                ->orWhereHas('descriptions', function ($q) {
                    $q->whereNull('excerpt');
                });
        })
            ->limit(30)
            ->get()
            ->unique('id')
            ->values();

        $dispatchedCount = 0;
        // Dla każdego produktu dispatchujemy Job do kolejki
        foreach ($products as $product) {
            GenerateDescriptionJob::dispatch($product)->delay(now()->addSeconds(2));
            $dispatchedCount++;
        }

        // ✅ Logowanie informacji do laravel.log
        Log::info('Zlecono generowanie opisów dla ' . $products->count() . ' produktów przez Writesonic.');


        return $dispatchedCount;
    }

    public function writesonicShop()
    {

        $items = DB::table('hot_spots as hs')
            ->join('leaflet_page as lp', 'hs.page_id', '=', 'lp.page_id')
            ->join('leaflets as l', 'lp.leaflet_id', '=', 'l.id')
            ->leftJoin('product_descriptions as pd', function ($join) {
                $join->on('pd.product_id', '=', 'hs.product_id')
                    ->on('pd.shop_id', '=', 'l.shop_id');
            })
            ->whereNull('pd.excerpt')
            ->select('hs.product_id', 'l.shop_id')
            ->distinct()
            ->limit(30)
            ->get();


        $dispatchedCount = 0;
        foreach ($items as $item) {
            $product = Product::where('id', $item->product_id)->first();
            $shop = Shop::where('id', $item->shop_id)->first();

            GenerateProductShopDescriptionJob::dispatch($product, $shop)->delay(now()->addSeconds(2));
            $dispatchedCount++;
        }

        // ✅ Logowanie informacji do laravel.log
        Log::info('Zlecono generowanie opisów dla ' . $items->count() . ' produktów przez Writesonic GenerateProductShopDescriptionJob.');


        return $dispatchedCount;
    }
}
