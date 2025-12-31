<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ability extends Model
{

    protected $fillable = [
        'pokemon_id',
        'name',
    ];

    public function pokemon()
    {
        return $this->belongsTo(Pokemon::class);
    }
}
