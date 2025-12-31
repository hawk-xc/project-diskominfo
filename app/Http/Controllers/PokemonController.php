<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use Illuminate\Http\Request;

class PokemonController extends Controller
{
    public function index()
    {
        $pokemons = Pokemon::all();
        return view('welcome', compact('pokemons'));
    }

    public function show(string $id)
    {
        $pokemon = Pokemon::findOrFail($id);

        return view('show', compact('pokemon'));
    }
}
