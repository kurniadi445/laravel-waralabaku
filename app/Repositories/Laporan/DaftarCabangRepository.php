<?php

namespace App\Repositories\Laporan;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DaftarCabangRepository
{
    public function cariSemua($idPengguna): Collection
    {
        $daftarCabang = DB::table('cabang')->selectRaw('row_number() over (order by nama_cabang) no');
        $daftarCabang = $daftarCabang->addSelect('uuid_teks', 'nama_cabang', 'alamat');
        $daftarCabang = $daftarCabang->whereIn('id_cabang', function (Builder $builder) use ($idPengguna) {
            $builder = $builder->select('id_cabang');
            $builder = $builder->from('cabang_pemilik');

            $builder->where('id_pengguna', '=', $idPengguna);
        });
        $daftarCabang = $daftarCabang->whereNull('tanggal_dihapus');

        return $daftarCabang->get();
    }

    public function cariSatuBerdasarkanUUIDIDPengguna($uuid, $idPengguna, $kolom = ['*']): object|null
    {
        $daftarCabang = DB::table('cabang')->join('cabang_pemilik', 'cabang.id_cabang', '=', 'cabang_pemilik.id_cabang');
        $daftarCabang = $daftarCabang->where('uuid_teks', '=', $uuid);
        $daftarCabang = $daftarCabang->where('cabang_pemilik.id_pengguna', '=', $idPengguna);
        $daftarCabang = $daftarCabang->whereNull('tanggal_dihapus');

        return $daftarCabang->first($kolom);
    }
}
