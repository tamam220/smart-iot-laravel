<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController; // <--- Pastikan Controller dipanggil
use App\Http\Controllers\DeviceController;    // <--- Controller Device
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController; // Jangan lupa import

Route::post('/device/create', [DashboardController::class, 'storeDevice'])->name('device.store');
Route::post('/datastream/create', [DashboardController::class, 'storeDatastream'])->name('datastream.store');
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('/', function () {
    return view('welcome');
});

// GROUP MIDDLEWARE (Harus Login Dulu)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Route untuk AJAX / Fitur IoT
    Route::post('/save-dashboard', [DashboardController::class, 'saveDashboard'])->name('dashboard.save');
    Route::post('/device/create', [DashboardController::class, 'storeDevice'])->name('device.store');
    Route::post('/datastream/create', [DashboardController::class, 'storeDatastream'])->name('datastream.store');

    // --- BAGIAN INI YANG HILANG (PROFILE ROUTES) ---
    // Tambahkan 3 baris ini agar menu Profile bisa jalan:
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); // <--- Ini sumber error kamu tadi
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';