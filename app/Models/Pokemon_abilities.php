<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pokemon_abilities extends Model
{

    protected $table = 'pokemon_abilties';
    protected $fillable = [
        'pokemon_id',
        'ability_id',
    ];

    public function pokemon()
    {
        return $this->belongsTo(Pokemon::class);
    }

    public function ability()
    {
        return $this->belongsTo(Ability::class);
    }
}
