<?php

namespace App\Repositories;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DasborRepository
{
    public static function whereCabang(Builder $builder, $idPengguna, $level): Builder
    {
        if ($level === 'Pemilik') {
            $builder = $builder->whereIn(DB::raw('json_extract(cabang, \'$.id_cabang\')'), function (Builder $builder) use ($idPengguna) {
                $builder = $builder->select('id_cabang');
                $builder = $builder->from('cabang_pemilik');

                $builder->where('id_pengguna', '=', $idPengguna);
            });
        } elseif ($level === 'Cabang') {
            $builder = $builder->whereRaw('json_extract(cabang, \'$.id_pengguna\') = ?', [$idPengguna]);
        }

        return $builder;
    }

    public function pendapatanBulanan($idPengguna, $level)
    {
        $pendapatanBulanan = DB::table('v_transaksi')->selectRaw('concat(\'Rp\', format(ifnull(sum(total), 0), 0)) as total');
        $pendapatanBulanan = $pendapatanBulanan->whereRaw('extract(year_month from tanggal) = extract(year_month from curdate())');
        $pendapatanBulanan = $this->whereCabang($pendapatanBulanan, $idPengguna, $level);

        return $pendapatanBulanan->value('total');
    }

    public function pendapatanHarian($idPengguna, $level)
    {
        $pendapatanHarian = DB::table('v_transaksi')->selectRaw('concat(\'Rp\', format(ifnull(sum(total), 0), 0)) as total');
        $pendapatanHarian = $pendapatanHarian->whereRaw('date(tanggal) = curdate()');
        $pendapatanHarian = $this->whereCabang($pendapatanHarian, $idPengguna, $level);

        return $pendapatanHarian->value('total');
    }

    public function transaksi($idPengguna, $level)
    {
        $transaksi = DB::table('v_transaksi')->selectRaw('format(count(*), 0) jumlah_transaksi');
        $transaksi = $this->whereCabang($transaksi, $idPengguna, $level);

        return $transaksi->value('jumlah_transaksi');
    }

    public function ringkasanPendapatan($idPengguna, $level): array
    {
        return DB::select('call p_transaksi(year(curdate()), ?, ?)', [$idPengguna, $level]);
    }

    public function sumberPendapatan($idPengguna, $level): Collection
    {
        $sumberPendapatan = DB::table('v_transaksi')->selectRaw('json_extract(cabang, \'$.id_cabang\') id_cabang');
        $sumberPendapatan = $sumberPendapatan->addSelect(DB::raw('json_unquote(json_extract(cabang, \'$.nama_cabang\')) nama_cabang'));
        $sumberPendapatan = $sumberPendapatan->addSelect(DB::raw('count(*) jumlah_transaksi'));
        $sumberPendapatan = $this->whereCabang($sumberPendapatan, $idPengguna, $level);
        $sumberPendapatan = $sumberPendapatan->groupByRaw('1, 2');

        return $sumberPendapatan->get();
    }

    public function lokasiCabang($idPengguna, $level): Collection
    {
        $lokasiCabang = DB::table('cabang')->select('nama_cabang');
        $lokasiCabang = $lokasiCabang->addSelect(DB::raw('st_x(koordinat) garis_bujur'));
        $lokasiCabang = $lokasiCabang->addSelect(DB::raw('st_y(koordinat) garis_lintang'));

        if ($level === 'Pemilik') {
            $lokasiCabang = $lokasiCabang->whereIn('id_cabang', function (Builder $builder) use ($idPengguna) {
                $builder = $builder->select('id_cabang');
                $builder = $builder->from('cabang_pemilik');

                $builder->where('id_pengguna', '=', $idPengguna);
            });
        } elseif ($level === 'Cabang') {
            $lokasiCabang = $lokasiCabang->where('id_pengguna', '=', $idPengguna);
        }

        return $lokasiCabang->get();
    }
}
