'use strict';

$(function () {
    const tombolEkspor = $('#tombol-ekspor');

    tombolEkspor.on('click', function () {
        const tanggalMulai = $('input[name="tanggal-mulai"]').val();
        const tanggalAkhir = $('input[name="tanggal-akhir"]').val();

        let url = `${document.location.origin}/laporan/transaksi-penjualan/ekspor`;

        const parameter = new URLSearchParams({
            'tanggal-mulai': tanggalMulai,
            'tanggal-akhir': tanggalAkhir
        }).toString();

        if (tanggalMulai && tanggalAkhir) {
            url += `?${parameter}`;
        }

        document.location.assign(url);
    });
});
