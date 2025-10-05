import axios from "axios";

const API_URL = "https://pokeapi.co/api/v2/";

export async function getPokemonByName(name) {
  try {
    const res = await axios.get(`${API_URL}pokemon/${name.toLowerCase()}`);
    return res.data;
  } catch {
    return null;
  }
}

export async function getPokemonSpecies(id) {
  const res = await axios.get(`${API_URL}pokemon-species/${id}/`);
  return res.data;
}

export async function getEvolutionChain(url) {
  const res = await axios.get(url);
  return res.data;
}