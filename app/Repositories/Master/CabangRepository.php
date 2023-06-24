<?php

namespace App\Repositories\Master;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CabangRepository
{
    public function cariSemua(): Collection
    {
        $cabang = DB::table('cabang')->selectRaw('row_number() over (order by id_cabang desc) no');
        $cabang = $cabang->addSelect('uuid_teks', 'nama_cabang', 'alamat');
        $cabang = $cabang->whereNull('tanggal_dihapus');

        return $cabang->get();
    }

    public function cariSatuBerdasarkanUUID($uuid): object|null
    {
        $cabang = DB::table('cabang')->where('uuid_teks', '=', $uuid);
        $cabang = $cabang->whereNull('tanggal_dihapus');

        return $cabang->first();
    }

    public function tambah($nilai): void
    {
        DB::table('cabang')->insert($nilai);
    }

    public function edit($uuid, $nilai): void
    {
        $cabang = DB::table('cabang')->where('uuid_teks', '=', $uuid);
        $cabang = $cabang->whereNull('tanggal_dihapus');

        $cabang->update($nilai);
    }

    public function hapus($uuid, $nilai): void
    {
        $cabang = DB::table('cabang')->where('uuid_teks', '=', $uuid);
        $cabang = $cabang->whereNull('tanggal_dihapus');

        $cabang->update($nilai);
    }
}
