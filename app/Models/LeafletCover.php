<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeafletCover extends Model
{
    use HasFactory;

    protected $fillable = [
        'leaflet_id',
        'original_name',
        'path',
        'webp_path',
        'avif_path',
        'width',
        'height',
        'alt_text'
    ];

    public function leaflet(): BelongsTo
    {
        return $this->belongsTo(Leaflet::class);
    }

    public function getUrl($format = 'original'): string
    {
        switch ($format) {
            case 'webp':
                return $this->webp_path ? asset('storage/' . $this->webp_path) : asset('storage/' . $this->path);
            case 'avif':
                return $this->avif_path ? asset('storage/' . $this->avif_path) : asset('storage/' . $this->path);
            default:
                return asset('storage/' . $this->path);
        }
    }
}
