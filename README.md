# Instalasi dan Menjalankan Project

## Prasyarat

Pastikan perangkat telah terpasang:

* PHP 8.1 atau lebih baru
* Composer
* MySQL / MariaDB
* Node.js
* NPM
* Git

Cek versi:

```bash
php -v
composer -V
node -v
npm -v
git --version
```

---

# Clone Repository

Clone project dari GitHub:

```bash
git clone https://github.com/username/modul-penilaian-360.git
```

Masuk ke folder project:

```bash
cd modul-penilaian-360
```

---

# Install Dependency Backend

Install seluruh dependency Laravel:

```bash
composer install
```

---

# Install Dependency Frontend

Install package JavaScript:

```bash
npm install
```

Compile asset:

```bash
npm run build
```

Untuk mode development:

```bash
npm run dev
```

---

# Konfigurasi Environment

Salin file environment:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

---

# Konfigurasi Database

Buat database baru:

```sql
CREATE DATABASE penilaian360;
```

Edit file `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=penilaian360
DB_USERNAME=root
DB_PASSWORD=
```

---

# Import Database Manual

Apabila menggunakan file SQL:

```bash
mysql -u root -p penilaian360 < database/penilaian360.sql
```
---

# Menjalankan Project

Jalankan Laravel:

```bash
php artisan serve
```

Akses melalui browser:

```text
http://127.0.0.1:8000
```

---

# Akun Demo

### Administrator

```text
Role : Admin
```

### User

Pilih user melalui dropdown sidebar untuk simulasi login pengguna.

---

# Build Production

Compile asset production:

```bash
npm run build
```

Optimasi cache Laravel:

```bash
php artisan optimize
```

---

# Membersihkan Cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

# Teknologi yang Digunakan

Backend:

* Laravel 
* PHP 

Frontend:

* Bootstrap 
* JavaScript
* jQuery
* AJAX

Database:

* MySQL

```
```
