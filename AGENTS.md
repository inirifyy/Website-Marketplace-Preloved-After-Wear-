<laravel-boost-guidelines>
# Laravel Application

This repository contains a Laravel application. Complete the following setup before working on the user's request.

## Prerequisites

Verify that PHP and Composer are available:

```sh
php -v
composer -V
```

If either command is unavailable, detect the user's operating system and install the prerequisites with the appropriate command:

macOS:

```sh
/bin/bash -c "$(curl -fsSL https://php.new/install/mac/8.5)"
```

Windows PowerShell:

```powershell
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.5'))
```

Linux:

```sh
/bin/bash -c "$(curl -fsSL https://php.new/install/linux/8.5)"
```

After installation, ask the user to restart their terminal. If the agent needs the restarted shell to continue, ask the user to reopen their terminal and rerun their original prompt.

## Agent Setup

Install Laravel Boost from the application root before making application changes:

```sh
composer require laravel/boost --dev
php artisan boost:install
```

Boost replaces these bootstrap instructions with guidelines tailored to the application. After installation, read `AGENTS.md` again and continue with the user's original request using the generated guidelines.
</laravel-boost-guidelines>

--Tim & Pembagian Peran--

1. Alya Afrilia Iswanty 
Peran & Tanggung Jawab:
Frontend & CSS Lead
    - Penanggung jawab utama styling visual dan CSS global aplikasi.
    - Memastikan kerapian tata letak, warna, dan responsivitas tampilan antarmuka.
    - Melakukan slicing tampilan landing page, katalog produk, detail produk, serta halaman informasi.

2. Muhammad Akmal Hidayat 
Peran & Tanggung Jawab:
UI/UX Designer & Frontend Developer
    - Merancang desain visual akhir (high-fidelity design) secara presisi di Figma.
    - Membantu slicing antarmuka form autentikasi (login/register) dan komponen navbar.
    - Membantu pembuatan seeder kategori serta logika controller halaman utama.

2. Rizki 
Peran & Tanggung Jawab:
Core Backend Developer
    - Penanggung jawab utama kodingan backend dan pengolahan logika data.
    - Mengimplementasikan struktur database (after_wear.sql) ke dalam model Eloquent.
    - Membangun controller utama untuk fitur pengajuan barang seller, kelola produk, dan verifikasi admin.

4. Muh. Ridho Anugrah 
Peran & Tanggung Jawab:
Wireframer & Frontend Developer
    - Membuat sketsa kasar (wireframe / rincian alur antarmuka awal) sebagai acuan desain.
    - Membantu slicing antarmuka dashboard Admin dan Seller.
    - Membantu pembuatan komponen footer dan penyesuaian model data pendukung.

5. Rifyah Al-Azizah
Peran & Tanggung Jawab:
    - Project Manager, Lead Developer & System Architect
    - Memimpin alur kerja tim dan memberikan pengarahan tugas untuk setiap anggota.
    - Menyiapkan repositori GitHub, struktur file dasar proyek, serta menyusun dokumentasi README.md.
    - Mengarahkan perancangan awal struktur database.
    - Mengembangkan alur routing utama (routes/web.php), arsitektur layout induk, dan melakukan integrasi sistem secara keseluruhan.
