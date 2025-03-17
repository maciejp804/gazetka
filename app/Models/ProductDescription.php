<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'shop_id', 'content', 'faq',
        'meta_title', 'meta_description', 'meta_keywords', 'h1_title'
    ];

    protected $casts = [
        'content' => 'array',
        'body' => 'array',
        'faq' => 'array',
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
