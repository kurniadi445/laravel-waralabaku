<?php

use App\Http\Controllers\AutentikasiController;
use App\Http\Controllers\DasborController;
use App\Http\Controllers\Laporan\TransaksiPenjualanController;
use App\Http\Controllers\Master\ProdukController;
use App\Http\Controllers\Master\StokController;
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

Route::prefix('autentikasi')->group(function () {
    Route::name('autentikasi.')->group(function () {
        Route::get('/masuk', [AutentikasiController::class, 'masuk'])->name('masuk');
        Route::post('/masuk', [AutentikasiController::class, 'prosesMasuk'])->name('proses-masuk');
        Route::get('/keluar', [AutentikasiController::class, 'keluar'])->name('keluar');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/', [DasborController::class, 'indeks'])->name('dasbor');

    Route::prefix('master')->group(function () {
        Route::name('master.')->group(function () {
            Route::prefix('produk')->group(function () {
                Route::get('/', [ProdukController::class, 'indeks'])->name('produk');
                Route::get('/tambah', [ProdukController::class, 'tambah'])->name('produk.tambah');
                Route::post('/tambah', [ProdukController::class, 'prosesTambah'])->name('produk.proses-tambah');
                Route::get('/edit/{uuid}', [ProdukController::class, 'edit'])->whereUuid('uuid')->name('produk.edit');
                Route::put('/edit/{uuid}', [ProdukController::class, 'prosesEdit'])->whereUuid('uuid')->name('produk.proses-edit');
                Route::delete('/hapus/{uuid}', [ProdukController::class, 'hapus'])->whereUuid('uuid')->name('produk.hapus');
            });

            Route::prefix('stok')->group(function () {
                Route::get('/', [StokController::class, 'indeks'])->name('stok');
            });
        });
    });

    Route::prefix('laporan')->group(function () {
        Route::name('laporan.')->group(function () {
            Route::prefix('transaksi-penjualan')->group(function () {
                Route::get('/', [TransaksiPenjualanController::class, 'indeks'])->name('transaksi-penjualan');
                Route::get('/ekspor', [TransaksiPenjualanController::class, 'ekspor'])->name('transaksi-penjualan.ekspor');
            });
        });
    });
});
