<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokemonController;

Route::get('/', [PokemonController::class, 'index'])->name('home');
Route::get('/id', [PokemonController::class, 'show'])->name('show');
