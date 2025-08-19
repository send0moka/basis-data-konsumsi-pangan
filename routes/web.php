<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Landing Page Routes
Route::get('/', function () {
    return view('homepage');
})->name('home');

// Admin Panel Selection Route - setelah login
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.panel-selection');
    })->name('admin.panel-selection');
});

// Ketersediaan Routes
Route::prefix('ketersediaan')->name('ketersediaan.')->group(function () {
    Route::get('konsep-metode', function () {
        return view('ketersediaan.konsep-metode');
    })->name('konsep-metode');
    
    Route::get('laporan-nbm', function () {
        return view('ketersediaan.laporan-nbm');
    })->name('laporan-nbm');
    
    Route::get('konsep-transaksi-nbm', function () {
        return view('ketersediaan.konsep-transaksi-nbm');
    })->name('konsep-transaksi-nbm');
});

// Konsumsi Routes  
Route::prefix('konsumsi')->name('konsumsi.')->group(function () {
    Route::get('konsep-metode', function () {
        return view('konsumsi.konsep-metode');
    })->name('konsep-metode');
    
    Route::get('konsep-transaksi-susenas', function () {
        return view('konsumsi.konsep-transaksi-susenas');
    })->name('konsep-transaksi-susenas');
    
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

Route::view('admin/konsumsi-pangan/dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

// Admin Routes 
Route::middleware(['auth'])->prefix('admin/konsumsi-pangan')->name('admin.')->group(function () {
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

// Panel B Routes
Route::middleware(['auth'])->prefix('admin/panel-b')->name('admin.panel-b.')->group(function () {
    Route::get('/', function () {
        return view('admin.panel-b.dashboard');
    })->name('dashboard');
    
    Route::view('data', 'admin.panel-b.data')->name('data');
    Route::view('reports', 'admin.panel-b.reports')->name('reports');
});

// Panel C Routes
Route::middleware(['auth'])->prefix('admin/panel-c')->name('admin.panel-c.')->group(function () {
    Route::get('/', function () {
        return view('admin.panel-c.dashboard');
    })->name('dashboard');
    
    Route::view('analytics', 'admin.panel-c.analytics')->name('analytics');
    Route::view('settings', 'admin.panel-c.settings')->name('settings');
});

// Panel D Routes
Route::middleware(['auth'])->prefix('admin/panel-d')->name('admin.panel-d.')->group(function () {
    Route::get('/', function () {
        return view('admin.panel-d.dashboard');
    })->name('dashboard');
    
    Route::view('monitoring', 'admin.panel-d.monitoring')->name('monitoring');
    Route::view('alerts', 'admin.panel-d.alerts')->name('alerts');
});

// Panel E Routes
Route::middleware(['auth'])->prefix('admin/panel-e')->name('admin.panel-e.')->group(function () {
    Route::get('/', function () {
        return view('admin.panel-e.dashboard');
    })->name('dashboard');
    
    Route::view('system', 'admin.panel-e.system')->name('system');
    Route::view('logs', 'admin.panel-e.logs')->name('logs');
});

// Susenas Routes (accessible by both superadmin and admin)
Route::middleware(['auth', 'permission:view kelompokbps|view komoditibps|view susenas'])->prefix('admin/konsumsi-pangan')->name('admin.')->group(function () {
    Route::view('kelompok-bps', 'admin.kelompok-bps')->name('kelompok-bps');
    Route::view('komoditi-bps', 'admin.komoditi-bps')->name('komoditi-bps');
    Route::view('susenas', 'admin.susenas')->name('susenas');
});

// NBM Prediction Routes
Route::middleware(['auth'])->prefix('admin/konsumsi-pangan')->name('admin.')->group(function () {
    Route::get('prediksi-nbm', function () {
        return view('prediksi.index');
    })->name('prediksi-nbm');
    
    Route::get('prediksi-nbm/api/health', [App\Http\Controllers\NBMPredictionController::class, 'health'])->name('prediksi-nbm.api.health');
    Route::post('prediksi-nbm/api/predict', [App\Http\Controllers\NBMPredictionController::class, 'predict'])->name('prediksi-nbm.api.predict');
    Route::get('prediksi-nbm/api/stats', [App\Http\Controllers\NBMPredictionController::class, 'modelStats'])->name('prediksi-nbm.api.stats');
    
    // Concept pages
    Route::get('konsep-transaksi-nbm', function () {
        return view('ketersediaan.konsep-transaksi-nbm');
    })->name('konsep-transaksi-nbm');
    
    Route::get('konsep-transaksi-susenas', function () {
        return view('konsumsi.konsep-transaksi-susenas');
    })->name('konsep-transaksi-susenas');
});

require __DIR__.'/auth.php';