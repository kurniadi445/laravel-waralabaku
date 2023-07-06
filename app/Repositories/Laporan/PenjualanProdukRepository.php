<?php

namespace App\Repositories\Laporan;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PenjualanProdukRepository
{
    public function cariSemua($urutanTerjual = null, $cari = null): Collection
    {
        $penjualanProduk = DB::table('produk')->select('nama_produk', DB::raw('ifnull(sum(kuantitas), 0) terjual'));
        $penjualanProduk = $penjualanProduk->addSelect(DB::raw('concat(\'Rp\', format(ifnull(sum(kuantitas * detail_transaksi.harga), 0), 0)) total'));
        $penjualanProduk = $penjualanProduk->leftJoin('detail_transaksi', 'produk.id_produk', '=', 'detail_transaksi.id_produk');

        if ($cari) {
            $penjualanProduk = $penjualanProduk->where('nama_produk', 'like', sprintf('%%%s%%', $cari));
        }

        $penjualanProduk = $penjualanProduk->groupBy('nama_produk');

        $penjualanProduk = DB::query()->fromSub($penjualanProduk, 'a');

        if ($urutanTerjual === 'terendah') {
            $penjualanProduk = $penjualanProduk->selectRaw('row_number() over (order by terjual) no');
        } else {
            $penjualanProduk = $penjualanProduk->selectRaw('row_number() over (order by terjual desc) no');
        }

        $penjualanProduk = $penjualanProduk->addSelect('a.*');

        return $penjualanProduk->get();
    }
}
