<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DasborRepository
{
    public function pendapatanBulanan()
    {
        $pendapatanBulanan = DB::table('v_transaksi')->selectRaw('concat(\'Rp\', format(ifnull(sum(total), 0), 0)) as total');
        $pendapatanBulanan = $pendapatanBulanan->whereRaw('extract(year_month from tanggal) = extract(year_month from curdate())');

        return $pendapatanBulanan->value('total');
    }

    public function pendapatanHarian()
    {
        $pendapatanHarian = DB::table('v_transaksi')->selectRaw('concat(\'Rp\', format(ifnull(sum(total), 0), 0)) as total');
        $pendapatanHarian = $pendapatanHarian->whereRaw('date(tanggal) = curdate()');

        return $pendapatanHarian->value('total');
    }

    public function transaksi()
    {
        $transaksi = DB::table('v_transaksi')->selectRaw('format(count(*), 0) jumlah_transaksi');

        return $transaksi->value('jumlah_transaksi');
    }

    public function ringkasanPendapatan(): array
    {
        return DB::select('call p_transaksi(year(curdate()), null)');
    }

    public function sumberPendapatan(): Collection
    {
        $sumberPendapatan = DB::table('v_transaksi')->selectRaw('json_extract(cabang, \'$.id_cabang\') id_cabang');
        $sumberPendapatan = $sumberPendapatan->addSelect(DB::raw('json_unquote(json_extract(cabang, \'$.nama_cabang\')) nama_cabang'));
        $sumberPendapatan = $sumberPendapatan->addSelect(DB::raw('count(*) jumlah_transaksi'));
        $sumberPendapatan = $sumberPendapatan->groupByRaw('1, 2');

        return $sumberPendapatan->get();
    }
}
