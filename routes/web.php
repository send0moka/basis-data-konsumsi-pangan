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

// Admin Routes (restrict user management strictly to superadmin)
Route::middleware(['auth', 'role:superadmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('users', 'admin.users')->name('users');
});

// Susenas Routes (accessible by both superadmin and admin)
Route::middleware(['auth', 'role:superadmin|admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('kelompok-bps', 'admin.kelompok-bps')->name('kelompok-bps');
    Route::view('komoditi-bps', 'admin.komoditi-bps')->name('komoditi-bps');
    Route::view('susenas', 'admin.susenas')->name('susenas');
});

require __DIR__.'/auth.php';
