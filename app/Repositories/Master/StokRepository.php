<?php

namespace App\Repositories\Master;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class StokRepository
{
    public function cariSemua($idPengguna, $cari = null): Collection
    {
        $stok = DB::table('produk')->selectRaw('row_number() over (order by produk.id_produk desc) no');
        $stok = $stok->addSelect('nama_produk', DB::raw('ifnull(format(stok, 0), 0) as stok'));
        $stok = $stok->leftJoin('stok_cabang', function (JoinClause $joinClause) use ($idPengguna) {
            $joinClause = $joinClause->on('produk.id_produk', '=', 'stok_cabang.id_produk');

            $joinClause->where('id_cabang', '=', function (Builder $builder) use ($idPengguna) {
                $builder = $builder->select('id_cabang');
                $builder = $builder->from('cabang');

                $builder->where('id_pengguna', '=', $idPengguna);
            });
        });

        if ($cari) {
            $stok = $stok->where('nama_produk', 'like', sprintf('%%%s%%', $cari));
        }

        return $stok->get();
    }
}
