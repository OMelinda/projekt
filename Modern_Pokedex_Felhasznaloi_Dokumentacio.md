# **Felhasználói Dokumentáció**
# **Modern Pokédex**

## **Bevezetés**
A **Modern Pokédex** webalkalmazás lehetővé teszi a felhasználók számára, hogy Pokémonokat böngésszenek, kereshető és szűrhető formában.  
A rendszer a Pokémonok adatait (név, típus, képességek, statisztikák, evolúciók stb.) jeleníti meg, és a felhasználó egy részletes nézetben (modál ablakban) megtekintheti az adott Pokémonhoz tartozó összes információt.

---

## **Funkciók**

### **1. Kezdőlap / Pokédex lista**
A kezdőoldalon az összes Pokémon listája látható rendezett kártyás formában.

**Használata:**
- Görgessen lefelé a Pokémonok között.
- Minden kártya tartalmazza a Pokémon nevét, típusát és képét.
- Kattintson egy kártyára a részletes nézet megnyitásához.

---

### **2. Keresés név alapján**
A keresőmező segítségével gyorsan megkeresheti a kívánt Pokémonokat.

**Használata:**
1. Írja be a keresett Pokémon nevét a felső keresőmezőbe.  
2. A lista automatikusan frissül, és csak a találatok maradnak láthatók.  
3. Törölje a keresőmezőt a teljes lista visszaállításához.

---

### **3. Szűrés típus alapján**
A felhasználó lehetőséget kap, hogy csak bizonyos típusú Pokémonokat jelenítsen meg (pl. *Fire*, *Water*, *Electric* stb.).

**Használata:**
1. Válassza ki a kívánt típust a típusválasztó mezőből.  
2. A lista azonnal frissül, és csak az adott típusú Pokémonok jelennek meg.  
3. Több típus is kiválasztható, ha a projektverzió ezt támogatja.

---

### **4. Pokémon részleteinek megtekintése**
A részletes nézetben (modál ablak) további információkat láthat az adott Pokémonról.

**Tartalmazott adatok:**
- Pokémon neve és Pokédex száma  
- Képek (normál és shiny változat)  
- Típus(ok)  
- Képességek (*Abilities*)  
- Alap statisztikák (*Base stats*)  
- Evolúciós lánc (ha elérhető)

**Használata:**
- Kattintson egy Pokémon kártyájára.
- Egy felugró ablak (modál) megnyílik, amelyben minden részlet megjelenik.
- A modál bezárható az **X** gombbal vagy a háttérre kattintva.

---

### **5. Adatok frissítése**
Az adatok az API-ból (külső vagy saját adatbázisból) töltődnek be.  
Amennyiben az API új Pokémonokat tartalmaz, az oldal automatikusan frissíti a megjelenített listát újratöltéskor.

---

## **Hibakezelés**
- **Nem tölt be az adat:** Ellenőrizze az internetkapcsolatot, vagy próbálja újra később.  
- **Üres lista:** Győződjön meg róla, hogy létezik Pokémon a megadott szűrési feltételekkel.  
- **API hiba:** Ha az adatok nem frissülnek, frissítse az oldalt, vagy vegye fel a kapcsolatot a fejlesztővel.

---

## **Támogatás**
Amennyiben problémát észlel vagy kérdése van, kérjük, vegye fel a kapcsolatot az üzemeltetővel.

**Email:** support@modernpokedex.hu  
**Telefon:** +36 1 234 5678

---
