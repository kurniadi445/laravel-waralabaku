<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Repositories\Laporan\KinerjaCabangRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class KinerjaCabangController extends Controller
{
    private KinerjaCabangRepository $kinerjaCabangRepository;

    public function __construct(KinerjaCabangRepository $kinerjaCabangRepository)
    {
        $this->kinerjaCabangRepository = $kinerjaCabangRepository;
    }

    public function indeks(Request $request): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $pengguna = Auth::user();

        $idPengguna = $pengguna->getAuthIdentifier();
        $level = $pengguna->{'level'};

        $cabang = $request->query('cabang');

        $kinerjaCabang = $this->kinerjaCabangRepository->cariSemua($idPengguna, $level, $cabang);

        return view('tampilan.laporan.kinerja-cabang.indeks', [
            'kinerja_cabang' => $kinerjaCabang
        ]);
    }

    public function ekspor(Request $request): Response
    {
        $pengguna = Auth::user();

        $idPengguna = $pengguna->getAuthIdentifier();
        $level = $pengguna->{'level'};

        $cabang = $request->query('cabang');

        $kinerjaCabang = $this->kinerjaCabangRepository->cariSemua($idPengguna, $level, $cabang);

        $pdf = Pdf::loadView('tampilan.laporan.kinerja-cabang.ekspor', [
            'kinerja_cabang' => $kinerjaCabang
        ]);

        return $pdf->stream();
    }
}
