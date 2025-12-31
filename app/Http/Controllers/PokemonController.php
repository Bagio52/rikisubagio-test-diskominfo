<?php

namespace App\Http\Controllers;

use App\Models\Ability;
use App\Models\Pokemon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PokemonController extends Controller
{
    public function fetch()
    {
        for ($id = 1; $id <= 200; $id++) {

            $response = Http::get("https://pokeapi.co/api/v2/pokemon/{$id}");

            if (!$response->successful()) {
                continue;
            }

            $data = $response->json();

            // Filter Weight
            $weight = $data['weight'];
            if ($weight > 100) {
                continue;
            }

            // Simpan Gambar
            $imagePath = null;

            if ($data['sprites']['front_default']) {
                $image = Http::get($data['sprites']['front_default'])->body();
                $fileName = "pokemon_{$data['id']}.png";

                Storage::disk('public')->put("pokemon/$fileName", $image);
                $imagePath = "storage/pokemon/$fileName";
            }

            // Simpan Data Pokemon
            $pokemon = Pokemon::updateOrCreate(
                ['pokemon_id' => $data['id']],
                [
                    'name'            => $data['name'],
                    'best_experience' => $data['base_experience'],
                    'weight'          => $data['weight'],
                    'stat'            => $data['stats'][0]['base_stat'],
                    'image_path'      => $imagePath
                ]
            );

            //SIMPAN ABILITIES
            foreach ($data['abilities'] as $ability) {
                if ($ability['is_hidden'] === false) {
                    Ability::create([
                        'pokemon_id' => $pokemon->id,
                        'name'       => $ability['ability']['name']
                    ]);
                }
            }

            // Simpan Relasi Pokemon_abilities
            foreach ($data['abilities'] as $ability) {
                $abilityRecord = Ability::where('pokemon_id', $pokemon->id)
                    ->where('name', $ability['ability']['name'])
                    ->first();

                if ($abilityRecord) {
                    \App\Models\Pokemon_abilities::updateOrCreate(
                        [
                            'pokemon_id' => $pokemon->id,
                            'ability_id' => $abilityRecord->id
                        ]
                    );
                }
            }
        }

        return response()->json([
            'message' => 'Data Pokemon berhasil diambil dan disimpan.'
        ]);
    }

    public function index(Request$request)
    {
        $query = Pokemon::with('abilities');

        // Filter berdasarkan weight
        if ($request->weight_filter) {
            if ($request->weight_filter === 'light') {
                $query->whereBetween('weight', [0, 200]);
            } elseif ($request->weight_filter === 'medium') {
                $query->whereBetween('weight', [201, 300]);
            } elseif ($request->weight_filter === 'heavy') {
                $query->where('weight', '>', 300);
            }
        }

        // SORTING BERAT TERBERAT → TERINGAN
        $pokemons = $query->orderBy('weight', 'asc')->get();

        return view('pokemons.index', compact('pokemons'));
    }
}
