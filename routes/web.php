<?php

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

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Hanya user tanpa role yang dapat mengakses laman dashboard-no-role
Route::get('/dashboard-no-role', function () {
    if (auth()->user() && in_array(auth()->user()->role, ['ketua', 'sekretaris', 'bendahara', 'anggota'])) {
        return redirect('/dashboard');
    }
    return view('dashboard-no-role');
})->middleware(['auth'])->name('dashboard-no-role');

// Combine dashboard routes
Route::group(['middleware' => ['auth', 'role:ketua,sekretaris,bendahara,anggota']], function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

require __DIR__.'/auth.php';
