<?php

namespace App\Http\Controllers;

use App\Repositories\DasborRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DasborController extends Controller
{
    private DasborRepository $dasborRepository;

    public function __construct(DasborRepository $dasborRepository)
    {
        $this->dasborRepository = $dasborRepository;
    }

    public function indeks(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $pendapatanBulanan = $this->dasborRepository->pendapatanBulanan();
        $pendapatanHarian = $this->dasborRepository->pendapatanHarian();
        $transaksi = $this->dasborRepository->transaksi();

        return view('tampilan.dasbor', [
            'pendapatan_bulanan' => $pendapatanBulanan,
            'pendapatan_harian' => $pendapatanHarian,
            'transaksi' => $transaksi
        ]);
    }

    public function data(Request $request): JsonResponse
    {
        $tipe = urldecode($request->query('tipe'));

        if ($tipe === 'ringkasan pendapatan') {
            $ringkasanPendapatan = $this->dasborRepository->ringkasanPendapatan();

            return response()->json($ringkasanPendapatan);
        }

        $sumberPendapatan = $this->dasborRepository->sumberPendapatan();

        return response()->json($sumberPendapatan);
    }
}
