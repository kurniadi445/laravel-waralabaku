<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Repositories\Laporan\PenjualanProdukRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

    public function ekspor(Request $request): Response
    {
        $urutanTerjual = $request->query('urutan-terjual');
        $cari = $request->query('cari');

        $penjualanProduk = $this->penjualanProdukRepository->cariSemua($urutanTerjual, $cari);

        $pdf = Pdf::loadView('tampilan.laporan.penjualan-produk.ekspor', [
            'penjualan_produk' => $penjualanProduk
        ]);

        return $pdf->stream();
    }
}
