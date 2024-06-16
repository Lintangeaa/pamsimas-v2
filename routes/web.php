<?php

use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/pelanggan', [PelangganController::class, 'getPelanggan'])->name('admin.pelanggan');
    Route::get('/admin/tambah-pelanggan', [PelangganController::class, 'getTambahPelanggan'])->name('tambah-pelanggan');
    Route::post('/admin/tambah-pelanggan', [PelangganController::class, 'tambahPelanggan'])->name('admin.tambah.pelanggan');
    Route::get('/admin/edit-pelanggan/{id}', [PelangganController::class, 'edit'])->name('admin.pelanggan.edit');
    Route::put('/admin/edit-pelanggan/{uuid}', [PelangganController::class, 'update'])->name('admin.pelanggan.update');
    Route::delete('/admin/pelanggan/{id}', [PelangganController::class, 'delete'])->name('admin.pelanggan.delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

