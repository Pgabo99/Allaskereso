# AI prompt elemzés

**Projekt:** Álláskereső webalkalmazás  
**Készítette:** Poprádi Gabriella  
**AI eszköz:** Claude Code (Anthropic)

---

## 1. Az AI használatáról

A projekt fejlesztése során Claude Code AI-asszisztenst használtam. Az AI segítséget nyújtott a kód generálásában, hibakeresésben és a dokumentáció elkészítésében.

---

## 2. Fejlesztési fázisok, ahol AI-t használtam

| Fázis | AI szerepe |
|---|---|
| Frontend komponensek | Vue 3 komponensek generálása (szűrők, rendezés, státusz-összesítők) |
| Backend módosítások | Laravel controller-ek bővítése (pl. `applications_count` hozzáadása) |
| Hibajavítás | TypeScript típushibák, Vue reaktivitási problémák megoldása |
| Dokumentáció | Szoftveres dokumentáció és README megírása |
| Követelményelemzés | Annak felmérése, hogy az alkalmazás teljesíti-e a feladat követelményeit |

---

## 3. Jól működő promptok

### 3.1 Konkrét, kontextusos feladatleírás
**Prompt:**
> „Jelentkezések megoszlása státusz szerint, lehessen rendezni az álláshirdetéseket legújabb, vagy aszerint, hogy hányan jelentkeztek"

**Miért működött jól:**
- Egyértelmű, konkrét feladatot fogalmazott meg
- Két különálló funkciót kért egyszerre, amelyek logikailag összetartoznak
- Az AI felolvasta az érintett fájlokat, megértette a kontextust, és egyszerre módosította a backendet és a frontendet

---

### 3.2 Iteratív finomítás
**Prompt:**
> „Ha rákattintanak a Folyamatban, Elfogadva, vagy az Elutasítva gombra, akkor szűrje le a listát, és ha újra kattintanak, törölje a szűrőt"

**Miért működött jól:**
- Az előző eredményre épített (az összesítők már meg voltak)
- Pontosan leírta az elvárt viselkedést (toggle logika)
- Az AI azonnal értette, hogy az előző kártyákat kell interaktívvá tenni

---

### 3.3 Ugyanazon funkció más oldalra való alkalmazása
**Prompt:**
> „Csináld meg ugyanezt a szűrőt a job-offer/{id} oldalon is"

**Miért működött jól:**
- Egyértelmű referencia az előző implementációra
- Az AI felolvasta a célfájlt, azonosította a releváns szekciót, és következetesen alkalmazta a mintát

---

## 4. Kevésbé jól működő promptok

### 4.1 Túl általános kérdés konkrét elvárás nélkül
**Prompt:**
> „Milyen összesítést tudnék végezni?"

**Miért volt kevésbé hatékony:**
- Az AI felsorolt több lehetőséget, de nem implementált semmit
- Egy döntési lépést igényelt a fejlesztőtől, mielőtt a tényleges munka elkezdődhetett
- **Tanulság:** Jobb lett volna egyből a konkrét összesítést megnevezni

---

### 4.2 Elvont követelményellenőrzés
**Prompt:**
> „Teljesít minden követelményt?" (követelménylistával)

**Miért volt részben korlátozott:**
- Az AI nem tudta ellenőrizni a vizuális E-K diagramot (az nem kódban van)
- A `.env` fájl tartalmát sem olvasta el automatikusan, ezért a MongoDB-használatot feltételezni kellett
- **Tanulság:** A nem kódalapú artefaktumokra vonatkozó kérdések manuális ellenőrzést igényelnek

---

## 5. Összefoglalás

**Az AI leghasznosabb volt:**
- Boilerplate kód gyors generálásában (Vue komponens logika, computed property-k)
- Egyszerre több fájl konzisztens módosításában (backend + frontend párhuzamosan)
- Dokumentáció strukturált megírásában

**Az AI kevésbé volt hasznos:**
- Vizuális artefaktumok (E-K diagram) létrehozásában
- Rendszer-szintű döntések meghozatalában (ezeket a fejlesztőnek kell megtenni)
