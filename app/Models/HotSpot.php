<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotSpot extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relacja z Page
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    // Relacja z Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function leafletProduct()
    {
        return $this->belongsTo(LeafletProduct::class);
    }
}

