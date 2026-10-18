
// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

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

<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Seller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routing After Wear (Marketplace Preloved)
|--------------------------------------------------------------------------
| File ini hanya menentukan "alamat URL -> controller".
| Logika bisnis (validasi, simpan data, upload file) ada di controller.
|
| Middleware yang dipakai:
|   auth        -> bawaan Laravel, harus login
|   guest       -> bawaan Laravel, hanya untuk yang belum login
|   role:...    -> middleware buatan sendiri (lihat daftar dependensi),
|                  membatasi akses berdasarkan kolom users.role
|                  (buyer / seller / admin)
*/

// ---------------------------------------------------------------------
// 1. HALAMAN PUBLIK (tanpa login)
// ---------------------------------------------------------------------
// Pencarian dan filter kategori memakai query string pada katalog,
// contoh: /products?q=kemeja&category=atasan (diproses di ProductController@index)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/education', [HomeController::class, 'education'])->name('education');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/testimonials', [HomeController::class, 'testimonials'])->name('testimonials');

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

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ---------------------------------------------------------------------
// 3. PEMBELI (role: buyer)
// ---------------------------------------------------------------------
// Aturan ulasan (misalnya satu ulasan per produk) dicek di ReviewController.
Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])
    ->middleware(['auth', 'role:buyer'])
    ->name('products.reviews.store');

// ---------------------------------------------------------------------
// 4. PENJUAL (role: seller)
// ---------------------------------------------------------------------
Route::middleware(['auth', 'role:seller'])
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
// 5. ADMIN (role: admin)
// ---------------------------------------------------------------------
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard admin: /admin
        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

        // CRUD produk dan kategori (tanpa halaman show; detail produk ada di sisi publik)
        Route::resource('products', Admin\ProductController::class)->except('show');
        Route::resource('categories', Admin\CategoryController::class)->except('show');

        // Pengajuan produk dari penjual: daftar, setujui, tolak
        Route::get('/submissions', [Admin\ProductSubmissionController::class, 'index'])
            ->name('submissions.index');
        Route::patch('/submissions/{submission}/approve', [Admin\ProductSubmissionController::class, 'approve'])
            ->name('submissions.approve');
        Route::patch('/submissions/{submission}/reject', [Admin\ProductSubmissionController::class, 'reject'])
            ->name('submissions.reject');
    });