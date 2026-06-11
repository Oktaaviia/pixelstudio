<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

// =============================================
// === HALAMAN PUBLIK ===
// =============================================
Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/layanan', [PageController::class, 'layanan'])->name('layanan');
Route::get('/layanan/search', [PageController::class, 'searchLayanan'])->name('layanan.search');
Route::get('/layanan/{id}', [PageController::class, 'detailLayanan'])->name('layanan.detail');
Route::get('/portofolio', [PageController::class, 'portofolio'])->name('portofolio');
Route::get('/portofolio/{id}', [PageController::class, 'detailPortofolio'])->name('portofolio.detail');

// =============================================
// === AUTENTIKASI ===
// =============================================
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::post('/login', [PageController::class, 'doLogin'])->name('login.post');
Route::get('/register', [PageController::class, 'register'])->name('register');
Route::post('/register', [PageController::class, 'submitRegister'])->name('register.post');
Route::get('/logout', [PageController::class, 'logout'])->name('logout');

// AJAX: Cek ketersediaan email saat register
Route::get('/api/cek-email', [PageController::class, 'cekEmail'])->name('api.cek.email');

// =============================================
// === AREA CUSTOMER (PERLU LOGIN) ===
// =============================================
Route::get('/pesanan', [PageController::class, 'pesanan'])->name('pesanan');
Route::get('/profile', [PageController::class, 'profile'])->name('profile');
Route::get('/order', [PageController::class, 'order'])->name('order');
Route::post('/order', [PageController::class, 'submitOrder'])->name('order.post');
Route::get('/order/sukses', [PageController::class, 'orderSukses'])->name('order.sukses');

// =============================================
// === AREA ADMIN ===
// =============================================
Route::get('/admin', [PageController::class, 'admin'])->name('admin');
Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
Route::post('/admin/update-status/{id}', [PageController::class, 'updateStatus'])->name('admin.updateStatus');

// Pengelolaan Konten (CRUD)
Route::get('/pengelolaan', [PageController::class, 'pengelolaan'])->name('pengelolaan');
Route::get('/admin/crud', [PageController::class, 'adminLayanan'])->name('admin.layanan');

// CRUD Layanan (Packages)
Route::post('/pengelolaan/layanan', [PageController::class, 'storeLayanan'])->name('layanan.store');
Route::put('/pengelolaan/layanan/{id}', [PageController::class, 'updateLayanan'])->name('layanan.update');
Route::delete('/pengelolaan/layanan/{id}', [PageController::class, 'destroyLayanan'])->name('layanan.destroy');

// CRUD Portofolio
Route::post('/pengelolaan/portofolio', [PageController::class, 'storePortofolio'])->name('portofolio.store');
Route::put('/pengelolaan/portofolio/{id}', [PageController::class, 'updatePortofolio'])->name('portofolio.update');
Route::delete('/pengelolaan/portofolio/{id}', [PageController::class, 'destroyPortofolio'])->name('portofolio.destroy');

// CRUD Paket (Pricing Plans)
Route::post('/pengelolaan/paket', [PageController::class, 'storePaket'])->name('paket.store');
Route::put('/pengelolaan/paket/{id}', [PageController::class, 'updatePaket'])->name('paket.update');
Route::delete('/pengelolaan/paket/{id}', [PageController::class, 'destroyPaket'])->name('paket.destroy');


// =============================================
// === TEMA ===
// =============================================
Route::post('/tema', [PageController::class, 'saveTema'])->name('tema.save');

// =============================================
// === DEBUG (Aktif hanya di mode lokal) ===
// =============================================
if (app()->environment('local')) {
    Route::get('/debug-session', function () {
        return response()->json([
            'username'     => session('username'),
            'role'         => session('role'),
            'nama_lengkap' => session('nama_lengkap'),
            'user_id'      => session('user_id'),
            'pref_theme'   => session('pref_theme'),
        ]);
    });
}