<template>
  <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
    <div class="relative bg-gradient-to-br from-gray-100 to-gray-200 p-6">
      <div class="flex justify-center items-center h-48">
        <img 
          :src="currentImage" 
          :alt="pokemon.name"
          class="max-h-full object-contain transition-transform duration-300 hover:scale-110"
        >
      </div>
      
      <button 
        @click="toggleShiny"
        class="absolute top-2 right-2 bg-yellow-400 hover:bg-yellow-500 text-white rounded-full p-2 transition-colors"
        title="Toggle Shiny"
      >
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
          <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
        </svg>
      </button>

      <div class="absolute top-2 left-2 bg-gray-800 text-white px-3 py-1 rounded-full text-sm font-bold">
        #{{ String(pokemon.pokedex_number).padStart(3, '0') }}
      </div>
    </div>

    <div class="p-4">
      <h3 class="text-2xl font-bold text-gray-800 mb-2 text-center">
        {{ pokemon.name }}
      </h3>

      <div class="flex justify-center gap-2 mb-4">
        <span 
          :class="getTypeColor(pokemon.type1)"
          class="px-4 py-1 rounded-full text-white text-sm font-semibold"
        >
          {{ pokemon.type1 }}
        </span>
        <span 
          v-if="pokemon.type2"
          :class="getTypeColor(pokemon.type2)"
          class="px-4 py-1 rounded-full text-white text-sm font-semibold"
        >
          {{ pokemon.type2 }}
        </span>
      </div>

      <div class="mb-4">
        <p class="text-sm font-semibold text-gray-600 mb-1">Abilities:</p>
        <div class="flex flex-wrap gap-2">
          <span 
            v-for="ability in pokemon.abilities" 
            :key="ability"
            class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs"
          >
            {{ ability }}
          </span>
        </div>
      </div>

      <div class="mb-4">
        <p class="text-sm font-semibold text-gray-600 mb-2">Base Stats:</p>
        <div class="space-y-1">
          <div v-for="(value, stat) in pokemon.base_stats" :key="stat" class="flex items-center">
            <span class="text-xs text-gray-600 w-24 capitalize">{{ formatStatName(stat) }}:</span>
            <div class="flex-1 bg-gray-200 rounded-full h-4 overflow-hidden">
              <div 
                :style="{ width: `${(value / 255) * 100}%` }"
                :class="getStatColor(value)"
                class="h-full rounded-full transition-all duration-500"
              ></div>
            </div>
            <span class="text-xs font-bold text-gray-700 w-8 text-right ml-2">{{ value }}</span>
          </div>
        </div>
      </div>

      <button 
        @click="$emit('show-details', pokemon)"
        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded-lg transition-colors"
      >
        View Details
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
  pokemon: {
    type: Object,
    required: true
  }
});

defineEmits(['show-details']);

const isShiny = ref(false);

const currentImage = computed(() => {
  return isShiny.value ? props.pokemon.shiny_image_url : props.pokemon.image_url;
});

const toggleShiny = () => {
  isShiny.value = !isShiny.value;
};

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
  if (value < 50) return 'bg-yellow-400';
  if (value < 100) return 'bg-green-500';
  return 'bg-blue-500';
};

const formatStatName = (stat) => {
  return stat.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
};
</script>