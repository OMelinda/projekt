<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokemonController;

Route::apiResource('pokemons', PokemonController::class);
Route::get('types', [PokemonController::class, 'getTypes']);