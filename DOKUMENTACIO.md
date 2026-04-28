# Álláskereső alkalmazás – Adatbázis-alkalmazás dokumentáció

**Készítette:** Poprádi Gabriella  
**Dátum:** 2026. április  
**Platform:** MongoDB (NoSQL), Laravel 12, Vue 3

---

## 1. Az alkalmazás leírása

Az **Álláskereső** egy webalapú álláshirdetési és -keresési platform, amelyen keresztül a felhasználók böngészhetnek a meghirdetett állásokra, jelentkezhetnek azokra, illetve a cégek közzétehetnek hirdetéseket és kezelhetik a beérkező pályázatokat.

Az alkalmazás három szerepkört különböztet meg:
- **Vendég** – Csak bejelentkezni, regisztrálni tud
- **Felhasználó (USER)** – böngészhet, jelentkezhet állásokra, kezelhet céget
- **Adminisztrátor (ADMIN)** – teljes hozzáféréssel rendelkezik minden adathoz

---

## 2. Technológiai stack

| Réteg | Technológia |
|---|---|
| Adatbázis | **MongoDB** (NoSQL, dokumentum-alapú) |
| Backend | Laravel 12 (PHP), Laravel Sanctum (autentikáció) |
| Frontend | Vue 3 (TypeScript), Vite, Tailwind CSS |
| API | RESTful JSON API (session-alapú, CSRF-védelemmel) |

### Miért MongoDB?

A MongoDB dokumentum-alapú NoSQL adatbázis, amely a relációs modelltől eltérően rugalmas, séma nélküli dokumentumokban tárolja az adatokat. Az alkalmazásban ez különösen előnyös:
- A `Job` (munkakör-kategória) egyed önhivatkozó hierarchiát valósít meg, amit MongoDB-ben természetesebb kezelni
- Az `Employee` egyed a `rights` mezőben tömbként tárolja a jogosultságokat
- A dokumentumok dinamikusan bővíthetők extra mezőkkel anélkül, hogy a sémát módosítani kellene

---

## 3. Egyed-kapcsolat (E-K) diagram

### Egyedek és tulajdonságaik

#### 3.1 User (Felhasználó)
| Tulajdonság | Típus | Leírás |
|---|---|---|
| _id | ObjectId (PK) | Egyedi azonosító |
| name | String | Teljes név |
| username | String (egyedi) | Felhasználónév |
| email | String (egyedi) | E-mail cím |
| password | String (hash) | Jelszó (titkosítva) |
| birth_date | String | Születési dátum |
| role | Enum (USER/ADMIN) | Szerepkör |

#### 3.2 Company (Cég)
| Tulajdonság | Típus | Leírás |
|---|---|---|
| _id | ObjectId (PK) | Egyedi azonosító |
| name | String | Cégnév |
| contact_email | String | Kapcsolattartási e-mail |
| location | String | Székhely |
| tax_id | String | Adószám |
| created_by | ObjectId (FK → User) | Létrehozó felhasználó |

#### 3.3 Employee (Alkalmazott)
| Tulajdonság | Típus | Leírás |
|---|---|---|
| _id | ObjectId (PK) | Egyedi azonosító |
| user_id | ObjectId (FK → User) | Felhasználó azonosítója |
| company_id | ObjectId (FK → Company) | Cég azonosítója |
| rights | Array (Enum) | Jogosultságok: CREATE_JOB_OFFER, HANDLE_APPLICATIONS, EDIT_COMPANY_DATA |

#### 3.4 Job (Munkakör-kategória)
| Tulajdonság | Típus | Leírás |
|---|---|---|
| _id | ObjectId (PK) | Egyedi azonosító |
| title | String | Kategória neve |
| parent_job | ObjectId (FK → Job, null) | Szülő kategória (önhivatkozó) |

Megjegyzés: a `Job` egyed kétszintű hierarchiát valósít meg (főkategória → alkategória). Pl.: *Informatika* → *Frontend fejlesztő*.

