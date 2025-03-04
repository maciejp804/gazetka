<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Marker extends Model
{
    use HasFactory;

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class);
    }

    public function hours()
    {
        return $this->hasMany(MarkerOpeningHours::class);
    }
}
