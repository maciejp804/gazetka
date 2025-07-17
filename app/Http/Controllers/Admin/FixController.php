<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HotSpot;
use Illuminate\Http\Request;

class FixController extends Controller
{
    public function fixHotSpots()
    {
        $hotSpots = HotSpot::where('image_width', '!=', null)->get();
       foreach ($hotSpots as $hotSpot) {
           $x = $hotSpot->x;
           $y = $hotSpot->y;
           $width = $hotSpot->width;
           $height = $hotSpot->height;
           $image_width = $hotSpot->image_width;
           $image_height = $hotSpot->image_height;
           $hotSpot->update([
               'x' => round($x/$image_width*100),
               'y' => round($y/$image_height*100),
               'width' => round($width/$image_width*100),
               'height' => round($height/$image_height*100)
           ]);

       }
    }
}
