<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\ProdukRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    private ProdukRepository $produkRepository;

    public function __construct(ProdukRepository $produkRepository)
    {
        $this->produkRepository = $produkRepository;
    }

    public function indeks(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $produk = $this->produkRepository->cariSemua();

        return view('tampilan.master.produk.indeks', [
            'produk' => $produk
        ]);
    }

    public function tambah(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('tampilan.master.produk.tambah');
    }

    public function prosesTambah(Request $request): JsonResponse
    {
        $uuid = hex2bin(str_replace('-', '', Str::uuid()));
        $namaProduk = $request->input('nama-produk');
        $harga = $request->input('harga');

        $this->produkRepository->tambah([
            'uuid' => $uuid,
            'nama_produk' => $namaProduk,
            'harga' => $harga
        ]);

        return response()->json([
            'berhasil' => true
        ]);
    }

    public function edit($uuid)
    {
        $produk = $this->produkRepository->cariSatuBerdasarkanUUID($uuid);

        if ($produk) {
            return view('tampilan.master.produk.edit', [
                'produk' => $produk
            ]);
        }

        abort(404);
    }

    public function prosesEdit(Request $request, $uuid): JsonResponse
    {
        $produk = $this->produkRepository->cariSatuBerdasarkanUUID($uuid);

        if ($produk) {
            $namaProduk = $request->input('nama-produk');
            $harga = $request->input('harga');

            $this->produkRepository->edit($uuid, [
                'nama_produk' => $namaProduk,
                'harga' => $harga
            ]);

            return response()->json([
                'berhasil' => true
            ]);
        }

        return response()->json([
            'berhasil' => false
        ]);
    }
    public function hapus($uuid): JsonResponse
    {
        $produk = $this->produkRepository->cariSatuBerdasarkanUUID($uuid);

        if ($produk) {
            $tanggal = date('Y-m-d H:i:s');

            $this->produkRepository->hapus($uuid, [
                'tanggal_dihapus' => $tanggal
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
