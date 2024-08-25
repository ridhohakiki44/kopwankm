<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\PendaftaranAnggotaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SavingController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
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

        Route::get('/savings', [SavingController::class, 'index'])->name('savings.index');

        Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');

        Route::get('/installments', [InstallmentController::class, 'index'])->name('installments.index');

        Route::get('/users', [UserController::class, 'index'])->name('users.index');

        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
        Route::post('/transactions/print', [TransactionController::class, 'print'])->name('transactions.print');
    });

    // Routes for sekretaris
    Route::middleware('role:sekretaris')->group(function () {
        Route::get('/verifikasi-pendaftaran-anggota', [PendaftaranAnggotaController::class, 'showVerifikasi'])->name('verifikasi-pendaftaran');
        Route::patch('/verifikasi-pendaftaran-anggota/verifikasi/{id}', [PendaftaranAnggotaController::class, 'verifikasi'])->name('verifikasi-pendaftaran.verifikasi');
        Route::patch('/verifikasi-pendaftaran-anggota/tolak/{id}', [PendaftaranAnggotaController::class, 'tolak'])->name('verifikasi-pendaftaran.tolak');
        
        Route::get('/savings/create-by-sekretaris', [SavingController::class, 'createBySekretaris'])->name('savings.createBySekretaris');
        Route::post('/savings/store-by-sekretaris', [SavingController::class, 'storeBySekretaris'])->name('savings.storeBySekretaris');
        Route::get('/get-wajib-savings-amount/{userId}', [SavingController::class, 'getWajibSavingsAmount']);

        Route::post('/transactions/set-balance', [TransactionController::class, 'setBalance'])->name('transactions.set-balance');
        Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
        Route::post('/transactions/store', [TransactionController::class, 'store'])->name('transactions.store');
    });
    
    Route::middleware('role:ketua')->group(function () {
        Route::get('/loans/verifikasi', [LoanController::class, 'showVerificationPage'])->name('loans.verification.page');
        Route::post('/loans/verifikasi/setujui/{id}', [LoanController::class, 'verifySetujui'])->name('loans.setujui');
        Route::post('/loans/verifikasi/tolak/{id}', [LoanController::class, 'verifyTolak'])->name('loans.tolak');
    });

    Route::middleware('role:bendahara')->group(function () {
        Route::get('/loans/edit', [LoanController::class, 'showEditPage'])->name('loans.edit.page');
        Route::post('/loans/edit/{id}', [LoanController::class, 'edit'])->name('loans.edit');
    });

    Route::middleware(['role:anggota'])->group(function () {
        Route::post('/savings', [SavingController::class, 'store'])->name('savings.store');
        Route::get('/get-wajib-savings-amount', [SavingController::class, 'getWajibSavingsAmount']);
        
        Route::get('/loans/ajukan', [LoanController::class, 'create'])->name('loans.create');
        Route::post('/loans', [LoanController::class, 'ajukan'])->name('loans.ajukan');
        
        Route::get('/payment', [MidtransController::class, 'showPaymentPage'])->name('payments.index');
        Route::post('/payment/process', [MidtransController::class, 'processPayment'])->name('payments.process');
    });

});

Route::post('/midtrans/callback', [MidtransController::class, 'handleCallback']);

require __DIR__.'/auth.php';
