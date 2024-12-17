<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{
    protected $fillable = ['name', 'applies_to'];
    protected $casts = [
        'applies_to' => 'array',
    ];

    public function isApplicableTo($model)
    {
        $modelName = class_basename($model); // Pobiera nazwę modelu, np. "Coupon" lub "Product"
        return in_array($modelName, $this->applies_to ?? []);
    }

    public function vouchers(): MorphToMany
    {
        return $this->morphedByMany(Voucher::class, 'taggable');
    }
}
