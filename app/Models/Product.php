<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;


    protected $guarded = [];

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

    public function globalDescription()
    {
        return $this->hasOne(ProductDescription::class)->whereNull('shop_id');
    }

    public function shopDescriptions()
    {
        return $this->hasMany(ProductDescription::class)->whereNotNull('shop_id');
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

    public function shops()
    {
        return $this->hasManyThrough(
            Shop::class,
            ProductDescription::class,
            'product_id',    // Foreign key on ProductDescription
            'id',            // Local key on Shop
            'id',            // Local key on Product
            'shop_id'        // Foreign key on ProductDescription
        )->distinct(); // unikaj duplikatów jeśli są
    }



}
