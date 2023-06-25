<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DasborRepository
{
    public function pendapatanBulanan($idPengguna = null)
    {
        $pendapatanBulanan = DB::table('v_transaksi')->selectRaw('concat(\'Rp\', format(ifnull(sum(total), 0), 0)) as total');
        $pendapatanBulanan = $pendapatanBulanan->whereRaw('extract(year_month from tanggal) = extract(year_month from curdate())');

        if ($idPengguna) {
            $pendapatanBulanan = $pendapatanBulanan->whereRaw('json_extract(cabang, \'$.id_pengguna\') = ?', [$idPengguna]);
        }

        return $pendapatanBulanan->value('total');
    }

    public function pendapatanHarian($idPengguna = null)
    {
        $pendapatanHarian = DB::table('v_transaksi')->selectRaw('concat(\'Rp\', format(ifnull(sum(total), 0), 0)) as total');
        $pendapatanHarian = $pendapatanHarian->whereRaw('date(tanggal) = curdate()');

        if ($idPengguna) {
            $pendapatanHarian = $pendapatanHarian->whereRaw('json_extract(cabang, \'$.id_pengguna\') = ?', [$idPengguna]);
        }

        return $pendapatanHarian->value('total');
    }

    public function transaksi($idPengguna = null)
    {
        $transaksi = DB::table('v_transaksi')->selectRaw('format(count(*), 0) jumlah_transaksi');

        if ($idPengguna) {
            $transaksi = $transaksi->whereRaw('json_extract(cabang, \'$.id_pengguna\') = ?', [$idPengguna]);
        }

        return $transaksi->value('jumlah_transaksi');
    }

    public function ringkasanPendapatan($idPengguna): array
    {
        return DB::select('call p_transaksi(year(curdate()), ?)', [$idPengguna]);
    }

    public function sumberPendapatan($idPengguna = null): Collection
    {
        $sumberPendapatan = DB::table('v_transaksi')->selectRaw('json_extract(cabang, \'$.id_cabang\') id_cabang');
        $sumberPendapatan = $sumberPendapatan->addSelect(DB::raw('json_unquote(json_extract(cabang, \'$.nama_cabang\')) nama_cabang'));
        $sumberPendapatan = $sumberPendapatan->addSelect(DB::raw('count(*) jumlah_transaksi'));

        if ($idPengguna) {
            $sumberPendapatan = $sumberPendapatan->whereRaw('json_extract(cabang, \'$.id_pengguna\') = ?', [$idPengguna]);
        }

        $sumberPendapatan = $sumberPendapatan->groupByRaw('1, 2');

        return $sumberPendapatan->get();
    }
}
