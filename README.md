Kelompok 4 
Anggota : 
- Alya Afrilia Iswanty
- Muhammad Akmal Hidayat
- Muhammad Rizky Isafachrie
- Muh. Ridho Anugrah
- Rifyah al-azizah()

------- AfterWear - Platform E-Commerce Preloved Fashion --------

AfterWear adalah platform e-commerce berbasis web yang berfokus pada penjualan pakaian bekas berkualitas (preloved/thrift). Aplikasi ini dirancang untuk mendukung gaya hidup sustainable fashion dengan memberikan wadah yang aman dan terstruktur bagi pengguna yang ingin menjual maupun membeli pakaian preloved.

--Fitur Utama--
-Public & Pembeli:
    -Katalog produk interaktif dengan filter kategori dan pencarian.
    -Halaman detail produk lengkap beserta galeri foto.
    -Artikel edukasi mengenai sustainable fashion dan informasi tentang AfterWear.
-Penjual (Seller):
    -Dashboard khusus penjual untuk memantau status barang.
    -Formulir pengajuan barang preloved (product submission) lengkap dengan pengunggahan foto.
    -Manajemen produk yang dijual.
-Administrator:
    -Dashboard panel admin untuk peninjauan barang masuk.
    -Fitur verifikasi (persetujuan atau penolakan) terhadap barang yang diajukan seller sebelum tampil di katalog publik.
    -Pengelolaan data kategori pakaian.

--Teknologi yang Digunakan--
Framework: Laravel
Templating Engine: Blade
Styling: CSS3 / Bootstrap
Database: MySQL

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Website-Marketplace-Preloved-After-Wear-
Pengembangan Website Marketplace Preloved ‘After Wear’ sebagai Platform Jual Beli Pakaian Bekas Layak Pakai

*jgn lupa sebelum ketik apa apa diterminal, masuk dulu ke folder kalian

1. Buat database MySQL. Jalankan query ini:

CREATE DATABASE IF NOT EXISTS after_wear
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE after_wear;

2. Hubungkan Laravel ke database
Buka file .env di VS Code dan sesuaikan konfigurasi berikut:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=after_wear
DB_USERNAME=root
DB_PASSWORD=

3. Periksa migration yang sudah tersedia
Sebelum membuat tabel dengan SQL manual, kita periksa dulu migration Laravel agar tidak membuat tabel ganda.
Buka terminal VS Code pada folder utama proyek After Wear, lalu jalankan:

php artisan migrate:status

Perintah ini menampilkan daftar migration dan statusnya.
- Jika ada migration berstatus Pending, berarti migration tersebut belum dijalankan.
- Jika sudah Ran, berarti migration tersebut sudah dijalankan.
- Jika muncul error koneksi, kita perlu memeriksa konfigurasi .env dan status MySQL.

4. Jalankan migration Laravel
Jika konfigurasi database sudah benar, jalankan:

php artisan config:clear
php artisan migrate

Laravel akan membuat tabel berdasarkan file migration yang tersedia di proyekmu.
Jangan jalankan php artisan migrate:fresh, ya, karena perintah itu dapat menghapus tabel dan data yang sudah ada.
5. Periksa hasilnya
Di phpMyAdmin atau DBeaver, buka database after_wear. Untuk melihat daftar tabel melalui SQL, jalankan:


USE after_wear;
SHOW TABLES;
Untuk melihat struktur tabel tertentu:
DESCRIBE migrations;

Query terakhir hanya berhasil jika tabel migrations sudah dibuat oleh Laravel.

6. Query tabel utama After Wear
Untuk proyek kita, nantinya database direncanakan mempunyai tabel berikut: //



/isi struktur tabel database

USE after_wear;

-- 1. Akun pengguna, penjual, dan admin
CREATE TABLE IF NOT EXISTS users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('buyer', 'seller', 'admin') NOT NULL DEFAULT 'buyer',
    phone VARCHAR(30) NULL,
    address TEXT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB;

*kalo tabel users sdh ada pake ini:

DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('buyer', 'seller', 'admin') NOT NULL DEFAULT 'buyer',
    phone VARCHAR(30) NULL,
    address TEXT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB;

or tanpa menghapus tabel

ALTER TABLE users 
ADD COLUMN role ENUM('buyer', 'seller', 'admin') NOT NULL DEFAULT 'buyer' AFTER password,
ADD COLUMN phone VARCHAR(30) NULL AFTER role,
ADD COLUMN address TEXT NULL AFTER phone;

-- 2. Kategori produk
CREATE TABLE IF NOT EXISTS categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(120) NOT NULL UNIQUE,
    description TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB;

*jika sdh ada

DROP TABLE IF EXISTS categories;

CREATE TABLE categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(120) NOT NULL UNIQUE,
    description TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB;

or tanpa hapus

ALTER TABLE categories 
ADD COLUMN slug VARCHAR(120) NOT NULL UNIQUE AFTER name,
ADD COLUMN description TEXT NULL AFTER slug;

