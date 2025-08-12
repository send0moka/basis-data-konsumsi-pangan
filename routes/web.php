<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Landing Page Routes
Route::get('/', function () {
    return view('homepage');
})->name('home');

// Ketersediaan Routes
Route::prefix('ketersediaan')->name('ketersediaan.')->group(function () {
    Route::get('konsep-metode', function () {
        return view('ketersediaan.konsep-metode');
    })->name('konsep-metode');
    
    Route::get('laporan-nbm', function () {
        return view('ketersediaan.laporan-nbm');
    })->name('laporan-nbm');
});

// Konsumsi Routes  
Route::prefix('konsumsi')->name('konsumsi.')->group(function () {
    Route::get('konsep-metode', function () {
        return view('konsumsi.konsep-metode');
    })->name('konsep-metode');
    
    Route::get('laporan-susenas', function () {
        return view('konsumsi.laporan-susenas');
    })->name('laporan-susenas');
    
    Route::get('per-kapita-seminggu', function () {
        return view('konsumsi.per-kapita-seminggu');
    })->name('per-kapita-seminggu');
    
    Route::get('per-kapita-setahun', function () {
        return view('konsumsi.per-kapita-setahun');
    })->name('per-kapita-setahun');
});

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

// Susenas Routes (accessible by both superadmin and admin)
Route::middleware(['auth', 'permission:view kelompokbps|view komoditibps|view susenas'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('kelompok-bps', 'admin.kelompok-bps')->name('kelompok-bps');
    Route::view('komoditi-bps', 'admin.komoditi-bps')->name('komoditi-bps');
    Route::view('susenas', 'admin.susenas')->name('susenas');
});

require __DIR__.'/auth.php';
