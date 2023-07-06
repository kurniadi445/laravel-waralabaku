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
        $daftarCabang = $daftarCabang->addSelect('nama_cabang', 'alamat');
        $daftarCabang = $daftarCabang->whereIn('id_cabang', function (Builder $builder) use ($idPengguna) {
            $builder = $builder->select('id_cabang');
            $builder = $builder->from('cabang_pemilik');

            $builder->where('id_pengguna', '=', $idPengguna);
        });
        $daftarCabang = $daftarCabang->whereNull('tanggal_dihapus');

        return $daftarCabang->get();
    }
}
