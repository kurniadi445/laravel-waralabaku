'use strict';

$(function () {
    const tombolEkspor = $('#tombol-ekspor');

    tombolEkspor.on('click', function () {
        const cabang = $('input[name="cabang"]').val();

        let url = `${document.location.origin}/laporan/kinerja-cabang/ekspor`;

        const parameter = new URLSearchParams({
            'cabang': cabang
        }).toString();

        if (cabang) {
            url += `?${parameter}`;
        }

        document.location.assign(url);
    });
});
