<?php

namespace App\Services;

use App\Models\HotSpot;

class HotSpotService
{
    public function addHotSpot($page_id, $product_id, $valid_from, $valid_to,
                                $x = 5, $y = 5, $width = 5, $height = 5, $promo_price = 0, $price = 0, $brand = null,
                                $status = 'hidden', $priority = 'low')
    {
        // Tworzenie rekordu w tabeli HotSpot
        return HotSpot::create([
            'page_id' => $page_id,
            'product_id' => $product_id,
            'status' => $status,
            'priority' => $priority,
            'valid_from' => $valid_from,
            'valid_to' => $valid_to,
            'x' => $x,
            'y' => $y,
            'width' => $width,
            'height' => $height,
            'price' => $price,
            'promo_price' => $promo_price,
            'brand' => $brand,
        ]);

    }
}
