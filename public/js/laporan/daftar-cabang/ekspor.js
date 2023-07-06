'use strict';

$(function () {
    const tombolEkspor = $('#tombol-ekspor');

    tombolEkspor.on('click', function () {
        document.location.assign(`${document.location.origin}/laporan/daftar-cabang/ekspor`);
    });
});
