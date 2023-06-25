<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Repositories\Laporan\TransaksiPenjualanRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class TransaksiPenjualanController extends Controller
{
    private TransaksiPenjualanRepository $transaksiPenjualanRepository;

    public function __construct(TransaksiPenjualanRepository $transaksiPenjualanRepository)
    {
        $this->transaksiPenjualanRepository = $transaksiPenjualanRepository;
    }

    public function getSemua(Request $request): Collection
    {
        $pengguna = Auth::user();

        $level = $pengguna->{'level'};

        if ($level === 'Cabang') {
            $idPengguna = $pengguna->getAuthIdentifier();
        } else {
            $idPengguna = null;
        }

        $tanggalMulai = $request->query('tanggal-mulai');
        $tanggalAkhir = $request->query('tanggal-akhir');

        return $this->transaksiPenjualanRepository->cariSemua($idPengguna, $tanggalMulai, $tanggalAkhir);
    }

    public function indeks(Request $request): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $transaksi = $this->getSemua($request);

        return view('tampilan.laporan.transaksi-penjualan.indeks', [
            'transaksi' => $transaksi
        ]);
    }

    public function ekspor(Request $request): Response
    {
        $transaksi = $this->getSemua($request);

        $pdf = Pdf::loadView('tampilan.laporan.transaksi-penjualan.ekspor', [
            'transaksi' => $transaksi
        ]);

        return $pdf->stream();
    }
}
