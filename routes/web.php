<?php


use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PelaksanaController;
use App\Http\Controllers\ProyekController;
// --- TAMBAHKAN CONTROLLER BARU ---
use App\Http\Controllers\Pelaksana\DashboardController;
use App\Http\Controllers\Pelaksana\ProyekSayaController;
use App\Http\Controllers\Pelaksana\TenagaKerjaController;
use App\Http\Controllers\Pelaksana\PembayaranController;
use App\Http\Controllers\DashboardController as MainDashboardController; // Ganti nama alias
// ---------------------------------
use Illuminate\Support\Facades\Route;
// ---------------------------------
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
    return view('welcome');
});

Route::get('/dashboard', MainDashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Route untuk CRUD Pelaksana
    Route::resource('pelaksana', PelaksanaController::class);
    Route::resource('proyek', ProyekController::class);
});

Route::middleware(['auth'])->prefix('pelaksana')->name('pelaksana.')->group(function () {
    // Dashboard Pelaksana
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route untuk Proyek yang dimiliki Pelaksana
    Route::get('proyek/{proyek}', [ProyekSayaController::class, 'show'])->name('proyek.show');

    // Nested Resource untuk Tenaga Kerja di dalam Proyek
    Route::resource('proyek.tenaga-kerja', TenagaKerjaController::class)->except(['index', 'show']);

    // Nested Resource untuk Pembayaran di dalam Proyek
    Route::resource('proyek.pembayaran', PembayaranController::class)->except(['index', 'show']);
});
