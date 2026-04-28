# AI prompt elemzés

**Projekt:** Álláskereső webalkalmazás  
**Készítette:** Poprádi Gabriella  
**AI eszközök:** ChatGPT (OpenAI), Claude Code (Anthropic)

---

## 1. Az AI használatáról

A projekt fejlesztése során két AI-eszközt használtam: ChatGPT-t a fejlesztés korábbi fázisában, majd Claude Code-ot (PhpStorm plugin-on keresztül) a fejlesztés nagy részében. Az AI segítséget nyújtott a kód generálásában, hibakeresésben és a dokumentáció elkészítésében. A szoftveres dokumentációt szintén az AI segítségével készítettem el, amelyet ezt követően átnéztem és javítottam.

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

## 3. ChatGPT

### 3.1 Beváló promptok

#### Adatgenerálás – munkakör-kategóriák

**Prompt:**
> "List job categories in a hierarchical format (main category → subcategories). Include at least: IT, Engineering, Business, Healthcare. Use Hungarian job title names."

**Miért működött jól:**
- Egyértelmű struktúrát kért (hierarchia), nem csak szabad felsorolást
- Megadta a kötelező főkategóriákat, így a kimenet előre látható volt
- Az eredményt a felületen keresztül fel lehetett venni, majd exportálni és seederbe beolvasni

---

#### Adatgenerálás – cégek

**Prompt:**
> "Generate 15–20 realistic fake Hungarian companies. For each provide: company name (ending in Kft. or Zrt.), contact email, Hungarian address (city + street), tax ID in Hungarian format (XXXXXXXX-X-XX). Output as a numbered list."

**Miért működött jól:**
- Pontosan meghatározta a szükséges mezőket és azok formátumát
- A magyar formátum (adószám, cégnév-végződés) explicit kérése konzisztens, valósnak tűnő adatokat eredményezett

---

#### CORS hiba megoldása – iteratív promptok

**1. prompt:**
> "I'm calling `/api/user/register` from Vue 3 using Axios and getting a CORS error. The backend is Laravel 12. What are the possible causes and how do I fix them?"

**2. prompt (folytatás):**
> "I don't have a `config/cors.php` file in my project."

**Miért működött jól:**
- Az első prompt megadta a technológiai kontextust (Vue 3, Laravel 12)
- A második prompt az AI első válaszára épített — nem kellett mindent újra elmagyarázni
- Az AI felsorolta a lehetséges okokat, és az első találat volt a tényleges hiba

---

### 3.2 Nem beváló promptok

#### Bejelentkezési állapot elvesztése oldal újratöltéskor

**Prompt:**
> "After a page reload, the authenticated user gets logged out. I'm using Laravel Sanctum for SPA authentication. Here are the relevant files: `auth.ts`, `axios.ts`, `UserController.php`, and my routes. What could cause the session to not persist?"

**Miért nem működött jól:**
- Az AI három lehetséges okot sorolt fel egymás után, amelyek közül egyik sem volt a tényleges hiba
- Miután jeleztem, hogy a felsorolt megoldások nem működnek, megismételte magát
- A tényleges hiba az volt, hogy a Sanctum-os route-ok az `api.php`-ban voltak a `web.php` helyett — ezt végül magam találtam meg az AI válaszai alapján
- **Tanulság:** Ha az AI ismétli magát, érdemes a konkrét fájlt és route-konfigurációt megmutatni ahelyett, hogy általánosan írjuk le a hibát

---

### 3.3 Közepes hatékonyságú promptok

#### Munkakörök listázása

**Prompt:**
> "I need a `JobList.vue` page that shows existing job categories in a table and allows adding new ones above it. `JobCreate.vue` already exists. Here is the current HTML structure I have: `[code]`. Please complete the table so it fetches and displays the data dynamically using a `for` loop."

**Eredmény:**
- Az AI 5 lépésben írta le a megoldást, de mivel még nem ismertem jól a Vue-t, nehéz volt kiszedni, hogy melyik kódrészlet hova tartozik
- Az első lépésnél szépen átalakította a beadott Tailwind-táblázatot és `for` ciklussal töltötte fel a sorokat
- A 3. lépésnél viszont TypeScript HTML-kódot adott, amelyet nem tudtam elhelyezni a projektben
- **Tanulság:** Több kontextus (pl. a fájl teljes tartalma) és egy konkrétabb kérdés hatékonyabb lett volna

---

## 4. Claude Code

### 4.1 Beváló promptok

#### Konkrét, kontextusos feladatleírás

**Prompt:**
> „Jelentkezések megoszlása státusz szerint, lehessen rendezni az álláshirdetéseket legújabb, vagy aszerint, hogy hányan jelentkeztek"

**Miért működött jól:**
- Egyértelmű, konkrét feladatot fogalmazott meg
- Két különálló funkciót kért egyszerre, amelyek logikailag összetartoznak
- Az AI felolvasta az érintett fájlokat, megértette a kontextust, és egyszerre módosította a backendet és a frontendet

---

#### Iteratív finomítás

**Prompt:**
> „Ha rákattintanak a Folyamatban, Elfogadva, vagy az Elutasítva gombra, akkor szűrje le a listát, és ha újra kattintanak, törölje a szűrőt"

