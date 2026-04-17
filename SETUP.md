# SmileCare Dental Management System — Setup Guide

## Overview

A Laravel 11 web application for managing a dental clinic.  
Roles: **Admin**, **Staff**, **Doctor**, **Patient**

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | PHP 8.3, Laravel 11 |
| Frontend | Blade, Tailwind CSS v3, Alpine.js |
| Database | MySQL 8.0 |
| Build | Vite + Node.js 20 |
| Package manager | Composer 2 |

---

## Option A — Native Windows (Recommended, Fastest)

### Step 1 — Install Required Software

Install each tool in order:

| Software | Download | Notes |
|----------|----------|-------|
| **Laragon Full** | https://laragon.org/download | Includes PHP 8.2+, MySQL 8, Nginx |
| **Node.js 20 LTS** | https://nodejs.org | Choose the LTS version |
| **Composer 2** | https://getcomposer.org/download | Windows installer |

After installing Laragon, verify PHP is available in terminal:
```bash
php -v
```
If not found, add Laragon's PHP to your system PATH:  
`C:\laragon\bin\php\php-8.x.x-Win32-vs16-x64`

---

### Step 2 — Create the Database

1. Open **Laragon** → click **Database** (HeidiSQL opens)
2. Connect with: host `127.0.0.1`, user `root`, password *(empty)*
3. Right-click → **Create new** → **Database**
4. Name it: `dental_db`

---

### Step 3 — Configure Environment

Open `.env` in the project root and confirm these values:

```env
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dental_db
DB_USERNAME=root
DB_PASSWORD=

CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
```

> If your MySQL root has a password, set `DB_PASSWORD=yourpassword`

---

### Step 4 — Install Dependencies

Open a terminal in the project folder (`d:\Dental Managment System`) and run:

```bash
composer install
```

```bash
npm install
npm run build
```

---

### Step 5 — Run Migrations & Seed

```bash
php artisan migrate --force
php artisan db:seed --force
```

This creates all tables and inserts default users.

---

### Step 6 — Final Setup

```bash
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

### Step 7 — Start the App

```bash
php artisan serve
```

Open **http://localhost:8000**

---

## Option B — Docker (Cross-platform)

### Requirements

- [Docker Desktop](https://www.docker.com/products/docker-desktop) (Windows/Mac/Linux)
- Docker Compose v2

### Start

```bash
docker compose up -d
```

Open **http://localhost:8000**

### Stop

```bash
docker compose down
```

### Useful Docker commands

```bash
# View logs
docker compose logs app

# Run artisan commands
docker compose exec app php artisan migrate

# Rebuild after code changes
docker compose exec app php artisan view:clear
docker compose exec app php artisan view:cache
```

---

## Default Login Accounts

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@dental.com | Admin@1234 |
| Doctor | dr.smith@dental.com | Doctor@1234 |
| Staff | staff@dental.com | Staff@1234 |
| Patient | patient@dental.com | Patient@1234 |

> Change all passwords after first login in production.

---

## Application URLs

| URL | Description |
|-----|-------------|
| http://localhost:8000 | Main app / login |
| http://localhost:8000/book | Public appointment booking |
| http://localhost:8080 | phpMyAdmin (Docker only) |
| http://localhost:8025 | Mailpit email viewer (Docker only) |

---

## Role Capabilities

### Admin
- Full access to all modules
- Manage users, roles, services, settings
- View reports and analytics
- Create/approve/cancel appointments
- Manage billing and inventory

### Staff
- Create and manage appointments
- Manage patients (add/edit)
- Create invoices and record payments
- Manage inventory items

### Doctor
- View assigned appointments
- Start sessions and mark complete
- Add clinical notes
- View patient history

### Patient (Portal)
- Book appointments via public form
- View own appointments and invoices
- Download invoice PDFs
- Update personal profile

---

## Appointment Workflow

```
[Booked] → pending
    ↓ Staff/Admin: Approve
[Approved] → confirmed
    ↓ Doctor: Start Session
[In Session] → in_progress
    ↓ Doctor: Add Notes + Mark Complete
[Done] → completed
    ↓ Staff: Create Invoice
[Invoice Created] → unpaid
    ↓ Staff: Record Payment
[Paid] → paid
```

---

## Project Structure

```
app/
  Http/Controllers/
    Admin/       ← Admin panel controllers
    Staff/       ← Staff panel controllers
    Doctor/      ← Doctor panel controllers
    Patient/     ← Patient portal controllers
    Public/      ← Public booking controller
  Models/        ← Eloquent models

resources/views/
  layouts/       ← dashboard.blade.php (main layout)
  admin/         ← Admin views
  staff/         ← Staff views
  doctor/        ← Doctor views
  patient/       ← Patient portal views
  partials/      ← Shared table partials
  public/        ← Public booking pages

routes/
  web.php        ← All routes

database/
  migrations/    ← Database schema
  seeders/       ← Default data
```

---

## Troubleshooting

**500 error after deploy**
```bash
php artisan config:clear
php artisan config:cache
php artisan view:clear
php artisan view:cache
```

**Migrations fail**
- Check DB credentials in `.env`
- Ensure `dental_db` database exists

**Assets not loading (blank/unstyled page)**
```bash
npm run build
```

**Permission errors (Linux/Mac only)**
```bash
chmod -R 775 storage bootstrap/cache
```

**Queue jobs not running**  
For production, change `QUEUE_CONNECTION=sync` to `redis` or `database` and run:
```bash
php artisan queue:work
```
