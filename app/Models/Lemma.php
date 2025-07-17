<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lemma extends Model
{
    public $timestamps = false;

    protected $table = 'lemmas';

    protected $guarded = [];

    public function unigram()
    {
        return $this->belongsTo(Unigram::class);
    }

}
