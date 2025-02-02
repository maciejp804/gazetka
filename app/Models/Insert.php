<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insert extends Model
{
    use HasFactory;


    public function leaflets()
    {
        return $this->belongsToMany(Leaflet::class,'leaflet_insert')
            ->withPivot('after')
            ->withTimestamps();
    }

    public function clicks()
    {
        return $this->hasMany(InsertClick::class);
    }

}
