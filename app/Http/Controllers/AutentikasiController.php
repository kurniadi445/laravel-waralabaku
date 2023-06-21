<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AutentikasiController extends Controller
{
    public function masuk(): View|\Illuminate\Foundation\Application|Factory|Application|RedirectResponse
    {
        if (Auth::check()) {
            return to_route('dasbor');
        }

        return view('tampilan.autentikasi.masuk');
    }

    public function prosesMasuk(Request $request): JsonResponse
    {
        $namaPengguna = $request->input('nama-pengguna');
        $kataSandi = $request->input('kata-sandi');

        if (Auth::attempt(['nama_pengguna' => $namaPengguna, 'password' => $kataSandi])) {
            $request->session()->regenerate();

            return response()->json([
                'berhasil' => true
            ]);
        }

        return response()->json([
            'berhasil' => false
        ]);
    }

    public function keluar(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('autentikasi.masuk');
    }
}
