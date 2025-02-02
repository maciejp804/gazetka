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
        'image_path'
        ];

    public function leaflets()
    {
        return $this->belongsToMany(Leaflet::class)->withTimestamps();
    }

    public function clicks(): HasMany
    {
        return $this->hasMany(PageClick::class);
    }

}
