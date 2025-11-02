<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokemonController;

Route::prefix('api')->group(function () {
    Route::apiResource('pokemons', PokemonController::class);
    Route::get('types', [PokemonController::class, 'getTypes']);
});

Route::get('/', function () {
    return view('welcome');
});