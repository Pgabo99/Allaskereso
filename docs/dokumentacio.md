# Álláskereső – Szoftveres dokumentáció

**Készítette:** Poprádi Gabriella  
**Dátum:** 2026. április

---

## 1. Az alkalmazás leírása

Az **Álláskereső** egy webalapú álláshirdetési és -keresési platform. A rendszer három szereplő köré épül:

- **Felhasználó** – böngészhet hirdetések között, jelentkezhet állásokra, kezelhet céget
- **Cég** – álláshirdetéseket tehet közzé, kezelheti a beérkező pályázatokat, alkalmazottakat rendelhet a céghöz
- **Adminisztrátor** – teljes hozzáférés minden adathoz, felhasználók és kategóriák kezelése

---

## 2. Technológiai stack és indoklás

### 2.1 MongoDB (adatbázis)

A projekt MongoDB NoSQL dokumentum-alapú adatbázist használ a `mongodb/laravel-mongodb` csomagon keresztül.

**Indoklás:**
- A `Job` (munkakör-kategória) egyed önhivatkozó hierarchiát valósít meg (főkategória → alkategória), amit dokumentum-alapú adatbázisban természetesebb kezelni
- Az `Employee` egyed a `rights` mezőben tömbként tárolja a jogosultságokat — ezt MongoDB natívan támogatja sémaváltás nélkül
- A MongoDB rugalmas dokumentumszerkezete lehetővé teszi a gyors fejlesztést és a séma iterálását
- Könnyen hostolható lokálisan, konténerben (Docker) vagy felhőben (MongoDB Atlas)

### 2.2 Laravel 12 (backend)

**Indoklás:**
- PHP ökoszisztéma, erős közösség és dokumentáció
- Beépített Eloquent ORM, ami a MongoDB driverrel is kompatibilis
- Laravel Sanctum a session-alapú autentikációhoz — egyszerű, biztonságos megoldás SPA-hoz
- Form Request osztályok a validációhoz, MVC architektúra a kód szervezettségéhez
- Artisan CLI: migrációk, seederek, kódgenerálás

### 2.3 Vue 3 + TypeScript (frontend)

**Indoklás:**
- Composition API és `<script setup>` szintaxis: tömör, olvasható komponensek
- TypeScript: típusbiztonság, jobb IDE-támogatás, kevesebb futásidejű hiba
- Vue Router: SPA-routing, a Laravel wildcard route-ja kiszolgálja az összes frontend útvonalat
- Reaktív állapotkezelés (`ref`, `computed`) beépítve — nincs szükség külső state managerré

### 2.4 Vite (build tool)

**Indoklás:**
- Natív ESM alapú dev szerver: azonnali HMR (Hot Module Replacement)
- `laravel-vite-plugin` zökkenőmentesen integrálja a Laravel blade template-tel

### 2.5 Tailwind CSS (stílus)

**Indoklás:**
- Utility-first megközelítés: gyors UI fejlesztés egyedi osztályok írása nélkül
- Nem kell külön CSS fájlokat karbantartani

---

## 3. Adatmodell

### 3.1 Egyedek (kollekciók)

#### User (Felhasználó)
| Mező | Típus | Leírás |
|---|---|---|
| _id | ObjectId (PK) | Egyedi azonosító |
| name | String | Teljes név |
| username | String (egyedi) | Felhasználónév |
| email | String (egyedi) | E-mail cím |
| password | String (bcrypt) | Jelszó |
| birth_date | String | Születési dátum |
| role | Enum: USER/ADMIN | Szerepkör |

#### Company (Cég)
| Mező | Típus | Leírás |
|---|---|---|
| _id | ObjectId (PK) | Egyedi azonosító |
| name | String | Cégnév |
| contact_email | String | Kapcsolattartási e-mail |
| location | String | Székhely |
| tax_id | String | Adószám |
| created_by | ObjectId → User | Létrehozó felhasználó |

#### Employee (Alkalmazott)
| Mező | Típus | Leírás |
|---|---|---|
| _id | ObjectId (PK) | Egyedi azonosító |
| user_id | ObjectId → User | Felhasználó |
| company_id | ObjectId → Company | Cég |
| rights | Array\<Enum\> | Jogosultságok: CREATE_JOB_OFFER, HANDLE_APPLICATIONS, EDIT_COMPANY_DATA |

#### Job (Munkakör-kategória)
| Mező | Típus | Leírás |
|---|---|---|
| _id | ObjectId (PK) | Egyedi azonosító |
| title | String | Kategória neve |
| parent_job | ObjectId → Job (null) | Szülő kategória (önhivatkozó) |

#### JobOffer (Álláshirdetés)
| Mező | Típus | Leírás |
|---|---|---|
| _id | ObjectId (PK) | Egyedi azonosító |
| title | String | Pozíció neve |
| description | String | Részletes leírás |
| salary_min | Integer | Min. fizetés (Ft) |
| salary_max | Integer | Max. fizetés (Ft) |
| location | String | Munkavégzés helyszíne |
| work_mode | Enum: ON_SITE/REMOTE/HYBRID | Munkavégzés módja |
| company_id | ObjectId → Company | Hirdető cég |
| job_id | ObjectId → Job | Munkakör-kategória |
| created_at | DateTime | Létrehozás dátuma |

#### Application (Jelentkezés)
| Mező | Típus | Leírás |
|---|---|---|
| _id | ObjectId (PK) | Egyedi azonosító |
| user_id | ObjectId → User | Pályázó |
| job_offer_id | ObjectId → JobOffer | Megpályázott hirdetés |
| cv | String | CV fájl elérési útja |
| status | Enum: PENDING/APPROVED/DECLINED | Státusz |
| created_at | DateTime | Jelentkezés dátuma |

