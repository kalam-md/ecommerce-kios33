<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\BiodataController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\RegisterController;
use App\Models\Produk;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $produks = Produk::with('kategori')->latest()->get();
    return view('welcome', compact('produks'));
});
// autentikasi
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'index'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda')->middleware('auth');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('kategori', KategoriController::class);
    Route::resource('produk', ProdukController::class);
});

Route::middleware(['auth', 'role:admin,user'])->group(function () {
    Route::get('/profil', [BiodataController::class, 'index'])->name('profil');
    Route::post('/profil/update', [BiodataController::class, 'update'])->name('profil.update');
});
