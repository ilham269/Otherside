# Otherside Official Store

Platform e-commerce untuk produk custom (kaos, hoodie, tote bag, aksesoris) dengan fitur custom order, manajemen konten, dan panel admin lengkap.

## Tech Stack

- **Backend** — Laravel 11
- **Frontend** — Bootstrap 5, Sass, Vite
- **Database** — MySQL
- **Auth** — Dual guard (admin & user)

## Fitur

- Halaman storefront dengan hero slider, featured product, best sellers
- Sistem order produk & custom order
- Panel admin dengan dashboard, CRUD produk, kategori, orders, posts, users
- Service layer pattern — logic terpisah dari controller
- Form Request validation
- Seeder data dummy lengkap

## Instalasi

### 1. Clone repo

```bash
git clone https://github.com/ilham269/Otherside.git
cd Otherside
```

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Setup environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` sesuaikan koneksi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=otherside
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Migrasi & seed database

```bash
php artisan migrate --seed
```

### 5. Storage link

```bash
php artisan storage:link
```

### 6. Build assets

```bash
npm run build
```

### 7. Jalankan server

```bash
php artisan serve
```

Akses di `http://localhost:8000`

## Akun Default

| Role  | Email                    | Password |
|-------|--------------------------|----------|
| Admin | admin@otherside.com      | password |
| Admin | editor@otherside.com     | password |
| User  | budi@gmail.com           | password |

Admin panel: `http://localhost:8000/admin/login`

## Struktur Folder Utama

```
app/
├── Http/
│   ├── Controllers/Admin/   # Controller admin
│   ├── Middleware/          # AdminMiddleware, RedirectIfAuthenticated
│   └── Requests/Admin/      # Form Request validation
├── Models/                  # Eloquent models
└── Services/                # Business logic layer

resources/
├── sass/                    # admin.scss, welcome.scss
├── js/                      # admin.js
└── views/
    ├── admin/               # Views panel admin
    ├── layouts/             # store.blade.php, admin.blade.php
    └── partials/            # navbar.blade.php, footer.blade.php
```
