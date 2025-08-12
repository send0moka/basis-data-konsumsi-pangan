<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

// Admin Routes 
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // User management - hanya untuk superadmin
    Route::middleware(['permission:view users'])->group(function () {
        Route::view('users', 'admin.users')->name('users');
    });
    
    // Kelompok management - admin dan superadmin bisa akses
    Route::middleware(['permission:view kelompok'])->group(function () {
        Route::view('kelompok', 'admin.kelompok')->name('kelompok');
    });
    
    // Komoditi management - admin dan superadmin bisa akses
    Route::middleware(['permission:view komoditi'])->group(function () {
        Route::view('komoditi', 'admin.komoditi')->name('komoditi');
    });
    
    // Transaksi NBM management - admin dan superadmin bisa akses
    Route::middleware(['permission:view transaksi_nbm'])->group(function () {
        Route::view('transaksi-nbm', 'admin.transaksi-nbm')->name('transaksi-nbm');
    });
});

require __DIR__.'/auth.php';