### 3.2 Kapcsolatok

```
User          ──── 1:N ────► Company        (egy felhasználó több céget hozhat létre)
User          ──── N:M ────► Company        (Employee kapcsolótáblán: alkalmazotti viszony)
Company       ──── 1:N ────► JobOffer       (egy cégnek több hirdetése lehet)
Job           ──── 1:N ────► Job            (önhivatkozó hierarchia: főkategória → alkategória)
Job           ──── 1:N ────► JobOffer       (egy kategóriához több hirdetés tartozhat)
User          ──── 1:N ────► Application    (egy felhasználó több állásra jelentkezhet)
JobOffer      ──── 1:N ────► Application    (egy hirdetésre több jelentkezés érkezhet)
```

---

## 4. REST API végpontok

### Autentikáció
| Metódus | Végpont | Leírás | Auth |
|---|---|---|---|
| POST | /user/register | Regisztráció | – |
| POST | /user/login | Bejelentkezés | – |
| POST | /user/logout | Kijelentkezés | ✅ |
| GET | /user/get-logged-in-user | Bejelentkezett felhasználó | ✅ |
| PUT | /user/profile | Profil szerkesztése | ✅ |

### Álláshirdetések
| Metódus | Végpont | Leírás | Auth |
|---|---|---|---|
| GET | /job-offer | Lista (szűrhető) | ✅ |
| GET | /job-offer/{id} | Részletek | ✅ |
| POST | /job-offer | Létrehozás | ✅ |
| PUT | /job-offer/{id} | Módosítás | ✅ |
| DELETE | /job-offer/{id} | Törlés | ✅ |

### Jelentkezések
| Metódus | Végpont | Leírás | Auth |
|---|---|---|---|
| GET | /application | Saját jelentkezések | ✅ |
| POST | /application | Jelentkezés beküldése | ✅ |
| DELETE | /application/{id} | Visszavonás | ✅ |
| PATCH | /application/{id}/status | Státusz módosítása | ✅ |
| GET | /job-offer/{id}/applications | Hirdetés pályázói | ✅ |

### Cégek
| Metódus | Végpont | Leírás | Auth |
|---|---|---|---|
| GET | /company | Saját cégek | ✅ |
| POST | /company | Cég létrehozása | ✅ |
| PUT | /company/{id} | Cég módosítása | ✅ |
| DELETE | /company/{id} | Cég törlése | ✅ |
| GET | /company/{id}/employees | Alkalmazottak | ✅ |
| POST | /company/{id}/employees | Alkalmazott hozzáadása | ✅ |
| PUT | /company/{id}/employees/{eid} | Alkalmazott módosítása | ✅ |
| DELETE | /company/{id}/employees/{eid} | Alkalmazott eltávolítása | ✅ |

### Munkakör-kategóriák
| Metódus | Végpont | Leírás | Auth |
|---|---|---|---|
| GET | /job/list | Kategóriák listája | ✅ |
| POST | /job/create | Létrehozás | ✅ Admin |
| PUT | /job/{id} | Módosítás | ✅ Admin |
| DELETE | /job/{id} | Törlés | ✅ Admin |

---

## 5. Funkcionális követelmények

| # | Követelmény | Megvalósítva |
|---|---|---|
| F1 | Felhasználó regisztrálhat és bejelentkezhet | ✅ |
| F2 | Felhasználó böngészhet az álláshirdetések között | ✅ |
| F3 | Felhasználó szűrheti a hirdetéseket (cím, helyszín, munkamód, fizetés) | ✅ |
| F4 | Felhasználó rendezheti a hirdetéseket (legújabb / legtöbb jelentkező) | ✅ |
| F5 | Felhasználó jelentkezhet állásra CV feltöltésével | ✅ |
| F6 | Felhasználó visszavonhatja PENDING státuszú jelentkezését | ✅ |
| F7 | Felhasználó láthatja saját jelentkezéseit státusz szerint összesítve | ✅ |
| F8 | Felhasználó létrehozhat és szerkeszthet céget | ✅ |
| F9 | Cég alkalmazottakat adhat hozzá jogosultságokkal | ✅ |
| F10 | Jogosult cég-tag álláshirdetést hozhat létre, szerkeszthet, törölhet | ✅ |
| F11 | Jogosult cég-tag kezelheti a beérkező pályázatokat (elfogad/elutasít) | ✅ |
| F12 | Adminisztrátor kezeli a felhasználókat és munkakör-kategóriákat | ✅ |

---

## 6. Nem-funkcionális követelmények

| # | Követelmény | Megvalósítva |
|---|---|---|
| NF1 | CSRF-védelem minden POST/PUT/DELETE kérésnél | ✅ |
| NF2 | Csak autentikált felhasználók hajthatnak végre CRUD műveleteket | ✅ |
| NF3 | Jelszavak bcrypt-tel tárolva | ✅ |
| NF4 | Validáció szerver oldalon (Form Request osztályok) | ✅ |
| NF5 | Jogosultsági ellenőrzés minden érzékeny végponton | ✅ |
| NF6 | SPA: oldalváltás oldal-újratöltés nélkül | ✅ |
| NF7 | Reszponzív UI (Tailwind CSS) | ✅ |

---

## 7. Demo adatok

| Kollekció | Rekordok száma |
|---|---|
| user | 20 |
| company | 26 |
| employee | 44 |
| job | 58 |
| job_offer | 60 |
| application | 150 |
| **Összesen** | **358** |

Betöltés: `php artisan migrate:fresh --seed`
