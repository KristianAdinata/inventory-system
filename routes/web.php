<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController; // Tambahkan ini jika Anda membuat Controller khusus Dashboard

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Semua route utama Sistem Inventori Barang ada di sini.
|--------------------------------------------------------------------------
*/

// Landing Page (public)
Route::get('/', function () {
    return view('home'); // Pastikan file resources/views/home.blade.php ada
})->name('home');

// Auth routes (dibuat otomatis oleh Breeze)
require __DIR__ . '/auth.php';

// -----------------------------------------------------------
// Route untuk User Biasa dan Admin (Shared Routes)
// -----------------------------------------------------------
Route::middleware(['auth'])->group(function () {

    // Dashboard default (Mengarahkan ke halaman yang sesuai)
    Route::get('/dashboard', function () {
        // Logika sederhana: jika Admin, redirect ke route Admin (misal: products.index),
        // jika User biasa, redirect ke route User (misal: profile.edit)
        if (auth()->user()->role == 'admin') {
            return redirect()->route('products.index');
        }
        return redirect()->route('profile.edit');
    })->name('dashboard');

    // Profil Pengguna (upload foto profil) - Diakses oleh semua yang login
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});


// -----------------------------------------------------------
// Route untuk Admin (Otorisasi: is_admin)
// -----------------------------------------------------------
Route::middleware(['auth', 'is_admin'])->group(function () {
    
    // CRUD Produk
    Route::resource('products', ProductController::class);

    // CRUD Kategori
    Route::resource('categories', CategoryController::class);

    //  FITUR EXPORT DATA (Step 14)
    Route::get('products/export/excel', [ProductController::class, 'exportExcel'])
         ->name('products.export.excel');

    // Manajemen User (CRUD user oleh Admin)
    Route::resource('admin/users', UserController::class)->names('admin.users');

});