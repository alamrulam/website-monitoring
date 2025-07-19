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
use App\Http\Controllers\Pelaksana\ProgresController;

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
    Route::get('proyek/{proyek}/cetak-pdf', [ProyekController::class, 'cetakPdf'])->name('proyek.cetakPdf');
});

Route::middleware(['auth'])->prefix('pelaksana')->name('pelaksana.')->group(function () {
    // Dashboard Pelaksana
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route untuk Proyek yang dimiliki Pelaksana
    Route::get('proyek/{proyek}/{tab?}', [ProyekSayaController::class, 'show'])->name('proyek.show');

    // Nested Resource untuk Tenaga Kerja di dalam Proyek
    Route::resource('proyek.tenaga-kerja', TenagaKerjaController::class)->except(['index', 'show']);

    // Nested Resource untuk Pembayaran di dalam Proyek
    Route::resource('proyek.pembayaran', PembayaranController::class)->except(['index', 'show']);

    Route::get('proyek/{proyek}/cetak-pdf', [ProyekSayaController::class, 'cetakPdf'])->name('proyek.cetakPdf');
    Route::resource('proyek.tenaga-kerja', TenagaKerjaController::class)->except(['index', 'show']);
    Route::resource('proyek.pembayaran', PembayaranController::class)->except(['index', 'show']);

    Route::put('proyek/{proyek}/update-progres', [ProgresController::class, 'updateProgres'])->name('proyek.updateProgres');
    Route::post('proyek/{proyek}/upload-foto', [ProgresController::class, 'uploadFoto'])->name('proyek.uploadFoto');
    Route::delete('proyek/{proyek}/hapus-foto/{foto}', [ProgresController::class, 'hapusFoto'])->name('proyek.hapusFoto');
});
