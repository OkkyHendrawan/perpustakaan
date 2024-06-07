<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;

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

    //Route Login Admin dan disini saya hanya menggunakan hanya untuk Login Admin saja
    Route::get('/', [AuthController::class, 'login']);
    Route::post('login', [AuthController::class, 'AuthLogin'])->name('login');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');


    // Route grup untuk rute-rute yang memerlukan autentikasi admin
    Route::middleware('auth:web')->group(function () {

    // Route untuk halaman dashboard admin
    Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Route untuk CRUD Anggota
    Route::get('admin/anggota', [AnggotaController::class, 'index'])->name('admin.anggota.list');
    Route::get('admin/anggota/form_create', [AnggotaController::class, 'form_create'])->name('admin.anggota.form_create');
    Route::post('admin/anggota/proses_create', [AnggotaController::class, 'proses_create'])->name('admin.anggota.proses_create');
    Route::get('admin/anggota/{anggota_id}/edit', [AnggotaController::class, 'edit'])->name('admin.anggota.edit');
    Route::put('admin/anggota/{anggota_id}/update', [AnggotaController::class, 'update'])->name('admin.anggota.update');
    Route::post('admin/anggota/soft-delete/{anggota_id}', [AnggotaController::class, 'softDeleteAnggota'])->name('admin.anggota.softDeleteAnggota');
    Route::get('/anggota/search', [AnggotaController::class, 'search'])->name('anggota.search');

    // Route untuk CRUD Buku
    Route::get('admin/buku', [BukuController::class, 'index'])->name('admin.buku.list');
    Route::get('admin/buku/form_create', [BukuController::class, 'form_create'])->name('admin.buku.form_create');
    Route::post('admin/buku/proses_create', [BukuController::class, 'proses_create'])->name('admin.buku.proses_create');
    Route::get('admin/buku/{buku_id}/edit', [BukuController::class, 'edit'])->name('admin.buku.edit');
    Route::put('admin/buku/{buku_id}/update', [BukuController::class, 'update'])->name('admin.buku.update');
    Route::post('admin/buku/soft-delete/{buku_id}', [BukuController::class, 'softDeleteBuku'])->name('admin.buku.softDeleteBuku');
    Route::get('/buku/search', [BukuController::class, 'search'])->name('buku.search');

    // Route CRUD Pemninjaman
    Route::get('admin/peminjaman', [PeminjamanController::class, 'index'])->name('admin.peminjaman.list');
    Route::get('admin/peminjaman/form_create', [PeminjamanController::class, 'form_create'])->name('admin.peminjaman.form_create');
    Route::post('admin/peminjaman/proses_create', [PeminjamanController::class, 'proses_create'])->name('admin.peminjaman.proses_create');
    Route::get('admin/peminjaman/{peminjaman_id}/edit', [PeminjamanController::class, 'edit'])->name('admin.peminjaman.edit');
    Route::put('admin/peminjaman/{peminjaman_id}/update', [PeminjamanController::class, 'update'])->name('admin.peminjaman.update');
    Route::post('admin/peminjaman/soft-delete/{peminjaman_id}', [PeminjamanController::class, 'softDeletePeminjaman'])->name('admin.peminjaman.softDeletePeminjaman');
    Route::get('/peminjaman/search', [PeminjamanController::class, 'search'])->name('peminjaman.search');

    // Route untuk menampilkan laporan dengan method GET dan Cetak Laporan dengan Method POST
    Route::get('admin/laporan', [LaporanController::class, 'index'])->name('admin.laporan.list');
    Route::match(['get', 'post'], 'admin/laporan/cetak', [LaporanController::class, 'cetak'])->name('admin.laporan.cetak');

});
