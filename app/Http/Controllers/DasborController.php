<?php

namespace App\Http\Controllers;

use App\Repositories\DasborRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DasborController extends Controller
{
    private DasborRepository $dasborRepository;

    public function __construct(DasborRepository $dasborRepository)
    {
        $this->dasborRepository = $dasborRepository;
    }

    public function indeks(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $pengguna = Auth::user();

        $level = $pengguna->{'level'};

        if ($level === 'Cabang') {
            $idPengguna = $pengguna->getAuthIdentifier();
        } else {
            $idPengguna = null;
        }

        $pendapatanBulanan = $this->dasborRepository->pendapatanBulanan($idPengguna);
        $pendapatanHarian = $this->dasborRepository->pendapatanHarian($idPengguna);
        $transaksi = $this->dasborRepository->transaksi($idPengguna);

        return view('tampilan.dasbor', [
            'pendapatan_bulanan' => $pendapatanBulanan,
            'pendapatan_harian' => $pendapatanHarian,
            'transaksi' => $transaksi
        ]);
    }

    public function data(Request $request): JsonResponse
    {
        $pengguna = Auth::user();

        $level = $pengguna->{'level'};

        if ($level === 'Cabang') {
            $idPengguna = $pengguna->getAuthIdentifier();
        } else {
            $idPengguna = null;
        }

        $tipe = urldecode($request->query('tipe'));

        if ($tipe === 'ringkasan pendapatan') {
            $ringkasanPendapatan = $this->dasborRepository->ringkasanPendapatan($idPengguna);

            return response()->json($ringkasanPendapatan);
        } elseif ($tipe === 'sumber pendapatan') {
            $sumberPendapatan = $this->dasborRepository->sumberPendapatan($idPengguna);

            return response()->json($sumberPendapatan);
        }

        $lokasiCabang = $this->dasborRepository->lokasiCabang($idPengguna);

        return response()->json($lokasiCabang);
    }
}
