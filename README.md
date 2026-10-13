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
Untuk proyek kita, nantinya database direncanakan mempunyai tabel berikut:
