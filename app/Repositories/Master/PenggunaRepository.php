<?php

namespace App\Repositories\Master;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PenggunaRepository
{
    public function cariSemua($idPengguna): Collection
    {
        $pengguna = DB::table('pengguna')->selectRaw('row_number() over (order by id desc) no');
        $pengguna = $pengguna->addSelect(DB::raw('rtrim(concat_ws(\' \', nama_depan, nama_belakang)) nama_lengkap'));
        $pengguna = $pengguna->addSelect('level');
        $pengguna = $pengguna->where('ditambah_oleh', '=', $idPengguna);

        return $pengguna->get();
    }

    public function tambah($nilai): void
    {
        DB::table('pengguna')->insert($nilai);
    }
}
