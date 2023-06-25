<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\StokRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StokController extends Controller
{
    private StokRepository $stokRepository;

    public function __construct(StokRepository $stokRepository)
    {
        $this->stokRepository = $stokRepository;
    }

    public function indeks(Request $request): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $idPengguna = Auth::user()->getAuthIdentifier();

        $cari = $request->query('cari');

        $stok = $this->stokRepository->cariSemua($idPengguna, $cari);

        return view('tampilan.master.stok.indeks', [
            'stok' => $stok
        ]);
    }
}
