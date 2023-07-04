<?php

namespace App\Repositories\Master;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PenggunaRepository
{
    public function cariSemua($idPengguna): Collection
    {
        $pengguna = DB::table('pengguna')->selectRaw('row_number() over (order by id desc) no');
        $pengguna = $pengguna->addSelect(DB::raw('rtrim(concat_ws(\' \', nama_depan, nama_belakang)) nama_lengkap'));
        $pengguna = $pengguna->addSelect('level');
        $pengguna = $pengguna->where('ditambah_oleh', '=', $idPengguna);

        return $pengguna->get();
    }

    public function tambah($pengguna, $connectCabang = null): void
    {
        $level = $pengguna['level'];

        if ($level === 'Pemilik' && count($connectCabang) > 0) {
            DB::transaction(function () use ($pengguna, $connectCabang) {
                $idPengguna = DB::table('pengguna')->insertGetId($pengguna);

                $cabang = DB::table('cabang')->whereIn('uuid_teks', $connectCabang);
                $cabang = $cabang->whereNull('tanggal_dihapus');
                $cabang = $cabang->get();

                $nilai = [];

                foreach ($cabang as $c) {
                    $idCabang = $c->id_cabang;

                    $nilai[] = [
                        'id_pengguna' => $idPengguna,
                        'id_cabang' => $idCabang
                    ];
                }

                DB::table('cabang_pemilik')->insert($nilai);
            });
        } elseif ($level === 'Cabang' && count($connectCabang) === 1) {
            DB::transaction(function () use ($pengguna, $connectCabang) {
                $idPengguna = DB::table('pengguna')->insertGetId($pengguna);

                $cabang = DB::table('cabang')->where('uuid_teks', '=', $connectCabang[0]);
                $cabang = $cabang->whereNull('tanggal_dihapus');

                $cabang->update([
                    'id_pengguna' => $idPengguna
                ]);
            });
        } else {
            DB::table('pengguna')->insert($pengguna);
        }
    }
}
