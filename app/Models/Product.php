<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    public function leaflets()
    {
        return $this->belongsToMany(Leaflet::class, 'leaflet_products', 'product_id', 'leaflet_id')
            ->withPivot('price', 'promo_price');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function descriptions()
    {
        return $this->hasOne(ProductDescription::class, 'product_id');
    }

    public function ratings()
    {
        return $this->morphMany(Rating::class, 'rateable');
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }


    public function ratingCount()
    {
        return $this->ratings()->count();
    }

    public function leafletProducts()
    {
        return $this->hasMany(LeafletProduct::class);
    }

}
