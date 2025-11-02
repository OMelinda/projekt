<template>
  <div 
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
    @click.self="$emit('close')"
  >
    <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
      <div class="sticky top-0 bg-gradient-to-r from-red-500 to-red-600 text-white p-6 rounded-t-xl flex justify-between items-center z-10">
        <h2 class="text-3xl font-bold">
          {{ pokemon.name }} 
          <span class="text-red-100 text-xl ml-2">
            #{{ String(pokemon.pokedex_number).padStart(3, '0') }}
          </span>
        </h2>
        <button 
          @click="$emit('close')"
          class="text-white hover:text-red-200 transition-colors"
        >
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <div class="p-6">
        <div class="grid grid-cols-2 gap-4 mb-6">
          <div class="bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg p-6">
            <p class="text-center text-sm font-semibold text-gray-600 mb-2">Normal</p>
            <img 
              :src="pokemon.image_url" 
              :alt="pokemon.name"
              class="w-full h-48 object-contain"
            >
          </div>
          <div class="bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-lg p-6">
            <p class="text-center text-sm font-semibold text-gray-600 mb-2">Shiny ✨</p>
            <img 
              :src="pokemon.shiny_image_url" 
              :alt="`Shiny ${pokemon.name}`"
              class="w-full h-48 object-contain"
            >
          </div>
        </div>

        <div class="mb-6">
          <h3 class="text-xl font-bold text-gray-800 mb-3">Type</h3>
          <div class="flex gap-3">
            <span 
              :class="getTypeColor(pokemon.type1)"
              class="px-6 py-2 rounded-full text-white text-lg font-semibold"
            >
              {{ pokemon.type1 }}
            </span>
            <span 
              v-if="pokemon.type2"
              :class="getTypeColor(pokemon.type2)"
              class="px-6 py-2 rounded-full text-white text-lg font-semibold"
            >
              {{ pokemon.type2 }}
            </span>
          </div>
        </div>

        <div class="mb-6">
          <h3 class="text-xl font-bold text-gray-800 mb-3">Abilities</h3>
          <div class="flex flex-wrap gap-3">
            <span 
              v-for="ability in pokemon.abilities" 
              :key="ability"
              class="bg-blue-100 text-blue-800 px-4 py-2 rounded-lg text-base font-medium"
            >
              {{ ability }}
            </span>
          </div>
        </div>

        <div class="mb-6">
          <h3 class="text-xl font-bold text-gray-800 mb-3">Base Stats</h3>
          <div class="bg-gray-50 rounded-lg p-4">
            <div class="space-y-3">
              <div v-for="(value, stat) in pokemon.base_stats" :key="stat" class="flex items-center">
                <span class="text-sm font-semibold text-gray-700 w-32 capitalize">
                  {{ formatStatName(stat) }}:
                </span>
                <div class="flex-1 bg-gray-200 rounded-full h-6 overflow-hidden">
                  <div 
                    :style="{ width: `${(value / 255) * 100}%` }"
                    :class="getStatColor(value)"
                    class="h-full rounded-full flex items-center justify-end pr-2 transition-all duration-700"
                  >
                    <span class="text-xs font-bold text-white">{{ value }}</span>
                  </div>
                </div>
                <span class="text-sm font-bold text-gray-800 w-12 text-right ml-3">
                  {{ value }}
                </span>
              </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-300">
              <div class="flex justify-between items-center">
                <span class="text-base font-bold text-gray-800">Total:</span>
                <span class="text-xl font-bold text-indigo-600">{{ totalStats }}</span>
              </div>
            </div>
          </div>
        </div>

        <div v-if="pokemon.evolution_chain && pokemon.evolution_chain.length > 0" class="mb-6">
          <h3 class="text-xl font-bold text-gray-800 mb-4">Evolution Chain</h3>
          <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg p-6">
            <div class="flex flex-wrap items-center justify-center gap-4">
              <template v-for="(evolution, index) in pokemon.evolution_chain" :key="index">
                <div class="text-center">
                  <div class="bg-white rounded-lg p-4 shadow-md hover:shadow-lg transition-shadow">
                    <div class="w-24 h-24 mx-auto mb-2 bg-gray-100 rounded-lg flex items-center justify-center">
                      <img 
                        :src="getEvolutionImage(evolution.name)"
                        :alt="evolution.name"
                        class="max-w-full max-h-full object-contain"
                      >
                    </div>
                    <p class="font-bold text-gray-800">{{ evolution.name }}</p>
                    <p v-if="evolution.level" class="text-sm text-gray-600">
                      Lv. {{ evolution.level }}
                    </p>
                    <p v-if="evolution.condition" class="text-xs text-purple-600 mt-1">
                      {{ evolution.condition }}
                    </p>
                  </div>
                </div>

                <div v-if="index < pokemon.evolution_chain.length - 1" class="flex items-center">
                  <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                  </svg>
                </div>
              </template>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  pokemon: {
    type: Object,
    required: true
  }
});

defineEmits(['close']);

const totalStats = computed(() => {
  return Object.values(props.pokemon.base_stats).reduce((sum, val) => sum + val, 0);
});

const getTypeColor = (type) => {
  const colors = {
    Normal: 'bg-gray-400',
    Fire: 'bg-red-500',
    Water: 'bg-blue-500',
    Electric: 'bg-yellow-400',
    Grass: 'bg-green-500',
    Ice: 'bg-cyan-300',
    Fighting: 'bg-red-700',
    Poison: 'bg-purple-500',
    Ground: 'bg-yellow-600',
    Flying: 'bg-indigo-400',
    Psychic: 'bg-pink-500',
    Bug: 'bg-lime-500',
    Rock: 'bg-yellow-700',
    Ghost: 'bg-purple-700',
    Dragon: 'bg-indigo-700',
    Dark: 'bg-gray-800',
    Steel: 'bg-gray-500',
    Fairy: 'bg-pink-300'
  };
  return colors[type] || 'bg-gray-400';
};

const getStatColor = (value) => {
  if (value < 50) return 'bg-red-400';
  if (value < 80) return 'bg-yellow-400';
  if (value < 110) return 'bg-green-500';
  return 'bg-blue-600';
};

const formatStatName = (stat) => {
  return stat.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
};

const getEvolutionImage = (name) => {
  const pokemonNames = {
    'Charmander': 4,
    'Charmeleon': 5,
    'Charizard': 6,
    'Bulbasaur': 1,
    'Ivysaur': 2,
    'Venusaur': 3,
    'Squirtle': 7,
    'Wartortle': 8,
    'Blastoise': 9,
    'Pichu': 172,
    'Pikachu': 25,
    'Raichu': 26,
    'Dratini': 147,
    'Dragonair': 148,
    'Dragonite': 149
  };
  
  const id = pokemonNames[name] || 0;
  return `https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/${id}.png`;
};
</script>