<?php

namespace App\Repositories\Master;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CabangRepository
{
    public function cariSemua(): Collection
    {
        $cabang = DB::table('cabang')->selectRaw('row_number() over (order by id_cabang desc) no');
        $cabang = $cabang->addSelect('nama_cabang', 'alamat');

        return $cabang->get();
    }
}
