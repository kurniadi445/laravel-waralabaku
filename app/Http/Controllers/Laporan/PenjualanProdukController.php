<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Repositories\Laporan\PenjualanProdukRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PenjualanProdukController extends Controller
{
    private PenjualanProdukRepository $penjualanProdukRepository;

    public function __construct(PenjualanProdukRepository $penjualanProdukRepository)
    {
        $this->penjualanProdukRepository = $penjualanProdukRepository;
    }

    public function indeks(Request $request): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $urutanTerjual = $request->query('urutan-terjual');
        $cari = $request->query('cari');

        $penjualanProduk = $this->penjualanProdukRepository->cariSemua($urutanTerjual, $cari);

        return view('tampilan.laporan.penjualan-produk.indeks', [
            'penjualan_produk' => $penjualanProduk
        ]);
    }
}
