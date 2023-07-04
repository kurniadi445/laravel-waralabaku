'use strict';

$(function () {
    const tombolEkspor = $('#tombol-ekspor');

    let url = `${document.location.origin}/laporan/penjualan-produk/ekspor`;

    tombolEkspor.on('click', function (objekEvent) {
        handler(objekEvent, url);
    });
});
