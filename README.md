# Álláskereső – Webes álláshirdetési platform

Webalapú álláshirdetési és -keresési rendszer, amelyen keresztül felhasználók böngészhetnek állásokra, jelentkezhetnek azokra, illetve cégek közzétehetnek hirdetéseket és kezelhetik a beérkező pályázatokat.

---

## Technológiai stack

| Réteg | Technológia |
|---|---|
| Adatbázis | MongoDB |
| Backend | PHP 8, Laravel 12 |
| Autentikáció | Laravel Sanctum (session-alapú) |
| Frontend | Vue 3, TypeScript, Vite, Tailwind CSS |

---

## Telepítés és futtatás

### Előfeltételek

- PHP >= 8.2
- Composer
- Node.js >= 18
- MongoDB (helyi példány a `mongodb://localhost:27017` címen)

### 1. Függőségek telepítése

```bash
composer install
npm install
```

### 2. Környezeti konfiguráció

```bash
cp .env.example .env
php artisan key:generate
```

A `.env` fájlban ellenőrizd az adatbázis-beállításokat:

```env
DB_CONNECTION=mongodb
DB_HOST=127.0.0.1
DB_PORT=27017
DB_DATABASE=allaskereso
```

### 3. Adatbázis migrálása és demo adatok betöltése

```bash
php artisan migrate:fresh --seed
```

Ez létrehozza az összes kollekciót és feltölti őket demo adatokkal (358 rekord).

### 4. Fejlesztői szerver indítása

```bash
composer run dev
```

Ez egyszerre indítja el:
- Laravel backend: `http://localhost:8000`
- Vite dev szerver (HMR)

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