#### 3.5 JobOffer (Álláshirdetés)
| Tulajdonság | Típus | Leírás |
|---|---|---|
| _id | ObjectId (PK) | Egyedi azonosító |
| title | String | Pozíció neve |
| description | String | Leírás |
| salary_min | Integer | Minimális fizetés (Ft) |
| salary_max | Integer | Maximális fizetés (Ft) |
| location | String | Munkavégzés helyszíne |
| work_mode | Enum (ON_SITE/REMOTE/HYBRID) | Munkavégzés módja |
| company_id | ObjectId (FK → Company) | Hirdető cég |
| job_id | ObjectId (FK → Job) | Munkakör-kategória |
| created_at | DateTime | Létrehozás dátuma |
| updated_at | DateTime | Módosítás dátuma |

#### 3.6 Application (Jelentkezés)
| Tulajdonság | Típus | Leírás |
|---|---|---|
| _id | ObjectId (PK) | Egyedi azonosító |
| user_id | ObjectId (FK → User) | Jelentkező felhasználó |
| job_offer_id | ObjectId (FK → JobOffer) | Megpályázott hirdetés |
| cv | String | CV fájl elérési útja |
| status | Enum (PENDING/APPROVED/DECLINED) | Jelentkezés státusza |
| created_at | DateTime | Jelentkezés dátuma |
| updated_at | DateTime | Módosítás dátuma |

---

### 3.7 Kapcsolatok

```
User ──────────────────── 1:N ──── Company
  (egy felhasználó több céget hozhat létre)

User ──────────────────── N:M ──── Company
  (Employee kapcsolótáblán keresztül:
   egy felhasználó több cég alkalmazottja lehet,
   egy cégnek több alkalmazottja lehet)

Company ────────────────── 1:N ──── JobOffer
  (egy cégnek több álláshirdetése lehet)

Job ──────────────────────── 1:N ──── Job
  (önhivatkozó: egy főkategóriának több alkategóriája lehet)

Job ──────────────────────── 1:N ──── JobOffer
  (egy munkakör-kategóriához több hirdetés tartozhat)

User ──────────────────── 1:N ──── Application
  (egy felhasználó több állásra jelentkezhet)

JobOffer ──────────────── 1:N ──── Application
  (egy hirdetésre több jelentkezés érkezhet)
```

---

## 4. Az alkalmazás funkciói

### 4.1 Autentikáció
| Funkció | Végpont | Leírás |
|---|---|---|
| Regisztráció | POST /user/register | Új felhasználói fiók létrehozása |
| Bejelentkezés | POST /user/login | Session alapú bejelentkezés |
| Kijelentkezés | POST /user/logout | Session törlése |
| Profil szerkesztése | PUT /user/profile | Név, születési dátum módosítása |

### 4.2 Álláshirdetések
| Funkció | Végpont | Leírás |
|---|---|---|
| Lista megtekintése | GET /job-offer | Összes aktív hirdetés listázása |
| Részletek | GET /job-offer/{id} | Hirdetés részletes adatai |
| Létrehozás | POST /job-offer | Új hirdetés feladása (cég jogosultsággal) |
| Szerkesztés | PUT /job-offer/{id} | Hirdetés adatainak módosítása |
| Törlés | DELETE /job-offer/{id} | Hirdetés törlése |

**Szűrési lehetőségek:**
- Cím szerint (szöveges keresés)
- Helyszín szerint
- Munkavégzés módja szerint (irodai / távoli / hibrid)
- Minimális fizetés szerint

**Rendezési lehetőségek:**
- Legújabb hirdetések elöl
- Legtöbb jelentkező szerint (csökkenő)

### 4.3 Jelentkezések
| Funkció | Végpont | Leírás |
|---|---|---|
| Saját jelentkezések | GET /application | Bejelentkezett felhasználó pályázatai |
| Jelentkezés | POST /application | Állásra való pályázat beküldése (CV feltöltéssel) |
| Visszavonás | DELETE /application/{id} | PENDING státuszú jelentkezés törlése |
| Státusz módosítása | PATCH /application/{id}/status | Elfogadás / Elutasítás (cég jogosultsággal) |
| Hirdetés pályázói | GET /job-offer/{id}/applications | Adott hirdetés összes pályázója |

**Összesítések a Jelentkezéseim oldalon:**
- Folyamatban lévő pályázatok száma
- Elfogadott pályázatok száma
- Elutasított pályázatok száma
- Szűrés státusz szerint (kattintással)