**Miért működött jól:**
- Az előző eredményre épített (az összesítők már meg voltak)
- Pontosan leírta az elvárt viselkedést (toggle logika)
- Az AI azonnal értette, hogy az előző kártyákat kell interaktívvá tenni

---

#### Ugyanazon funkció más oldalra való alkalmazása

**Prompt:**
> „Csináld meg ugyanezt a szűrőt a job-offer/{id} oldalon is"

**Miért működött jól:**
- Egyértelmű referencia az előző implementációra
- Az AI felolvasta a célfájlt, azonosította a releváns szekciót, és következetesen alkalmazta a mintát

---

#### Iteratív komponensfejlesztés – JobOffers oldal

A `JobCard` komponenst előre elkészítettem, majd az alábbi lépésekben bővítettem az oldalt:

**1. prompt:**
> "Can you edit the JobOffers page. It must list all the available job offers from the DB, and it must use the JobCard view, and the cards could be next to each other if the window width allows it."

**2. prompt:**
> "Very nice, now if they click on the Továbbiak button they must see the selected job offer detail."

**3. prompt:**
> "I use MongoDB and the id attribute is always string not number."

**4. prompt:**
> "The JobOfferDetail card looks very nice, only can you make a back button, so they can continue the JobOffer search."

**5. prompt:**
> "Can you make a filter on the top of the JobOffers page?"

**6. prompt:**
> "Can you make the filter toggleable, if they click the search button on the top right corner (in the same line as the title), it would show/hide."

**Miért működött jól:**
- Minden prompt egy konkrét, kis feladatot adott — az AI soha nem tért el az elvárttól
- Az iteratív megközelítés (egy dolog egyszerre) minimalizálta a hibák számát
- A MongoDB-specifikus pontosítást (string id) elég volt egyszer jelezni, utána az AI következetesen alkalmazta

---

#### Globális stílusjavítás

**Prompt:**
> "Can you make all the buttons rounded border?"

**Miért működött jól:**
- Egyszerű, egyértelmű kérés
- Az AI megtalálta az összes érintett helyet a kódbázisban és egységesen alkalmazta a változtatást, anélkül hogy minden fájlt külön kellett volna megadni

---

#### Dummy adatok betöltése JSON-ból

**Prompt:**
> "I exported the data from the Job table in MongoDB, it's in JSON format, can you make a migration or something which will load those data into the Job table. It's in a .json file, but if needed I can copy its content into the code."

**Miért működött jól:**
- Felajánlotta az alternatívát (fájl vs. beillesztett tartalom), így az AI rugalmasan tudott dönteni
- A kimenet egy seeder osztály lett, amely beilleszthető a meglévő workflow-ba

---

### 4.2 Kevésbé jól működő promptok

#### Túl általános kérdés konkrét elvárás nélkül

**Prompt:**
> „Milyen összesítést tudnék végezni?"

**Miért volt kevésbé hatékony:**
- Az AI felsorolt több lehetőséget, de nem implementált semmit
- Egy döntési lépést igényelt a fejlesztőtől, mielőtt a tényleges munka elkezdődhetett
- **Tanulság:** Jobb lett volna egyből a konkrét összesítést megnevezni

---

#### Elvont követelményellenőrzés

**Prompt:**
> „Teljesít minden követelményt?" (követelménylistával)

**Miért volt részben korlátozott:**
- Az AI nem tudta ellenőrizni a vizuális E-K diagramot (az nem kódban van)
- A `.env` fájl tartalmát sem olvasta el automatikusan, ezért a MongoDB-használatot feltételezni kellett
- **Tanulság:** A nem kódalapú artefaktumokra vonatkozó kérdések manuális ellenőrzést igényelnek

---

## 5. Összefoglalás

**ChatGPT:** Hasznos volt adatgenerálásra és egyszerű hibakeresésre, de összetettebb, kódalapú feladatoknál (pl. session-kezelés) ismétlésbe esett, és a megoldást végül magam kellett megtalálnom.

**Claude Code:** Ez volt az első alkalom, hogy Claude Code-ot használtam (PhpStorm plugin-on keresztül). A modell jelentősen meggyorsította a fejlesztést és megkönnyítette a hibák keresését. Az angolul, egyszerűen megfogalmazott promptok után a generált kód jellemzően csak apró kézi módosítást igényelt. Nagyon kevés hiba fordult elő, és azokat gyorsan lehetett javítani. A kis kódbázis mérete kedvezett az AI-asszisztált fejlesztésnek, mivel a modell átlátja az egész projektet.

**A Claude Code leghasznosabb volt:**
- Boilerplate kód gyors generálásában (Vue komponens logika, computed property-k)
- Egyszerre több fájl konzisztens módosításában (backend + frontend párhuzamosan)
- Iteratív fejlesztésnél, ahol minden lépés egy konkrét kis feladat volt
- Dokumentáció strukturált megírásában

**A Claude Code kevésbé volt hasznos:**
- Vizuális artefaktumok (E-K diagram) létrehozásában
- Rendszer-szintű döntések meghozatalában (ezeket a fejlesztőnek kell megtenni)
- Általánosan megfogalmazott kérdéseknél, ahol konkrét elvárás hiányzott
