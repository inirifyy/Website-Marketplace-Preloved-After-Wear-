<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Semua alamat halaman publik, autentikasi, penjual, dan admin.

// routes/web.php menentukan ketika pengguna membuka alamat tertentu, halaman atau fungsi mana yang dijalankan.

// URL	Fungsi
// /	= Beranda
// /products	=  Katalog produk
// /products/1	= Detail produk dengan ID 1
// /education	= Edukasi limbah tekstil
// /testimonials	= Daftar testimoni
// /login	= Login
// /register	= Registrasi
// /seller/products/create	= Formulir jual barang
// /seller/products	= Produk milik penjual
// /admin	= Dashboard admin