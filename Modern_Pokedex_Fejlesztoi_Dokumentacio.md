# **Fejlesztői Dokumentáció**
# **Modern Pokédex**

---

## **1. Bevezetés**

A **Modern Pokédex** egy Vue.js + PHP (Laravel alapú) webalkalmazás, amely Pokémonok adatait jeleníti meg kereshető, szűrhető formában.  
A projekt célja, hogy modern, API-alapú megoldással biztosítson hozzáférést a Pokémonokhoz, típusokhoz és statisztikákhoz.

A projekt alapját a [**fullstack2025**](https://github.com/rcsnjszg/fullstack2025) repository adta, amelyre a rendszer felépítése és a fejlesztői struktúra épült.

---

## **2. Fájlstruktúra**

### **Frontend (Vue.js)**
```
src/
 ├── components/
 │    ├── PokedexApp.vue
 │    ├── PokemonCard.vue
 │    └── PokemonDetailModal.vue
 ├── services/
 │    └── pokemonApi.js
```

### **Backend (PHP / Laravel)**
```
app/
 ├── Http/Controllers/
 │    └── PokemonController.php
 ├── Models/
 │    └── Pokemon.php

database/
 ├── migrations/
 │    └── 2025_11_09_122352_create_pokemons_table.php
 ├── seeders/
 │    └── PokemonSeeder.php

config/
 └── cors.php
```

---

## **3. Frontend komponensek**

### **3.1 `PokedexApp.vue`**
A főkomponens, amely a teljes alkalmazás logikáját irányítja.  
Feladatai:
- A Pokémonok adatainak lekérése az API-ból.  
- A keresés és szűrés kezelése (név, típus alapján).  
- Az adatok átadása a gyerekkomponenseknek (`PokemonCard`, `PokemonDetailModal`).  

**Főbb funkciók:**
- `mounted()` életciklusban API-lekérés.  
- Keresőmező input eseményének figyelése.  
- Típusválasztó frissítésekor a megjelenített lista szűrése.  
- `selectedPokemon` állapot kezelése a részletes modál megnyitásához.

---

### **3.2 `PokemonCard.vue`**
Egy önálló komponens, amely egy Pokémon kártyáját jeleníti meg a listában.

**Tartalmazott elemek:**
- Pokémon neve  
- Típus(ok)  
- Kép (sprite vagy illusztráció)

**Események:**
- Kattintásra eseményt küld a szülő komponensnek, amely megnyitja a részletes modált.

---

### **3.3 `PokemonDetailModal.vue`**
A modál ablak, amely a kiválasztott Pokémon részletes adatait mutatja be.

**Tartalmazott adatok:**
- Név, Pokédex szám  
- Képek (normál + shiny)  
- Képességek  
- Statisztikák  
- Evolúciós folyamat (ha elérhető)

**Funkciók:**
- Props segítségével kapja meg az adatokat a `PokedexApp.vue`-tól.  
- `@close` eseménnyel zárható.

---

### **3.4 `pokemonApi.js`**
Az API-kommunikációért felelős modul.

**Metódusai:**
- `getAllPokemons()` – Lekéri az összes Pokémon adatát.  
- `getPokemonByName(name)` – Lekéri az adott nevű Pokémon adatait.  
- `getPokemonsByType(type)` – Szűrés típus alapján.  

A hívások Axios segítségével történnek, a backend `PokemonController` végpontjait használva.

---

## **4. Backend**

### **4.1 `Pokemon.php` (Model)**
Laravel modell, amely a `pokemons` adatbázistáblát képviseli.

**Attribútumok:**
- `name` – Pokémon neve  
- `type` – típus (egy vagy több)  
- `abilities` – képességek listája  
- `image_normal` és `image_shiny` – képek URL-jei  
- `stats` – base statok JSON formátumban  

A modell támogatja a tömeges feltöltést (`fillable` tömb).

---

### **4.2 `PokemonController.php`**
A backend fő vezérlője, amely az API-kéréseket kezeli.

**Fő metódusai:**
- `index()` – Visszaadja az összes Pokémon adatát.  
- `show($id)` – Egy adott Pokémon részletes adatait küldi vissza.  
- `filterByType($type)` – Típus szerinti szűrés.  
- `searchByName($name)` – Keresés név alapján.  

A válaszok JSON formátumban érkeznek a frontend felé.

---

### **4.3 `PokemonSeeder.php`**
A seeder alap Pokémon-adatokkal tölti fel az adatbázist.

**Példa rekordok:**
- Charmander (#004) – Fire típus  
- Squirtle (#007) – Water típus  
- Bulbasaur (#001) – Grass/Poison típus  

A képek külső URL-ről töltődnek, a projekt repository-ján kívül tárolva.

---

### **4.4 `2025_11_09_122352_create_pokemons_table.php`**
Az adatbázis-migráció létrehozza a `pokemons` táblát az alábbi oszlopokkal:

| Oszlop | Típus | Leírás |
|:--|:--|:--|
| id | integer | Elsődleges kulcs |
| name | string | Pokémon neve |
| type | string | Pokémon típusa(i) |
| abilities | text | JSON formátumban tárolt képességek |
| stats | text | Base statok JSON formátumban |
| image_normal | string | Alap kép URL |
| image_shiny | string | Shiny kép URL |

---

### **4.5 `cors.php`**
Engedélyezi a frontend és a backend közötti kommunikációt eltérő domain esetén.

**Beállítások:**
- Engedélyezett origin: `*`  
- Engedélyezett metódusok: `GET, POST, OPTIONS`  
- Engedélyezett header: `Content-Type, Authorization`

---

## **5. Adatáramlás és működés**

1. A `PokedexApp.vue` betöltéskor meghívja az API-t (`pokemonApi.js` → `PokemonController@index`).
2. A backend JSON adatot küld vissza (Pokémonok listája).
3. Az adatok a Vue komponensek között átadásra kerülnek (`PokemonCard` → `PokemonDetailModal`).
4. A felhasználó kereshet vagy szűrhet, ezek új API-hívásokat indítanak.
5. A részletes adatok a modálban jelennek meg.

---

## **6. Fejlesztési és futtatási útmutató**

### **Frontend**
1. Telepítés:
   ```
   npm install
   ```
2. Fejlesztői szerver indítása:
   ```
   npm run dev
   ```
3. A webapp elérhető a `http://localhost:5173` címen.

### **Backend**
1. Függőségek telepítése:
   ```
   composer install
   ```
2. Adatbázis létrehozása, majd migráció és seeder futtatása:
   ```
   php artisan migrate --seed
   ```
3. Backend indítása:
   ```
   php artisan serve
   ```
4. API elérhetősége: `http://localhost:8000/api/pokemons`

---

## **7. Összefoglalás**

A **Modern Pokédex** egy Vue és PHP alapú, REST API-val kommunikáló webalkalmazás, amely valós időben képes Pokémon-adatokat megjeleníteni.  
A kód jól strukturált, komponens alapú, és a Laravel backend biztonságosan, gyorsan szolgálja ki a kliens kéréseit.

---
