<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeafletProduct extends Model
{
    use HasFactory;

    protected $table = 'leaflet_products';

    protected $fillable = [
        'leaflet_id',
        'product_id',
        'price',
        'promo_price'
    ];

    public function pageClicks()
    {
        return $this->hasMany(PageClick::class, 'leaflet_product_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function leaflet()
    {
        return $this->belongsTo(Leaflet::class);
    }
}
