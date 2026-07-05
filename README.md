<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# e-mart (E-Commerce Web Application)

A modern, full-stack e-commerce web application built with **Laravel 12 (PHP)** and styled using **Tailwind CSS v4** with **Alpine.js** for interactive frontend features.

This project implements all core features required for a full-scale e-commerce operations, including:
* **Storefront:** Browse trending products, search instantly, filter by category/brand, view reviews, and place orders.
* **Point of Sale (POS):** Walk-in customer management system with live search and automated transaction processing.
* **Admin Dashboard:** Total sales charts, low stock alerts, catalog CRUD, and Excel spreadsheet exports.

---

## Technical Stack
* **Framework:** Laravel 12.x
* **Language:** PHP ^8.2
* **Styling:** Tailwind CSS v4.x
* **Reactivity:** Alpine.js ^3.15
* **Report Generation:** Maatwebsite Excel ^3.1
* **Vite:** Asset build management

---

## Installation & Setup

1. **Clone the Repository:**
   ```bash
   git clone <repository-url>
   cd e-mart
   ```

2. **Run the Initialization Setup:**
   Run the project setup script or run composer:
   ```bash
   composer install
   npm install
   ```

3. **Configure Environment Variables:**
   Copy the example file to `.env`:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Initialize Database & Seed Data:**
   Create the database and run migrations with seed data:
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Start Dev Server:**
   Launch the Artisan development server and Vite compilation:
   ```bash
   npm run dev
   ```

---

## User Accounts (Seeded)

* **Admin User:** `admin@e-mart.test` (Password: `password`)
* **Customer User:** `customer@e-mart.test` (Password: `password`)

---

## Testing

Run the feature test suite:
```bash
php artisan test
```
