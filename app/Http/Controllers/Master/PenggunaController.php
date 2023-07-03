<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
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
    private PenggunaRepository $penggunaRepository;

    public function __construct(PenggunaRepository $penggunaRepository)
    {
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

    public function prosesTambah(Request $request): JsonResponse
    {
        $namaPengguna = $request->input('nama-pengguna');
        $kataSandi = Hash::make($request->input('kata-sandi'));
        $namaDepan = $request->input('nama-depan');
        $namaBelakang = $request->input('nama-belakang');
        $level = $request->input('level');
        $idPengguna = Auth::user()->getAuthIdentifier();

        $this->penggunaRepository->tambah([
            'nama_pengguna' => $namaPengguna,
            'password' => $kataSandi,
            'nama_depan' => $namaDepan,
            'nama_belakang' => $namaBelakang,
            'level' => $level,
            'ditambah_oleh' => $idPengguna
        ]);

        return response()->json([
            'berhasil' => true
        ]);
    }
}
