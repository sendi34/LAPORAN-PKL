<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AiDashboardController;

// Auth Controllers
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LokasiController;
use App\Http\Controllers\Admin\IndikatorController;
use App\Http\Controllers\Admin\ObservasiController;
use App\Http\Controllers\Admin\HasilUjiController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporan;

// Petugas Controllers
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboard;
use App\Http\Controllers\Petugas\ObservasiController as PetugasObservasi;
use App\Http\Controllers\Petugas\HasilUjiController as PetugasHasilUji;
use App\Http\Controllers\Petugas\LaporanController as PetugasLaporan;

// Profile Controller
use App\Http\Controllers\ProfileController;


/*
|--------------------------------------------------------------------------
| LOGIN / REGISTER / LOGOUT
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');


/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA — REDIRECT BERDASARKAN ROLE
|--------------------------------------------------------------------------
*/
Route::get('/', function () {

    if (!auth()->check()) {
        return redirect()->route('login');
    }

    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if (auth()->user()->role === 'petugas') {
        return redirect()->route('petugas.dashboard');
    }

    return redirect()->route('login');

})->name('home');


/*
|--------------------------------------------------------------------------
| ROUTE PROTEKSI AUTH
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    /*
    |--------------------------------------------------------------------------
    | ADMIN PANEL
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

            // ── AI ENDPOINTS ──
            Route::prefix('ai')->group(function () {
                Route::get('/forecast',    [AiDashboardController::class, 'forecast']);
                Route::get('/correlation', [AiDashboardController::class, 'correlation']);
                Route::get('/recommend',   [AiDashboardController::class, 'recommend']);
            });

            Route::resource('users', UserController::class);
            Route::resource('lokasi', LokasiController::class);
            Route::resource('indikator', IndikatorController::class);
            Route::resource('observasi', ObservasiController::class);
            Route::resource('hasiluji', HasilUjiController::class);

            Route::get('laporan/{jenis}', [AdminLaporan::class, 'show'])->name('laporan.show');
            Route::get('laporan/{jenis}/cetak', [AdminLaporan::class, 'cetak'])->name('laporan.cetak');
        });


    /*
    |--------------------------------------------------------------------------
    | PETUGAS PANEL
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:petugas'])
        ->prefix('petugas')
        ->name('petugas.')
        ->group(function () {

            Route::get('dashboard', [PetugasDashboard::class, 'index'])->name('dashboard');

            Route::resource('observasi', PetugasObservasi::class);
            Route::resource('hasiluji', PetugasHasilUji::class);
        });
});

Route::get('/test-gemini-key', function() {
    return config('services.gemini.key');
});
// Matikan route bawaan Breeze
// require __DIR__.'/auth.php';