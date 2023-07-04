'use strict';

let handler;

$(function () {
    const formulirUrutanTerjual = $('form[name="urutan-terjual"]');
    const formulirCariProduk = $('form[name="cari-produk"]');

    let url = `${document.location.origin}/laporan/penjualan-produk`;

    handler = function (objekEvent, url) {
        objekEvent.preventDefault();

        const urutanTerjual = $('select[name="urutan-terjual"]').val();
        const cari = $('input[name="cari"]').val();

        const opsi = {};

        if (urutanTerjual !== 'Pilih...') {
            opsi['urutan-terjual'] = urutanTerjual;
        }

        if (cari) {
            opsi['cari'] = cari;
        }

        const parameter = new URLSearchParams(opsi).toString();

        if (urutanTerjual || cari) {
            url += `?${parameter}`;
        }

        document.location.assign(url)
    };

    formulirUrutanTerjual.on('submit', function (objekEvent) {
        handler(objekEvent, url);
    });

    formulirCariProduk.on('submit', function (objekEvent) {
        handler(objekEvent, url);
    });
});
