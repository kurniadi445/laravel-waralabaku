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

    public function cariSemuaBerdasarkanNamaCabang($namaCabang): Collection
    {
        $cabang = DB::table('cabang')->selectRaw('row_number() over (order by nama_cabang) no');
        $cabang = $cabang->addSelect('uuid_teks', 'nama_cabang');
        $cabang = $cabang->where('nama_cabang', 'like', sprintf('%%%s%%', $namaCabang));
        $cabang = $cabang->whereNull('tanggal_dihapus');

        return $cabang->get();
    }

    public function cariSatuBerdasarkanUUID($uuid, $kolom = ['*']): object|null
    {
        $cabang = DB::table('cabang')->where('uuid_teks', '=', $uuid);
        $cabang = $cabang->whereNull('tanggal_dihapus');

        return $cabang->first($kolom);
    }

    public function editLokasi($uuid, $garisLintang, $garisBujur): void
    {
        DB::select('call p_edit_lokasi_cabang(?, ?, ?)', [$uuid, $garisLintang, $garisBujur]);
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
