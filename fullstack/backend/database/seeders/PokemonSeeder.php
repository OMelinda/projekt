<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PokemonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pokemons = [
            [
                'name' => 'Bulbasaur',
                'pokedex_number' => 1,
                'type1' => 'Grass',
                'type2' => 'Poison',
                'abilities' => ['Overgrow', 'Chlorophyll'],
                'image_url' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/1.png',
                'shiny_image_url' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/shiny/1.png',
                'base_stats' => [
                    'hp' => 45,
                    'attack' => 49,
                    'defense' => 49,
                    'special_attack' => 65,
                    'special_defense' => 65,
                    'speed' => 45
                ],
                'evolution_chain' => [
                    ['name' => 'Bulbasaur', 'level' => 1],
                    ['name' => 'Ivysaur', 'level' => 16],
                    ['name' => 'Venusaur', 'level' => 32]
                ]
            ],
            [
                'name' => 'Charmander',
                'pokedex_number' => 4,
                'type1' => 'Fire',
                'type2' => null,
                'abilities' => ['Blaze', 'Solar Power'],
                'image_url' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/4.png',
                'shiny_image_url' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/shiny/4.png',
                'base_stats' => [
                    'hp' => 39,
                    'attack' => 52,
                    'defense' => 43,
                    'special_attack' => 60,
                    'special_defense' => 50,
                    'speed' => 65
                ],
                'evolution_chain' => [
                    ['name' => 'Charmander', 'level' => 1],
                    ['name' => 'Charmeleon', 'level' => 16],
                    ['name' => 'Charizard', 'level' => 36]
                ]
            ],
            [
                'name' => 'Squirtle',
                'pokedex_number' => 7,
                'type1' => 'Water',
                'type2' => null,
                'abilities' => ['Torrent', 'Rain Dish'],
                'image_url' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/7.png',
                'shiny_image_url' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/shiny/7.png',
                'base_stats' => [
                    'hp' => 44,
                    'attack' => 48,
                    'defense' => 65,
                    'special_attack' => 50,
                    'special_defense' => 64,
                    'speed' => 43
                ],
                'evolution_chain' => [
                    ['name' => 'Squirtle', 'level' => 1],
                    ['name' => 'Wartortle', 'level' => 16],
                    ['name' => 'Blastoise', 'level' => 36]
                ]
            ],
            [
                'name' => 'Pikachu',
                'pokedex_number' => 25,
                'type1' => 'Electric',
                'type2' => null,
                'abilities' => ['Static', 'Lightning Rod'],
                'image_url' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/25.png',
                'shiny_image_url' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/shiny/25.png',
                'base_stats' => [
                    'hp' => 35,
                    'attack' => 55,
                    'defense' => 40,
                    'special_attack' => 50,
                    'special_defense' => 50,
                    'speed' => 90
                ],
                'evolution_chain' => [
                    ['name' => 'Pichu', 'level' => 1, 'condition' => 'Friendship'],
                    ['name' => 'Pikachu', 'level' => 1],
                    ['name' => 'Raichu', 'level' => 1, 'condition' => 'Thunder Stone']
                ]
            ],
            [
                'name' => 'Charizard',
                'pokedex_number' => 6,
                'type1' => 'Fire',
                'type2' => 'Flying',
                'abilities' => ['Blaze', 'Solar Power'],
                'image_url' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/6.png',
                'shiny_image_url' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/shiny/6.png',
                'base_stats' => [
                    'hp' => 78,
                    'attack' => 84,
                    'defense' => 78,
                    'special_attack' => 109,
                    'special_defense' => 85,
                    'speed' => 100
                ],
                'evolution_chain' => [
                    ['name' => 'Charmander', 'level' => 1],
                    ['name' => 'Charmeleon', 'level' => 16],
                    ['name' => 'Charizard', 'level' => 36]
                ]
            ],
            [
                'name' => 'Dragonite',
                'pokedex_number' => 149,
                'type1' => 'Dragon',
                'type2' => 'Flying',
                'abilities' => ['Inner Focus', 'Multiscale'],
                'image_url' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/149.png',
                'shiny_image_url' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/shiny/149.png',
                'base_stats' => [
                    'hp' => 91,
                    'attack' => 134,
                    'defense' => 95,
                    'special_attack' => 100,
                    'special_defense' => 100,
                    'speed' => 80
                ],
                'evolution_chain' => [
                    ['name' => 'Dratini', 'level' => 1],
                    ['name' => 'Dragonair', 'level' => 30],
                    ['name' => 'Dragonite', 'level' => 55]
                ]
            ]
        ];

        foreach ($pokemons as $pokemon) {
            Pokemon::create($pokemon);
        }

        $this->command->info('Successfully seeded ' . count($pokemons) . ' Pokémon!');
    }
}
