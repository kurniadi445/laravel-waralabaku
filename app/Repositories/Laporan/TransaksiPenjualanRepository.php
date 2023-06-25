<?php

namespace App\Repositories\Laporan;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TransaksiPenjualanRepository
{
    public function cariSemua($idPengguna = null, $tanggalMulai = null, $tanggalAkhir = null): Collection
    {
        $transaksi = DB::table('v_transaksi')->selectRaw('row_number() over (order by id_transaksi desc) no');
        $transaksi = $transaksi->addSelect(DB::raw('concat(\'Rp\', format(total, 0)) as total'), 'tanggal');

        if ($idPengguna) {
            $transaksi = $transaksi->whereRaw('json_extract(cabang, \'$.id_pengguna\') = ?', [$idPengguna]);
        }

        if ($tanggalMulai && $tanggalAkhir) {
            $transaksi = $transaksi->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);
        }

        return $transaksi->get();
    }
}
