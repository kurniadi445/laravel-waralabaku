<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\CabangRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CabangController extends Controller
{
    private CabangRepository $cabangRepository;

    public function __construct(CabangRepository $cabangRepository)
    {
        $this->cabangRepository = $cabangRepository;
    }

    public function indeks(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $cabang = $this->cabangRepository->cariSemua();

        return view('tampilan.master.cabang.indeks', [
            'cabang' => $cabang
        ]);
    }

    public function tambah(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('tampilan.master.cabang.tambah');
    }

    public function prosesTambah(Request $request): JsonResponse
    {
        $idPengguna = Auth::user()->getAuthIdentifier();
        $uuid = hex2bin(str_replace('-', '', Str::uuid()));
        $namaCabang = $request->input('nama-cabang');
        $alamat = $request->input('alamat');

        $this->cabangRepository->tambah([
            'id_pengguna' => $idPengguna,
            'uuid' => $uuid,
            'nama_cabang' => $namaCabang,
            'alamat' => $alamat
        ]);

        return response()->json([
            'berhasil' => true
        ]);
    }

    public function edit($uuid)
    {
        $cabang = $this->cabangRepository->cariSatuBerdasarkanUUID($uuid);

        if ($cabang) {
            return view('tampilan.master.cabang.edit', [
                'cabang' => $cabang
            ]);
        }

        abort(404);
    }

    public function prosesEdit(Request $request, $uuid): JsonResponse
    {
        $cabang = $this->cabangRepository->cariSatuBerdasarkanUUID($uuid);

        if ($cabang) {
            $namaCabang = $request->input('nama-cabang');
            $alamat = $request->input('alamat');

            $this->cabangRepository->edit($uuid, [
                'nama_cabang' => $namaCabang,
                'alamat' => $alamat
            ]);

            return response()->json([
                'berhasil' => true
            ]);
        }

        return response()->json([
            'berhasil' => false
        ]);
    }
}
