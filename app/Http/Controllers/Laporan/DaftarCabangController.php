<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Repositories\Laporan\DaftarCabangRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DaftarCabangController extends Controller
{
    private DaftarCabangRepository $daftarCabangRepository;

    public function __construct(DaftarCabangRepository $daftarCabangRepository)
    {
        $this->daftarCabangRepository = $daftarCabangRepository;
    }

    public function indeks(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $idPengguna = Auth::user()->getAuthIdentifier();

        $daftarCabang = $this->daftarCabangRepository->cariSemua($idPengguna);

        return view('tampilan.laporan.daftar-cabang.indeks', [
            'daftar_cabang' => $daftarCabang
        ]);
    }

    public function ekspor(): Response
    {
        $idPengguna = Auth::user()->getAuthIdentifier();

        $daftarCabang = $this->daftarCabangRepository->cariSemua($idPengguna);

        $pdf = Pdf::loadView('tampilan.laporan.daftar-cabang.ekspor', [
            'daftar_cabang' => $daftarCabang
        ]);

        return $pdf->stream();
    }

    public function lokasi($uuid)
    {
        $idPengguna = Auth::user()->getAuthIdentifier();

        $daftarCabang = $this->daftarCabangRepository->cariSatuBerdasarkanUUIDIDPengguna($uuid, $idPengguna);

        if ($daftarCabang) {
            return view('tampilan.laporan.daftar-cabang.lokasi', [
                'daftar_cabang' => $daftarCabang
            ]);
        }

        abort(404);
    }

    public function dataLokasi($uuid)
    {
        $idPengguna = Auth::user()->getAuthIdentifier();

        $daftarCabang = $this->daftarCabangRepository->cariSatuBerdasarkanUUIDIDPengguna($uuid, $idPengguna, [
            DB::raw('st_x(koordinat) garis_bujur'),
            DB::raw('st_y(koordinat) garis_lintang')
        ]);

        if ($daftarCabang) {
            return response()->json($daftarCabang);
        }

        abort(403);
    }
}
