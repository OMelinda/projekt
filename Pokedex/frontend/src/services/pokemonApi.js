import axios from 'axios';

const apiClient = axios.create({
  baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000/api',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  },
  timeout: 10000
});

apiClient.interceptors.request.use(
  (config) => {
    console.log('API Request:', config.method.toUpperCase(), config.url);
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

apiClient.interceptors.response.use(
  (response) => {
    console.log('API Response:', response.status, response.config.url);
    return response;
  },
  (error) => {
    console.error('API Error:', error.response?.status, error.message);
    return Promise.reject(error);
  }
);

export const pokemonApi = {
  getAll(params = {}) {
    return apiClient.get('/pokemons', { params });
  },

  getById(id) {
    return apiClient.get(`/pokemons/${id}`);
  },

  create(data) {
    return apiClient.post('/pokemons', data);
  },

  update(id, data) {
    return apiClient.put(`/pokemons/${id}`, data);
  },

  delete(id) {
    return apiClient.delete(`/pokemons/${id}`);
  },

  getTypes() {
    return apiClient.get('/types');
  },

  searchByName(name) {
    return this.getAll({ name });
  },

  filterByType(type) {
    return this.getAll({ type });
  },

  searchByPokedexNumber(number) {
    return this.getAll({ pokedex_number: number });
  },

  filterByExactTypes(type1, type2 = null) {
    const params = { type1 };
    if (type2) {
      params.type2 = type2;
    }
    return this.getAll(params);
  }
};

export default pokemonApi;