# Álláskereső – Webes álláshirdetési platform

Webalapú álláshirdetési és -keresési rendszer, amelyen keresztül felhasználók böngészhetnek állásokra, jelentkezhetnek azokra, illetve cégek közzétehetnek hirdetéseket és kezelhetik a beérkező pályázatokat.

---

## Technológiai stack

| Réteg | Technológia |
|---|---|
| Adatbázis | MongoDB |
| Backend | PHP 8.2+, Laravel 12 |
| Autentikáció | Laravel Sanctum (session-alapú) |
| Frontend | Vue 3, TypeScript, Vite, Tailwind CSS |

---

## Előfeltételek

- PHP >= 8.2 **a MongoDB kiterjesztéssel** (`ext-mongodb`)
- Composer
- Node.js >= 18
- MongoDB szerver (lokális vagy Docker vagy MongoDB Atlas)

---

## 1. lépés – MongoDB Atlas kapcsolat

Az adatbázis MongoDB Atlas felhőben van hosztolva, a kapcsolati adatok már szerepelnek a `.env.example` fájlban — külön konfiguráció nem szükséges.

---

## 2. lépés – PHP MongoDB kiterjesztés telepítése

### XAMPP-on (Windows)

1. Ellenőrizd a PHP verziódat: `php -v`
2. Töltsd le a megfelelő `php_mongodb.dll` fájlt: https://pecl.php.net/package/mongodb
   - Válaszd ki a PHP verziódnak és architektúrádnak megfelelőt (pl. `8.2 Thread Safe x64`)
3. Másold a `.dll` fájlt a `C:\xampp\php\ext\` mappába
4. Nyisd meg a `C:\xampp\php\php.ini` fájlt, és add hozzá:
   ```
   extension=mongodb
   ```
5. Indítsd újra az Apache-ot az XAMPP Controlban

### Ellenőrzés

```bash
php -m | grep mongodb
```

Ha megjelenik a `mongodb`, a kiterjesztés aktív.

---

## 3. lépés – Az alkalmazás telepítése

```bash
# PHP és npm függőségek telepítése
composer install
npm install

# Környezeti fájl létrehozása
cp .env.example .env
php artisan key:generate
```

---

## 4. lépés – Adatbázis feltöltése

```bash
php artisan migrate:fresh --seed
```

Ez létrehozza az összes kollekciót és feltölti őket demo adatokkal (358 rekord).

---

## 5. lépés – Fejlesztői szerver indítása

```bash
composer run dev
```

Az alkalmazás elérhető: **http://localhost:8000**

---

## Teszt belépési adatok

| Szerepkör | E-mail | Jelszó |
|---|---|---|
| Admin | admin@admin.com | almafa123 |
| Felhasználó | kiss.adam@example.com | Adam123! |

---

## Elérhető parancsok

```bash
composer run dev       # Fejlesztői szerver indítása
composer run test      # Tesztek futtatása
npm run build          # Production build
php artisan migrate    # Migrációk futtatása
./vendor/bin/pint      # PHP kódstílus ellenőrzés
```

---

## Dokumentáció

A részletes szoftveres dokumentáció a [`docs/`](docs/) mappában található.
