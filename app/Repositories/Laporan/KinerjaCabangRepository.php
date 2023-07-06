<?php

namespace App\Repositories\Laporan;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class KinerjaCabangRepository
{
    public function cariSemua($idPengguna, $level, $cabang = null): Collection
    {
        $kinerjaCabang = DB::table('v_transaksi')->selectRaw('json_unquote(json_extract(cabang, \'$.nama_cabang\')) nama_cabang');
        $kinerjaCabang = $kinerjaCabang->addSelect(DB::raw('format(count(*), 0) jumlah_transaksi'));
        $kinerjaCabang = $kinerjaCabang->addSelect(DB::raw('concat(\'Rp\', format(sum(total), 0)) as total'));

        if ($level === 'Pemilik') {
            $kinerjaCabang = $kinerjaCabang->whereIn(DB::raw('json_extract(cabang, \'$.id_cabang\')'), function (Builder $builder) use ($idPengguna) {
                $builder = $builder->select('id_cabang');
                $builder = $builder->from('cabang_pemilik');

                $builder->where('id_pengguna', '=', $idPengguna);
            });
        }

        if ($cabang) {
            $kinerjaCabang = $kinerjaCabang->whereRaw('json_unquote(json_extract(cabang, \'$.nama_cabang\')) like ?', [sprintf('%%%s%%', $cabang)]);
        }

        $kinerjaCabang = $kinerjaCabang->groupByRaw('1');

        $kinerjaCabang = DB::query()->fromSub($kinerjaCabang, 'cte_transaksi');
        $kinerjaCabang = $kinerjaCabang->selectRaw('row_number() over (order by total desc) no');
        $kinerjaCabang = $kinerjaCabang->addSelect('cte_transaksi.*');

        return $kinerjaCabang->get();
    }
}
