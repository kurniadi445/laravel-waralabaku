<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\PenggunaRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

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
}
