<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    use HasFactory;

    protected $table = 'pokemons';

    protected $fillable = [
        'name',
        'pokedex_number',
        'type1',
        'type2',
        'abilities',
        'image_url',
        'shiny_image_url',
        'base_stats',
        'evolution_chain',
    ];

    protected $casts = [
        'abilities' => 'array',
        'base_stats' => 'array',
        'evolution_chain' => 'array',
    ];

    public function scopeSearchByName($query, $name)
    {
        return $query->where('name', 'LIKE', "%{$name}%");
    }

    public function scopeByPokedexNumber($query, $number)
    {
        return $query->where('pokedex_number', $number);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type1', $type)
                    ->orWhere('type2', $type);
    }

    public function scopeByExactTypes($query, $type1, $type2 = null)
    {
        if ($type2) {
            return $query->where(function($q) use ($type1, $type2) {
                $q->where('type1', $type1)->where('type2', $type2)
                  ->orWhere('type1', $type2)->where('type2', $type1);
            });
        }
        return $query->where('type1', $type1)->whereNull('type2');
    }
}
