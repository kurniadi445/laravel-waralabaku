<?php

namespace App\Repositories\Laporan;

use App\Repositories\DasborRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TransaksiPenjualanRepository
{
    public function cariSemua($idPengguna, $level, $tanggalMulai = null, $tanggalAkhir = null): Collection
    {
        $transaksi = DB::table('v_transaksi')->selectRaw('row_number() over (order by id_transaksi desc) no');
        $transaksi = $transaksi->addSelect(DB::raw('concat(\'Rp\', format(total, 0)) as total'), 'tanggal');
        $transaksi = DasborRepository::whereCabang($transaksi, $idPengguna, $level);

        if ($tanggalMulai && $tanggalAkhir) {
            $transaksi = $transaksi->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);
        }

        return $transaksi->get();
    }
}
