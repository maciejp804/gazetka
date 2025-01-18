<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = ['rateable_id', 'rateable_type', 'user_id', 'rating'];

    // Relacja polimorficzna
    public function rateable()
    {
        return $this->morphTo();
    }

    // Relacja z użytkownikiem, który wystawił ocenę
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
