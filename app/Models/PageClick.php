<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageClick extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'leaflet_product_id');
    }

    public function leafletProduct(): BelongsTo
    {
        return $this->belongsTo(LeafletProduct::class, 'leaflet_product_id');
    }

    public function pivotData()
    {
        return $this->belongsTo(Page::class, 'page_id')->withPivot('sort_order');
    }

}