### 4.4 Cégek
| Funkció | Végpont | Leírás |
|---|---|---|
| Saját cégek | GET /company | Bejelentkezett felhasználó cégei |
| Cég létrehozása | POST /company | Új cég regisztrálása |
| Cég szerkesztése | PUT /company/{id} | Cégadatok módosítása |
| Cég törlése | DELETE /company/{id} | Cég törlése |
| Alkalmazottak listája | GET /company/{id}/employees | Cég alkalmazottjainak megtekintése |
| Alkalmazott hozzáadása | POST /company/{id}/employees | Meglévő felhasználó felvétele |
| Alkalmazott regisztrálása | POST /company/{id}/employees/register | Új felhasználó + alkalmazott egyszerre |
| Alkalmazott módosítása | PUT /company/{id}/employees/{eid} | Jogosultságok szerkesztése |
| Alkalmazott eltávolítása | DELETE /company/{id}/employees/{eid} | Alkalmazott törlése |

### 4.5 Munkakör-kategóriák
| Funkció | Végpont | Leírás |
|---|---|---|
| Lista | GET /job/list | Kategóriák és alkategóriák listája |
| Létrehozás | POST /job/create | Új kategória (admin) |
| Szerkesztés | PUT /job/{id} | Kategória módosítása (admin) |
| Törlés | DELETE /job/{id} | Kategória törlése (admin) |

**Főkategóriák:**
Informatika, Mérnöki/Műszaki, Üzleti/Gazdasági, Marketing/Kreatív, Kereskedelem/Értékesítés, Egészségügy, Oktatás, Logisztika/Szállítás, Fizikai/Szakmunkák

### 4.6 Adminisztrátori felület
| Funkció | Végpont | Leírás |
|---|---|---|
| Felhasználók listája | GET /admin/users | Összes regisztrált felhasználó |
| Felhasználó adatai | GET /admin/users/{id} | Részletes adatok |
| Felhasználó módosítása | PUT /admin/users/{id} | Adatok, szerepkör szerkesztése |

---

## 5. Jogosultsági rendszer

Az alkalmazás háromszintű jogosultságrendszert alkalmaz:

### Felhasználói szerepkörök
| Szerepkör | Leírás |
|---|---|
| USER | Alap felhasználó: böngészhet, jelentkezhet, céget hozhat létre |
| ADMIN | Teljes hozzáférés: felhasználók, kategóriák, minden cég kezelése |

### Alkalmazotti jogosultságok (cégen belül)
| Jogosultság | Leírás |
|---|---|
| EDIT_COMPANY_DATA | Cégadatok szerkesztése |
| CREATE_JOB_OFFER | Álláshirdetések feladása és kezelése |
| HANDLE_APPLICATIONS | Beérkező pályázatok kezelése (elfogadás/elutasítás) |

---

## 6. Tesztadatok

Az adatbázis az alábbi mennyiségű tesztadattal van feltöltve:

| Gyűjtemény | Darabszám |
|---|---|
| user | 20 (19 normál + 1 admin) |
| company | 26 |
| employee | 44 |
| job (kategória) | 58 (9 főkategória + 49 alkategória) |
| job_offer | 60 |
| application | 150 |
| **Összesen** | **358 rekord** |

A tesztadatok valósághű, magyar neveket, e-mail-címeket, helyszíneket (Budapest, Debrecen, Szeged, Pécs, Győr) és fizetési sávokat (300 000 – 1 400 000 Ft) tartalmaznak.

---

## 7. Az adatbázis feltöltése

```bash
php artisan migrate:fresh --seed
```

Ez a parancs törli az összes meglévő adatot, újra futtatja a migrációkat, majd sorrendben végrehajtja a seedereket:

1. `JobSeeder` – munkakör-kategóriák
2. `UserSeeder` – felhasználók
3. `CompanySeeder` – cégek
4. `EmployeeSeeder` – alkalmazotti kapcsolatok
5. `JobOfferSeeder` – álláshirdetések
6. `ApplicationSeeder` – jelentkezések

---

## 8. Az alkalmazás indítása

```bash
# Függőségek telepítése (első alkalommal)
composer run setup

# Fejlesztői szerver indítása
composer run dev
```

Az alkalmazás elérhető: `http://localhost:8000`

**Teszt admin fiók:**
- E-mail: `admin@admin.com`
- Jelszó: `password`
