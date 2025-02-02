<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InsertClick extends Model
{
    use HasFactory;

    protected $fillable = [
        'insert_id',
        'product_id',
        'url',
        'x',
        'y',
        'width',
        'height'
    ];

    public function insert(): BelongsTo
    {
        return $this->belongsTo(Insert::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
