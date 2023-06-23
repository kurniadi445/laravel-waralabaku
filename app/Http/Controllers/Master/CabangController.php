<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Repositories\Master\CabangRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

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
}
