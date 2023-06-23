<?php

use App\Http\Controllers\AutentikasiController;
use App\Http\Controllers\DasborController;
use App\Http\Controllers\Laporan\TransaksiPenjualanController;
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

    Route::prefix('laporan')->group(function () {
        Route::name('laporan.')->group(function () {
            Route::prefix('transaksi-penjualan')->group(function () {
                Route::get('/', [TransaksiPenjualanController::class, 'indeks'])->name('transaksi-penjualan');
                Route::get('/ekspor', [TransaksiPenjualanController::class, 'ekspor'])->name('transaksi-penjualan.ekspor');
            });
        });
    });
});
