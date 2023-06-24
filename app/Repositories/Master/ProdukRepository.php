<?php

namespace App\Repositories\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProdukRepository
{
    public function cariSemua(): Collection
    {
        $produk = DB::table('produk')->selectRaw('row_number() over (order by id_produk desc) no');
        $produk = $produk->addSelect('uuid_teks', 'nama_produk');
        $produk = $produk->addSelect(DB::raw('concat(\'Rp\', format(harga, 0)) as harga'));
        $produk = $produk->whereNull('tanggal_dihapus');

        return $produk->get();
    }

    public function cariSatuBerdasarkanUUID($uuid): object|null
    {
        $produk = DB::table('produk')->where('uuid_teks', '=', $uuid);
        $produk = $produk->whereNull('tanggal_dihapus');

        return $produk->first();
    }

    public function tambah($nilai): void
    {
        DB::table('produk')->insert($nilai);
    }

    public function edit($uuid, $nilai): void
    {
        $produk = DB::table('produk')->where('uuid_teks', '=', $uuid);
        $produk = $produk->whereNull('tanggal_dihapus');

        $produk->update($nilai);
    }

    public function hapus($uuid, $nilai): void
    {
        $produk = DB::table('produk')->where('uuid_teks', '=', $uuid);
        $produk = $produk->whereNull('tanggal_dihapus');

        $produk->update($nilai);
    }
}
