<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_number',
        'image_path',
        'width',
        'height'
        ];

    public function leaflets()
    {
        return $this->belongsToMany(Leaflet::class, 'leaflet_page')
            ->withPivot('sort_order') // ✅ Pobieranie `sort_order` z pivot table
            ->orderBy('sort_order');  // ✅ Sortowanie stron w kolejności
    }

    public function clicks(): HasMany
    {
        return $this->hasMany(PageClick::class);
    }

}
