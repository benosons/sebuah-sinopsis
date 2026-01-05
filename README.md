# Core Laravel Project

Proyek Laravel inti dengan fitur manajemen user, roles & permissions, dan autentikasi lengkap.

## 📋 Fitur

- ✅ Autentikasi (Login, Register, Forgot Password)
- ✅ Manajemen User (CRUD)
- ✅ Manajemen Roles & Permissions (Spatie Laravel Permission)
- ✅ Dashboard Admin
- ✅ Tailwind CSS (CDN - tanpa Node.js)
- ✅ Alpine.js untuk interaktivitas

## 🔧 Prasyarat

- PHP 7.4+ atau PHP 8.x
- Composer
- MySQL / MariaDB
- Laravel Herd (opsional, untuk development)

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone <repository-url>
cd core-laravel
```

### 2. Install Dependencies PHP

```bash
composer install
```

### 3. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=core_laravel_db
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Buat Database

```bash
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS core_laravel_db;"
```

### 6. Jalankan Migration & Seeder

```bash
php artisan migrate --seed
```

Ini akan membuat:
- Tabel users, roles, permissions
- User admin default

## 🏃 Menjalankan Aplikasi

### Menggunakan Laravel Herd

Jika menggunakan Laravel Herd, aplikasi otomatis tersedia di:

```
http://core-laravel.test
```

Pastikan folder project sudah ditambahkan di Herd Sites.

### Menggunakan PHP Artisan Serve

```bash
php artisan serve
```

Akses di: `http://127.0.0.1:8000`

## 👤 Login Default

Setelah menjalankan seeder, gunakan kredensial berikut:

| Email | Password |
|-------|----------|
| `admin@example.com` | `password` |

## 📁 Struktur Folder Utama

```
core-laravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/           # Controller admin (User, Role)
│   │   │   └── Auth/            # Controller autentikasi
│   │   └── Middleware/
│   ├── Models/
│   │   └── User.php
│   └── Providers/
├── database/
│   ├── migrations/              # File migrasi database
│   └── seeders/
│       ├── CreateAdminUserSeeder.php
│       └── DatabaseSeeder.php
├── resources/
│   └── views/
│       ├── admin/               # View halaman admin
│       │   ├── users/
│       │   └── roles/
│       ├── auth/                # View autentikasi
│       ├── components/          # Blade components
│       └── layouts/             # Layout templates
├── routes/
│   ├── web.php                  # Route utama
│   └── auth.php                 # Route autentikasi
└── .env                         # Konfigurasi environment
```

## 🛣️ Daftar Route

| URL | Method | Fungsi | Middleware |
|-----|--------|--------|------------|
| `/` | GET | Redirect ke login | - |
| `/login` | GET | Halaman login | guest |
| `/register` | GET | Halaman register | guest |
| `/forgot-password` | GET | Lupa password | guest |
| `/dashboard` | GET | Dashboard | auth |
| `/users` | GET | Daftar user | auth, role:Super-Admin |
| `/users/create` | GET | Form tambah user | auth, role:Super-Admin |
| `/users/{id}` | GET | Detail user | auth, role:Super-Admin |
| `/users/{id}/edit` | GET | Form edit user | auth, role:Super-Admin |
| `/roles` | GET | Daftar roles | auth, role:Super-Admin |
| `/roles/create` | GET | Form tambah role | auth, role:Super-Admin |

## 📖 Tutorial Penggunaan

### Menambah User Baru

1. Login sebagai admin
2. Klik menu **Users** di navigasi
3. Klik tombol **Create New User**
4. Isi form: Name, Email, Password, dan pilih Role
5. Klik **Submit**

### Menambah Role Baru

1. Login sebagai admin
2. Klik menu **Roles** di navigasi
3. Klik tombol **Create New Role**
4. Masukkan nama role
5. Pilih permissions yang diinginkan
6. Klik **Submit**

### Menambah Permission ke Role

1. Buka halaman **Roles**
2. Klik **Edit** pada role yang ingin diubah
3. Centang/uncentang permissions
4. Klik **Update**

## 🔐 Sistem Autentikasi

Aplikasi menggunakan Laravel Breeze dengan fitur:

- **Login** - Email & password
- **Register** - Pendaftaran user baru
- **Forgot Password** - Reset password via email
- **Remember Me** - Sesi login persisten

## 🎨 Customization

### Mengubah Tampilan

Layout utama ada di:
- `resources/views/layouts/app.blade.php` - Layout setelah login
- `resources/views/layouts/guest.blade.php` - Layout halaman publik

Aplikasi menggunakan **Tailwind CSS CDN**, jadi bisa langsung menggunakan class Tailwind tanpa compile.

### Menambah Menu Navigasi

Edit file `resources/views/layouts/navigation.blade.php`:

```php
<x-nav-link :href="route('nama-route')" :active="request()->routeIs('nama-route')">
    {{ __('Nama Menu') }}
</x-nav-link>
```

### Menambah Controller Baru

```bash
php artisan make:controller NamaController
```

### Menambah Model & Migration

```bash
php artisan make:model NamaModel -m
```

## 🧹 Perintah Artisan Berguna

```bash
# Bersihkan cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# List semua route
php artisan route:list

# Rollback migration
php artisan migrate:rollback

# Reset & seed ulang database
php artisan migrate:fresh --seed

# Tinker (REPL)
php artisan tinker
```

## 🐛 Troubleshooting

### Error "Permission denied"

```bash
chmod -R 775 storage bootstrap/cache
```

### Error "Class not found"

```bash
composer dump-autoload
```

### Error "View not found"

```bash
php artisan view:clear
```

### Error koneksi database

1. Pastikan MySQL berjalan
2. Cek kredensial di `.env`
3. Pastikan database sudah dibuat

## 📝 Lisensi

MIT License

