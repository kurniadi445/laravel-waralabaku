<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Repositories\Laporan\TransaksiPenjualanRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class TransaksiPenjualanController extends Controller
{
    private TransaksiPenjualanRepository $transaksiPenjualanRepository;

    public function __construct(TransaksiPenjualanRepository $transaksiPenjualanRepository)
    {
        $this->transaksiPenjualanRepository = $transaksiPenjualanRepository;
    }

    public function indeks(Request $request): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $tanggalMulai = $request->query('tanggal-mulai');
        $tanggalAkhir = $request->query('tanggal-akhir');

        $transaksi = $this->transaksiPenjualanRepository->cariSemua($tanggalMulai, $tanggalAkhir);

        return view('tampilan.laporan.transaksi-penjualan.indeks', [
            'transaksi' => $transaksi
        ]);
    }
}
