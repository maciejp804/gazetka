<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Leaflet extends Model
{
    use HasFactory;

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function cover()
    {
        return $this->hasOne(LeafletCover::class);
    }

    public function pages()
    {
        return $this->belongsToMany(Page::class, 'leaflet_page')
            ->withPivot('sort_order')
            ->orderByPivot('sort_order')
            ->withTimestamps();
    }

    public function inserts()
    {
        return $this->belongsToMany(Insert::class, 'leaflet_insert')
            ->withPivot('after')
            ->withTimestamps();
    }

    public function leafletAds()
    {
        return $this->belongsToMany(Ad::class, 'leaflet_ads')
            ->withPivot('after_page', 'priority')
            ->withTimestamps();
    }

    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            LeafletProduct::class,
            'leaflet_id',
            'id',
            'id',
            'product_id');
    }

}