-- 3. Produk preloved
CREATE TABLE IF NOT EXISTS products (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    seller_id BIGINT UNSIGNED NOT NULL,
    category_id BIGINT UNSIGNED NULL,
    name VARCHAR(200) NOT NULL,
    slug VARCHAR(220) NOT NULL UNIQUE,
    description TEXT NOT NULL,
    price DECIMAL(12,2) NOT NULL DEFAULT 0,
    item_condition VARCHAR(100) NULL,
    material VARCHAR(100) NULL,
    usage_duration VARCHAR(100) NULL,
    flaws TEXT NULL,
    location VARCHAR(255) NULL,
    status ENUM('ready', 'sold_out') NOT NULL DEFAULT 'ready',
    approval_status ENUM('pending', 'approved', 'rejected')
        NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_products_seller
        FOREIGN KEY (seller_id) REFERENCES users(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_products_category
        FOREIGN KEY (category_id) REFERENCES categories(id)
        ON DELETE SET NULL
) ENGINE=InnoDB;

*jika sdh ada

DROP TABLE IF EXISTS products;

CREATE TABLE products (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    seller_id BIGINT UNSIGNED NOT NULL,
    category_id BIGINT UNSIGNED NULL,
    name VARCHAR(200) NOT NULL,
    slug VARCHAR(220) NOT NULL UNIQUE,
    description TEXT NOT NULL,
    price DECIMAL(12,2) NOT NULL DEFAULT 0,
    item_condition VARCHAR(100) NULL,
    material VARCHAR(100) NULL,
    usage_duration VARCHAR(100) NULL,
    flaws TEXT NULL,
    location VARCHAR(255) NULL,
    status ENUM('ready', 'sold_out') NOT NULL DEFAULT 'ready',
    approval_status ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_products_seller
        FOREIGN KEY (seller_id) REFERENCES users(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_products_category
        FOREIGN KEY (category_id) REFERENCES categories(id)
        ON DELETE SET NULL
) ENGINE=InnoDB;

-- 4. Foto dan video produk
CREATE TABLE IF NOT EXISTS product_media (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id BIGINT UNSIGNED NOT NULL,
    media_type ENUM('image', 'video') NOT NULL DEFAULT 'image',
    file_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_media_product
        FOREIGN KEY (product_id) REFERENCES products(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- 5. Rating dan ulasan
CREATE TABLE IF NOT EXISTS reviews (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id BIGINT UNSIGNED NOT NULL,
    reviewer_id BIGINT UNSIGNED NOT NULL,
    rating TINYINT UNSIGNED NOT NULL,
    comment TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT chk_reviews_rating CHECK (rating BETWEEN 1 AND 5),
    CONSTRAINT fk_reviews_product
        FOREIGN KEY (product_id) REFERENCES products(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_reviews_reviewer
        FOREIGN KEY (reviewer_id) REFERENCES users(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- 6. Pengajuan produk dari penjual
CREATE TABLE IF NOT EXISTS product_submissions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    seller_id BIGINT UNSIGNED NOT NULL,
    category_id BIGINT UNSIGNED NULL,
    name VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(12,2) NOT NULL DEFAULT 0,
    item_condition VARCHAR(100) NULL,
    material VARCHAR(100) NULL,
    usage_duration VARCHAR(100) NULL,
    flaws TEXT NULL,
    location VARCHAR(255) NULL,
    contact_whatsapp VARCHAR(30) NULL,
    submission_status ENUM('pending', 'approved', 'rejected')
        NOT NULL DEFAULT 'pending',
    admin_note TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_submissions_seller
        FOREIGN KEY (seller_id) REFERENCES users(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_submissions_category
        FOREIGN KEY (category_id) REFERENCES categories(id)
        ON DELETE SET NULL
) ENGINE=InnoDB;

-- 7. Konten beranda dan edukasi
CREATE TABLE IF NOT EXISTS site_contents (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    content_key VARCHAR(100) NOT NULL UNIQUE,
    title VARCHAR(255) NULL,
    body TEXT NULL,
    image_path VARCHAR(255) NULL,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB;

-- 8. Data awal kategori
INSERT IGNORE INTO categories (name, slug, description, created_at, updated_at)
VALUES
('Pakaian', 'pakaian', 'Kategori pakaian preloved dan fashion', NOW(), NOW()),
('Barang Elektronik', 'barang-elektronik', 'Kategori gadget dan elektronik', NOW(), NOW()),
('Perabot', 'perabot', 'Kategori perabotan rumah dan furnitur', NOW(), NOW()),
('Skincare', 'skincare', 'Kategori perawatan kulit dan kecantikan', NOW(), NOW()),
('Buku', 'buku', 'Kategori buku, novel, dan bacaan', NOW(), NOW()),
('Lainnya', 'lainnya', 'Kategori barang lainnya', NOW(), NOW());

-- Periksa tabel yang berhasil dibuat
SHOW TABLES;

