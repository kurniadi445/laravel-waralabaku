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

        $idPengguna = $pengguna->getAuthIdentifier();
        $level = $pengguna->{'level'};

        $pendapatanBulanan = $this->dasborRepository->pendapatanBulanan($idPengguna, $level);
        $pendapatanHarian = $this->dasborRepository->pendapatanHarian($idPengguna, $level);
        $transaksi = $this->dasborRepository->transaksi($idPengguna, $level);

        return view('tampilan.dasbor', [
            'pendapatan_bulanan' => $pendapatanBulanan,
            'pendapatan_harian' => $pendapatanHarian,
            'transaksi' => $transaksi
        ]);
    }

    public function data(Request $request): JsonResponse
    {
        $pengguna = Auth::user();

        $idPengguna = $pengguna->getAuthIdentifier();
        $level = $pengguna->{'level'};

        $tipe = urldecode($request->query('tipe'));

        if ($tipe === 'ringkasan pendapatan') {
            $ringkasanPendapatan = $this->dasborRepository->ringkasanPendapatan($idPengguna, $level);

            return response()->json($ringkasanPendapatan);
        } elseif ($tipe === 'sumber pendapatan') {
            $sumberPendapatan = $this->dasborRepository->sumberPendapatan($idPengguna, $level);

            return response()->json($sumberPendapatan);
        }

        $lokasiCabang = $this->dasborRepository->lokasiCabang($idPengguna, $level);

        return response()->json($lokasiCabang);
    }
}
