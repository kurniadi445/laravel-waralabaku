<?php

namespace App\Repositories\Master;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProdukRepository
{
    public function cariSemua(): Collection
    {
        $produk = DB::table('produk')->selectRaw('row_number() over (order by id_produk desc) no');
        $produk = $produk->addSelect('nama_produk', DB::raw('concat(\'Rp\', format(harga, 0)) as harga'));

        return $produk->get();
    }
}
