# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

### Setup (first time)
```bash
composer run setup
```
Installs PHP/npm dependencies, generates `.env` + `APP_KEY`, runs migrations, and builds frontend.

### Development
```bash
composer run dev
```
Starts Laravel (`artisan serve`), queue listener, log tailing (Pail), and Vite dev server concurrently.

Or run individually:
```bash
php artisan serve          # Laravel backend on :8000
npm run dev                # Vite dev server (HMR)
```

### Build
```bash
npm run build              # Production Vite build
```

### Tests
```bash
composer run test          # Clears config cache, then runs PHPUnit
php artisan test --filter TestName   # Run a single test
```

### Linting
```bash
./vendor/bin/pint          # Laravel Pint (PHP code style fixer)
```

### Database
```bash
php artisan migrate        # Run pending migrations
php artisan migrate:fresh  # Drop all tables and re-migrate
```

## Architecture

**Stack**: Laravel 12 backend + Vue 3 SPA frontend, built with Vite. The app is a job listing/management tool (Hungarian UI).

### Backend (Laravel)
- Routes live in `routes/web.php` — both auth endpoints and job API endpoints are defined here (not `routes/api.php`)
- All authenticated routes use `auth:sanctum` middleware
- Requests use Form Request classes in `app/Http/Requests/` for validation (Hungarian error messages)
- `Job` model uses `mongodb/laravel-mongodb` and has a self-referential parent/child relationship (`parent_job` FK → `id`)
- Auth is session-based via Laravel Sanctum; CSRF cookie must be fetched before POST requests

### Frontend (Vue 3 + TypeScript)
- Entry: `resources/js/app.ts` → mounts to `<div id="app">` in `resources/views/welcome.blade.php`
- SPA routing in `resources/js/router.ts` — the Laravel wildcard route catches all paths and serves the blade view
- Axios client at `resources/lib/axios.ts` targets `http://localhost:8000/` with `withCredentials: true` and XSRF support
- Auth state is managed reactively in `resources/js/services/auth.ts` (`isAuthenticated`, `user`, `loadUser()`, `logout()`)
- Sidebar (`resources/js/components/Sidebar.vue`) conditionally shows nav links based on auth state

### Data Flow for Job Creation
1. `JobList.vue` renders with embedded `JobCreate.vue` component
2. `JobCreate.vue` fetches `/job/list?only_main_jobs=true` for parent dropdown, calls `/sanctum/csrf-cookie` before POST
3. On success, emits `jobCreated` event → `JobList.vue` refreshes its table

### Database
- Default: SQLite (`DB_CONNECTION=sqlite`)
- MongoDB driver available (`mongodb/laravel-mongodb`) — `Job` model uses it
