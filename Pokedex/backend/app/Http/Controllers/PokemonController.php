<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PokemonController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Pokemon::query();

        if ($request->has('name')) {
            $query->searchByName($request->name);
        }

        if ($request->has('type')) {
            $query->byType($request->type);
        }

        if ($request->has('type1')) {
            $type2 = $request->input('type2');
            $query->byExactTypes($request->type1, $type2);
        }

        if ($request->has('pokedex_number')) {
            $query->byPokedexNumber($request->pokedex_number);
        }

        $pokemons = $query->orderBy('pokedex_number', 'asc')->get();

        return response()->json([
            'success' => true,
            'data' => $pokemons,
            'count' => $pokemons->count()
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $pokemon = Pokemon::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $pokemon
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'pokedex_number' => 'required|integer|unique:pokemons',
            'type1' => 'required|string|max:50',
            'type2' => 'nullable|string|max:50',
            'abilities' => 'required|array',
            'image_url' => 'required|url',
            'shiny_image_url' => 'required|url',
            'base_stats' => 'required|array',
            'evolution_chain' => 'nullable|array',
        ]);

        $pokemon = Pokemon::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pokémon successfully created',
            'data' => $pokemon
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $pokemon = Pokemon::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'pokedex_number' => 'sometimes|integer|unique:pokemons,pokedex_number,' . $id,
            'type1' => 'sometimes|string|max:50',
            'type2' => 'nullable|string|max:50',
            'abilities' => 'sometimes|array',
            'image_url' => 'sometimes|url',
            'shiny_image_url' => 'sometimes|url',
            'base_stats' => 'sometimes|array',
            'evolution_chain' => 'nullable|array',
        ]);

        $pokemon->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pokémon successfully updated',
            'data' => $pokemon
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $pokemon = Pokemon::findOrFail($id);
        $pokemon->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pokémon successfully deleted'
        ]);
    }

    public function getTypes(): JsonResponse
    {
        $types1 = Pokemon::distinct()->pluck('type1');
        $types2 = Pokemon::distinct()->whereNotNull('type2')->pluck('type2');
        
        $allTypes = $types1->merge($types2)->unique()->sort()->values();

        return response()->json([
            'success' => true,
            'data' => $allTypes
        ]);
    }
}