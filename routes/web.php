<?php

use App\Http\Controllers\AutentikasiController;
use App\Http\Controllers\DasborController;
use App\Http\Controllers\Laporan\KinerjaCabangController;
use App\Http\Controllers\Laporan\PenjualanProdukController;
use App\Http\Controllers\Laporan\TransaksiPenjualanController;
use App\Http\Controllers\Master\CabangController;
use App\Http\Controllers\Master\PenggunaController;
use App\Http\Controllers\Master\ProdukController;
use App\Http\Controllers\Master\StokController;
use App\Http\Controllers\Master\TransaksiController;
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
    Route::get('/data', [DasborController::class, 'data'])->name('dasbor.data');

    Route::prefix('master')->group(function () {
        Route::name('master.')->group(function () {
            Route::middleware('cek-admin')->group(function () {
                Route::prefix('cabang')->group(function () {
                    Route::get('/', [CabangController::class, 'indeks'])->name('cabang');
                    Route::get('/lokasi/{uuid}', [CabangController::class, 'lokasi'])->whereUuid('uuid')->name('cabang.lokasi');
                    Route::get('/lokasi/{uuid}/data', [CabangController::class, 'dataLokasi'])->whereUuid('uuid')->name('cabang.lokasi.data');
                    Route::post('/lokasi/{uuid}', [CabangController::class, 'editLokasi'])->whereUuid('uuid')->name('cabang.lokasi.edit');
                    Route::get('/tambah', [CabangController::class, 'tambah'])->name('cabang.tambah');
                    Route::post('/tambah', [CabangController::class, 'prosesTambah'])->name('cabang.proses-tambah');
                    Route::get('/edit/{uuid}', [CabangController::class, 'edit'])->whereUuid('uuid')->name('cabang.edit');
                    Route::put('/edit/{uuid}', [CabangController::class, 'prosesEdit'])->whereUuid('uuid')->name('cabang.proses-edit');
                    Route::delete('/hapus/{uuid}', [CabangController::class, 'hapus'])->whereUuid('uuid')->name('cabang.hapus');
                });

                Route::prefix('produk')->group(function () {
                    Route::get('/', [ProdukController::class, 'indeks'])->name('produk');
                    Route::get('/tambah', [ProdukController::class, 'tambah'])->name('produk.tambah');
                    Route::post('/tambah', [ProdukController::class, 'prosesTambah'])->name('produk.proses-tambah');
                    Route::get('/edit/{uuid}', [ProdukController::class, 'edit'])->whereUuid('uuid')->name('produk.edit');
                    Route::put('/edit/{uuid}', [ProdukController::class, 'prosesEdit'])->whereUuid('uuid')->name('produk.proses-edit');
                    Route::delete('/hapus/{uuid}', [ProdukController::class, 'hapus'])->whereUuid('uuid')->name('produk.hapus');
                });

                Route::prefix('pengguna')->group(function () {
                    Route::get('/', [PenggunaController::class, 'indeks'])->name('pengguna');
                    Route::get('/tambah', [PenggunaController::class, 'tambah'])->name('pengguna.tambah');
                    Route::get('/tambah/data', [PenggunaController::class, 'dataTambah'])->name('pengguna.tambah.data');
                    Route::post('/tambah', [PenggunaController::class, 'prosesTambah'])->name('pengguna.proses-tambah');
                });
            });

            Route::middleware('cek-cabang')->group(function () {
                Route::prefix('stok')->group(function () {
                    Route::get('/', [StokController::class, 'indeks'])->name('stok');
                    Route::put('/', [StokController::class, 'edit'])->name('stok.edit');
                });

                Route::prefix('transaksi')->group(function () {
                    Route::get('/', [TransaksiController::class, 'indeks'])->name('transaksi');
                    Route::get('/data', [TransaksiController::class, 'data'])->name('transaksi.data');
                    Route::post('/', [TransaksiController::class, 'bayar'])->name('transaksi.bayar');
                });
            });
        });
    });

    Route::prefix('laporan')->group(function () {
        Route::name('laporan.')->group(function () {
            Route::prefix('transaksi-penjualan')->group(function () {
                Route::get('/', [TransaksiPenjualanController::class, 'indeks'])->name('transaksi-penjualan');
                Route::get('/ekspor', [TransaksiPenjualanController::class, 'ekspor'])->name('transaksi-penjualan.ekspor');
            });

            Route::middleware('cek-admin')->group(function () {
                Route::prefix('kinerja-cabang')->group(function () {
                    Route::get('/', [KinerjaCabangController::class, 'indeks'])->name('kinerja-cabang');
                    Route::get('/ekspor', [KinerjaCabangController::class, 'ekspor'])->name('kinerja-cabang.ekspor');
                });
            });

            Route::prefix('penjualan-produk')->group(function () {
                Route::get('/', [PenjualanProdukController::class, 'indeks'])->name('penjualan-produk');
                Route::get('/ekspor', [PenjualanProdukController::class, 'ekspor'])->name('penjualan-produk.ekspor');
            });
        });
    });
});
