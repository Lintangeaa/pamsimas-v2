<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagihanController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/admin/pelanggan', [PelangganController::class, 'getPelanggan'])->name('admin.pelanggan');
    Route::get('/admin/tambah-pelanggan', [PelangganController::class, 'getTambahPelanggan'])->name('tambah-pelanggan');
    Route::post('/admin/tambah-pelanggan', [PelangganController::class, 'tambahPelanggan'])->name('admin.tambah.pelanggan');
    Route::get('/admin/edit-pelanggan/{id}', [PelangganController::class, 'edit'])->name('admin.pelanggan.edit');
    Route::put('/admin/edit-pelanggan/{uuid}', [PelangganController::class, 'update'])->name('admin.pelanggan.update');
    Route::delete('/admin/pelanggan/{id}', [PelangganController::class, 'delete'])->name('admin.pelanggan.delete');

    // tagihan
    Route::get('/admin/tagihan', [TagihanController::class, 'index'])->name('admin.tagihan.index');
    Route::get('/admin/buat-tagihan', [TagihanController::class, 'create'])->name('admin.tagihan.create');
    Route::post('/admin/buat-tagihan', [TagihanController::class, 'store'])->name('admin.tagihan.store');
    Route::get('admin/edit-tagihan/{id}/edit', [TagihanController::class, 'edit'])->name('admin.tagihan.edit');
    Route::put('admin/edit-tagihan/{id}', [TagihanController::class, 'update'])->name('admin.tagihan.update');
    Route::delete('/admin/tagihan/{id}', [TagihanController::class, 'delete'])->name('admin.tagihan.delete');

    //pembayaran
    Route::get('/admin/pembayaran', [PembayaranController::class, 'index'])->name('admin.pembayaran.index');
    Route::get('/admin/pembayaran/{tagihan_id}', [PembayaranController::class, 'bayar'])->name('admin.pembayaran.bayar');


});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

