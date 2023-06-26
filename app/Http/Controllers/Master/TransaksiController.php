<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\TransaksiRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    private TransaksiRepository $transaksiRepository;

    public function __construct(TransaksiRepository $transaksiRepository)
    {
        $this->transaksiRepository = $transaksiRepository;
    }

    public function indeks(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('tampilan.master.transaksi');
    }

    public function data(Request $request): JsonResponse
    {
        $idPengguna = Auth::user()->getAuthIdentifier();

        $namaProduk = urldecode($request->query('nama-produk'));

        $produk = $this->transaksiRepository->cariSemuaBerdasarkanNamaProduk($idPengguna, $namaProduk);

        return response()->json($produk);
    }

    public function bayar(Request $request): JsonResponse
    {
        $idPengguna = Auth::user()->getAuthIdentifier();

        $keranjangBelanja = $request->input('keranjang-belanja');

        $this->transaksiRepository->bayar($idPengguna, $keranjangBelanja);

        return response()->json([
            'berhasil' => true
        ]);
    }
}
