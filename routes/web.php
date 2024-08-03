<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PendaftaranAnggotaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Redirect root to login
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/unauthorized', function () {
    return view('unauthorized');
});

// Routes requiring authentication
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes for no_role users
    Route::middleware('no_role')->group(function () {
        Route::get('/welcome', [DashboardController::class, 'welcome'])->name('welcome');
        Route::get('/pendaftaran-anggota', [PendaftaranAnggotaController::class, 'showForm'])->name('pendaftaran-anggota.showForm');
        Route::patch('/pendaftaran-anggota', [PendaftaranAnggotaController::class, 'ajukan'])->name('pendaftaran-anggota.ajukan');
    });

    // Combine dashboard routes
    Route::middleware('role:ketua,sekretaris,bendahara,anggota')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    });

    // Routes for sekretaris
    Route::middleware('role:sekretaris')->group(function () {
        Route::get('/verifikasi-pendaftaran-anggota', [PendaftaranAnggotaController::class, 'showVerifikasi'])->name('verifikasi-pendaftaran');
        Route::patch('/verifikasi-pendaftaran-anggota/verifikasi/{id}', [PendaftaranAnggotaController::class, 'verifikasi'])->name('verifikasi-pendaftaran.verifikasi');
        Route::patch('/verifikasi-pendaftaran-anggota/tolak/{id}', [PendaftaranAnggotaController::class, 'tolak'])->name('verifikasi-pendaftaran.tolak');
    });
});

require __DIR__.'/auth.php';
