<?php

namespace App\Repositories\Master;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TransaksiRepository
{
    public function cariSemuaBerdasarkanNamaProduk($idPengguna, $namaProduk): Collection
    {
        $produk = DB::table('produk')->selectRaw('row_number() over (order by nama_produk) no');
        $produk = $produk->addSelect('uuid_teks', 'nama_produk', 'harga');
        $produk = StokRepository::leftJoinStokCabang($produk, $idPengguna);
        $produk = $produk->where('nama_produk', 'like', sprintf('%%%s%%', $namaProduk));
        $produk = $produk->where('stok', '>', 0);

        return $produk->get();
    }

    public function bayar($idPengguna, $keranjangBelanja): void
    {
        DB::transaction(function () use ($idPengguna, $keranjangBelanja) {
            $cabang = DB::table('cabang')->where('id_pengguna', '=', $idPengguna);
            $cabang = $cabang->whereNull('tanggal_dihapus');
            $cabang = $cabang->first();

            $idCabang = $cabang->id_cabang;

            $transaksi = DB::table('transaksi')->insertGetId([
                'id_cabang' => $idCabang
            ]);

            $nilai = [];

            foreach ($keranjangBelanja as $k) {
                $produk = DB::table('produk')->where('uuid_teks', '=', $k['uuid']);
                $produk = $produk->whereNull('tanggal_dihapus');
                $produk = $produk->first();

                $idProduk = $produk->id_produk;
                $harga = $produk->harga;

                $idTransaksi = $transaksi;
                $kuantitas = $k['kuantitas'];

                $nilai[] = [
                    'id_transaksi' => $idTransaksi,
                    'id_produk' => $idProduk,
                    'kuantitas' => $kuantitas,
                    'harga' => $harga
                ];
            }

            DB::table('detail_transaksi')->insert($nilai);
        });
    }
}
