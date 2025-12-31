<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/fetch-pokemons', [App\Http\Controllers\PokemonController::class, 'fetch']);
Route::get('/pokemons', [App\Http\Controllers\PokemonController::class, 'index'])->name('pokemons.index');
