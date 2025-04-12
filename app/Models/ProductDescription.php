<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDescription extends Model
{
    use HasFactory;

   protected $guarded = [];

    protected $casts = [
        'content' => 'array',
        'body' => 'array',
        'faq' => 'array',
        'parameters' => 'array'
    ];

    public function products()
    {
        return $this->belongsTo(Product::class);
    }

    public function shops()
    {
        return $this->belongsTo(Shop::class);
    }
}
