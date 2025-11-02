<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <header class="bg-red-600 text-white shadow-lg">
      <div class="container mx-auto px-4 py-6">
        <h1 class="text-4xl font-bold text-center">🔴 Pokédex</h1>
        <p class="text-center text-red-100 mt-2">Catch 'em all - New Generation</p>
      </div>
    </header>

    <main class="container mx-auto px-4 py-8">
      <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Search & Filter</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Search by Name
            </label>
            <input 
              v-model="searchName"
              @input="debouncedSearch"
              type="text"
              placeholder="Enter Pokémon name..."
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            >
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Search by Pokédex #
            </label>
            <input 
              v-model.number="searchPokedexNumber"
              @input="debouncedSearch"
              type="number"
              placeholder="Enter number..."
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            >
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Filter by Type
            </label>
            <select 
              v-model="filterType"
              @change="fetchPokemons"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            >
              <option value="">All Types</option>
              <option v-for="type in availableTypes" :key="type" :value="type">
                {{ type }}
              </option>
            </select>
          </div>

          <div class="flex items-end">
            <button 
              @click="resetFilters"
              class="w-full bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors"
            >
              Reset Filters
            </button>
          </div>
        </div>

        <div class="mt-4 pt-4 border-t border-gray-200">
          <h3 class="text-lg font-semibold text-gray-700 mb-3">Advanced Type Filter (Exact Match)</h3>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Type 1</label>
              <select 
                v-model="exactType1"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              >
                <option value="">Select Type 1</option>
                <option v-for="type in availableTypes" :key="type" :value="type">
                  {{ type }}
                </option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Type 2 (Optional)</label>
              <select 
                v-model="exactType2"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              >
                <option value="">None / Any</option>
                <option v-for="type in availableTypes" :key="type" :value="type">
                  {{ type }}
                </option>
              </select>
            </div>
            <div class="flex items-end">
              <button 
                @click="searchByExactTypes"
                :disabled="!exactType1"
                class="w-full bg-indigo-500 hover:bg-indigo-600 disabled:bg-gray-300 text-white font-semibold py-2 px-4 rounded-lg transition-colors"
              >
                Search Exact Types
              </button>
            </div>
          </div>
        </div>
      </div>

      <div v-if="loading" class="text-center py-12">
        <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-red-600"></div>
        <p class="text-gray-600 mt-4">Loading Pokémon...</p>
      </div>

      <div v-else-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
        <p class="font-bold">Error loading Pokémon!</p>
        <p>{{ error }}</p>
      </div>

      <div v-else>
        <div class="mb-4 text-gray-600">
          Found <span class="font-bold text-gray-800">{{ filteredPokemons.length }}</span> Pokémon
        </div>

        <div v-if="filteredPokemons.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
          <PokemonCard 
            v-for="pokemon in filteredPokemons" 
            :key="pokemon.id"
            :pokemon="pokemon"
            @show-details="showPokemonDetails"
          />
        </div>

        <div v-else class="text-center py-12">
          <p class="text-gray-500 text-xl">No Pokémon found matching your criteria.</p>
          <button 
            @click="resetFilters"
            class="mt-4 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg transition-colors"
          >
            Clear Filters
          </button>
        </div>
      </div>
    </main>

    <PokemonDetailModal 
      v-if="selectedPokemon"
      :pokemon="selectedPokemon"
      @close="selectedPokemon = null"
    />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import PokemonCard from './PokemonCard.vue';
import PokemonDetailModal from './PokemonDetailModal.vue';
import { pokemonApi } from '../services/pokemonApi';

const pokemons = ref([]);
const filteredPokemons = ref([]);
const availableTypes = ref([]);
const loading = ref(false);
const error = ref(null);
const selectedPokemon = ref(null);

const searchName = ref('');
const searchPokedexNumber = ref('');
const filterType = ref('');
const exactType1 = ref('');
const exactType2 = ref('');

let debounceTimeout = null;

onMounted(async () => {
  await fetchTypes();
  await fetchPokemons();
});

const fetchTypes = async () => {
  try {
    const response = await pokemonApi.getTypes();
    availableTypes.value = response.data.data;
  } catch (err) {
    console.error('Error fetching types:', err);
  }
};

const fetchPokemons = async () => {
  loading.value = true;
  error.value = null;

  try {
    const params = {};
    if (searchName.value) params.name = searchName.value;
    if (searchPokedexNumber.value) params.pokedex_number = searchPokedexNumber.value;
    if (filterType.value) params.type = filterType.value;

    const response = await pokemonApi.getAll(params);
    pokemons.value = response.data.data;
    filteredPokemons.value = response.data.data;
  } catch (err) {
    error.value = err.message || 'Failed to fetch Pokémon';
    console.error('Error fetching Pokémon:', err);
  } finally {
    loading.value = false;
  }
};

const debouncedSearch = () => {
  clearTimeout(debounceTimeout);
  debounceTimeout = setTimeout(() => {
    fetchPokemons();
  }, 500);
};

const searchByExactTypes = async () => {
  if (!exactType1.value) return;

  loading.value = true;
  error.value = null;

  try {
    const response = await pokemonApi.filterByExactTypes(
      exactType1.value, 
      exactType2.value || null
    );
    pokemons.value = response.data.data;
    filteredPokemons.value = response.data.data;
  } catch (err) {
    error.value = err.message || 'Failed to search by types';
    console.error('Error searching by types:', err);
  } finally {
    loading.value = false;
  }
};

const resetFilters = () => {
  searchName.value = '';
  searchPokedexNumber.value = '';
  filterType.value = '';
  exactType1.value = '';
  exactType2.value = '';
  fetchPokemons();
};

const showPokemonDetails = (pokemon) => {
  selectedPokemon.value = pokemon;
};
</script>