<?php

namespace App\Repositories\Master;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class StokRepository
{
    public static function leftJoinStokCabang(Builder $builder, $idPengguna): Builder
    {
        return $builder->leftJoin('stok_cabang', function (JoinClause $joinClause) use ($idPengguna) {
            $joinClause = $joinClause->on('produk.id_produk', '=', 'stok_cabang.id_produk');

            $joinClause->where('id_cabang', '=', function (Builder $builder) use ($idPengguna) {
                $builder = $builder->select('id_cabang');
                $builder = $builder->from('cabang');

                $builder->where('id_pengguna', '=', $idPengguna);
            });
        });
    }

    public function cariSemua($idPengguna, $cari = null): Collection
    {
        $stok = DB::table('produk')->selectRaw('row_number() over (order by produk.id_produk desc) no');
        $stok = $stok->addSelect('uuid_teks', 'nama_produk', DB::raw('ifnull(format(stok, 0), 0) as stok'));
        $stok = $this->leftJoinStokCabang($stok, $idPengguna);

        if ($cari) {
            $stok = $stok->where('nama_produk', 'like', sprintf('%%%s%%', $cari));
        }

        return $stok->get();
    }

    public function edit($uuid, $idPengguna, $stok): void
    {
        DB::transaction(function () use ($uuid, $idPengguna, $stok) {
            $cabang = DB::table('cabang')->where('id_pengguna', '=', $idPengguna);
            $cabang = $cabang->whereNull('tanggal_dihapus');
            $cabang = $cabang->first();

            $idCabang = $cabang->id_cabang;

            $produk = DB::table('produk')->where('uuid_teks', '=', $uuid);
            $produk = $produk->whereNull('tanggal_dihapus');
            $produk = $produk->first();

            $idProduk = $produk->id_produk;

            DB::table('stok_cabang')->updateOrInsert([
                'id_cabang' => $idCabang,
                'id_produk' => $idProduk
            ], [
                'stok' => $stok
            ]);
        });
    }
}
