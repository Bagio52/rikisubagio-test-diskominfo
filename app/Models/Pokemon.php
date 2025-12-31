<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{

    protected $table = 'pokemons';

    protected $fillable = [
        'pokemon_id',
        'name',
        'best_experience',
        'weight',
        'stat',
        'image_path',
    ];

    public function abilities()
    {
        return $this->hasMany(Ability::class);
    }
}
