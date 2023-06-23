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

class KinerjaCabangController extends Controller
{
    private KinerjaCabangRepository $kinerjaCabangRepository;

    public function __construct(KinerjaCabangRepository $kinerjaCabangRepository)
    {
        $this->kinerjaCabangRepository = $kinerjaCabangRepository;
    }

    public function indeks(Request $request): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $cabang = $request->query('cabang');

        $kinerjaCabang = $this->kinerjaCabangRepository->cariSemua($cabang);

        return view('tampilan.laporan.kinerja-cabang.indeks', [
            'kinerja_cabang' => $kinerjaCabang
        ]);
    }

    public function ekspor(Request $request): Response
    {
        $cabang = $request->query('cabang');

        $kinerjaCabang = $this->kinerjaCabangRepository->cariSemua($cabang);

        $pdf = Pdf::loadView('tampilan.laporan.kinerja-cabang.ekspor', [
            'kinerja_cabang' => $kinerjaCabang
        ]);

        return $pdf->stream();
    }
}
