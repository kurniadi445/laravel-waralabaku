<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\CabangRepository;
use App\Repositories\Master\PenggunaRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    private CabangRepository $cabangRepository;
    private PenggunaRepository $penggunaRepository;

    public function __construct(CabangRepository $cabangRepository, PenggunaRepository $penggunaRepository)
    {
        $this->cabangRepository = $cabangRepository;
        $this->penggunaRepository = $penggunaRepository;
    }

    public function indeks(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $idPengguna = Auth::user()->getAuthIdentifier();

        $pengguna = $this->penggunaRepository->cariSemua($idPengguna);

        return view('tampilan.master.pengguna.indeks', [
            'pengguna' => $pengguna
        ]);
    }

    public function tambah(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('tampilan.master.pengguna.tambah');
    }

    public function dataTambah(Request $request): JsonResponse
    {
        $namaCabang = $request->input('nama-cabang');

        $cabang = $this->cabangRepository->cariSemuaBerdasarkanNamaCabang($namaCabang);

        return response()->json($cabang);
    }

    public function prosesTambah(Request $request): JsonResponse
    {
        $namaPengguna = $request->input('nama-pengguna');
        $kataSandi = Hash::make($request->input('kata-sandi'));
        $namaDepan = $request->input('nama-depan');
        $namaBelakang = $request->input('nama-belakang');
        $level = $request->input('level');
        $idPengguna = Auth::user()->getAuthIdentifier();
        $connectCabang = $request->input('connect-cabang');

        $this->penggunaRepository->tambah([
            'nama_pengguna' => $namaPengguna,
            'password' => $kataSandi,
            'nama_depan' => $namaDepan,
            'nama_belakang' => $namaBelakang,
            'level' => $level,
            'ditambah_oleh' => $idPengguna
        ], $connectCabang);

        return response()->json([
            'berhasil' => true
        ]);
    }
}
