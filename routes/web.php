<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PhoneVerificationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Seller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routing After Wear (Marketplace Preloved)
|--------------------------------------------------------------------------
| File ini hanya menentukan "alamat URL -> controller / view".
| Logika bisnis (validasi, simpan data, upload file) ada di controller.
|
| Catatan: "Admin" dan "Seller" di bawah adalah nama folder controller
| (App\Http\Controllers\Admin dan App\Http\Controllers\Seller), jadi
| Admin\DashboardController berarti App\Http\Controllers\Admin\DashboardController.
|
| Rute yang memakai controller akan error ("Target class ... does not exist"
| atau "Method ... does not exist") sampai controller itu diisi anggota
| kelompok yang bertugas. Itu bukan kesalahan file ini.
*/

/*
|--------------------------------------------------------------------------
| Middleware akses
|--------------------------------------------------------------------------
| 'role' (RoleMiddleware) dan 'phone.verified' (EnsurePhoneIsVerified) sudah
| terdaftar di bootstrap/app.php.
|
|  - buyer  : harus login, berperan buyer, nomor HP terverifikasi
|  - seller : harus login, berperan seller, nomor HP terverifikasi
|  - admin  : harus login dan berperan admin (admin tidak perlu verifikasi HP)
|
| Email TIDAK perlu diverifikasi; yang diverifikasi adalah nomor HP (OTP).
*/
$buyerAccess = ['auth', 'role:buyer', 'phone.verified'];
$sellerAccess = ['auth', 'role:seller', 'phone.verified'];
$adminAccess = ['auth', 'role:admin'];

// ---------------------------------------------------------------------
// 1. HALAMAN PUBLIK (tanpa login)
// ---------------------------------------------------------------------
// Pencarian dan filter kategori memakai query string pada katalog,
// contoh: /products?q=kemeja&category=atasan (diproses di ProductController@index)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/education', [HomeController::class, 'education'])->name('education');
Route::get('/testimonials', [HomeController::class, 'testimonials'])->name('testimonials');

// About: halaman statis, langsung memakai view pages/about.blade.php
// sehingga bisa tampil tanpa menunggu HomeController selesai.
// Jika tim ingin memindahkannya ke HomeController@about, ganti baris ini dengan:
//     Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::view('/about', 'pages.about')->name('about');

// ---------------------------------------------------------------------
// 2. AUTENTIKASI
// ---------------------------------------------------------------------
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1') // maksimal 5 percobaan per menit
        ->name('login.store');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

// Pintasan: /admin/login membuka halaman login dengan tab "Admin" terpilih.
Route::get('/admin/login', fn () => redirect()->route('login', ['as' => 'admin']))
    ->middleware('guest')
    ->name('admin.login');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Verifikasi nomor HP (OTP). Hanya perlu login, belum perlu verified.
Route::middleware('auth')->prefix('phone')->name('phone.verification.')->group(function () {
    Route::get('/verify', [PhoneVerificationController::class, 'notice'])->name('notice');
    Route::post('/verify', [PhoneVerificationController::class, 'verify'])
        ->middleware('throttle:10,1')
        ->name('verify');
    Route::post('/resend', [PhoneVerificationController::class, 'resend'])
        ->middleware('throttle:3,1')
        ->name('resend');
});

// ---------------------------------------------------------------------
// 3. PROFIL PENGGUNA (semua role yang sudah login)
// ---------------------------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Pembeli yang ingin berjualan
    Route::post('/profile/become-seller', [ProfileController::class, 'becomeSeller'])->name('profile.become-seller');
});

// ---------------------------------------------------------------------
// 4. PEMBELI (role: buyer)
// ---------------------------------------------------------------------
// Aturan ulasan (misalnya satu ulasan per produk) dicek di ReviewController.
Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])
    ->middleware($buyerAccess)
    ->name('products.reviews.store');

// ---------------------------------------------------------------------
// 5. PENJUAL (role: seller)
// ---------------------------------------------------------------------
Route::middleware($sellerAccess)
    ->prefix('seller')
    ->name('seller.')
    ->group(function () {
        // Dashboard penjual: /seller
        Route::get('/', [Seller\DashboardController::class, 'index'])->name('dashboard');

        // Daftar produk milik penjual + ubah status ready / sold_out
        Route::get('/products', [Seller\MyProductController::class, 'index'])->name('products.index');
        Route::patch('/products/{product}/status', [Seller\MyProductController::class, 'updateStatus'])
            ->name('products.status');

        // Form pengajuan produk dan penyimpanannya
        Route::get('/submissions/create', [Seller\ProductSubmissionController::class, 'create'])
            ->name('submissions.create');
        Route::post('/submissions', [Seller\ProductSubmissionController::class, 'store'])
            ->name('submissions.store');
    });

// ---------------------------------------------------------------------
// 6. ADMIN (role: admin)
// ---------------------------------------------------------------------
Route::middleware($adminAccess)
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard admin: /admin
        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

        // CRUD produk dan kategori (tanpa halaman show; detail produk ada di sisi publik).
        // Masing-masing menghasilkan: index, create, store, edit, update, destroy.
        // Controllernya harus punya keenam method itu.
        Route::resource('products', Admin\ProductController::class)->except('show');
        Route::resource('categories', Admin\CategoryController::class)->except('show');

        // Pengajuan produk dari penjual: daftar, setujui, tolak
        Route::get('/submissions', [Admin\ProductSubmissionController::class, 'index'])
            ->name('submissions.index');
        Route::patch('/submissions/{submission}/approve', [Admin\ProductSubmissionController::class, 'approve'])
            ->name('submissions.approve');
        Route::patch('/submissions/{submission}/reject', [Admin\ProductSubmissionController::class, 'reject'])
            ->name('submissions.reject');

        // Moderasi ulasan: daftar dan hapus.
        // Memakai AdminReviewController (file terbaru). Admin\ReviewController
        // lama juga masih ada dan kosong; tim perlu memilih salah satu.
        Route::get('/reviews', [Admin\AdminReviewController::class, 'index'])->name('reviews.index');
        Route::delete('/reviews/{review}', [Admin\AdminReviewController::class, 'destroy'])->name('reviews.destroy');

        // Konten website (slide beranda, edukasi, testimoni) -> SiteContentController.
        // Admin\ContentController lama kosong dan tidak dipakai.
        // View: admin/contents (index, create, edit, _form) sudah ada.
        Route::resource('contents', Admin\SiteContentController::class)->except('show');
    });