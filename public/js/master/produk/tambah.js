'use strict';

$(function () {
    const formulirTambahProduk = $('form[name="tambah-produk"]');

    const tombolBatal = $('#tombol-batal');

    formulirTambahProduk.on('submit', function (objekEvent) {
        objekEvent.preventDefault();

        const tokenCSRF = $('meta[name="token-csrf"]').attr('content');
        const namaProduk = $('input[name="nama-produk"]').val();
        const harga = $('input[name="harga"]').val();

        $.ajax(`${document.location.origin}/master/produk/tambah`, {
            data: {
                'nama-produk': namaProduk,
                'harga': harga
            },
            error: function () {
                swal({
                    icon: 'error',
                    text: 'Terjadi kesalahan!',
                    title: 'Maaf'
                });
            },
            headers: {
                'X-CSRF-TOKEN': tokenCSRF
            },
            method: 'POST',
            success: function (data) {
                const berhasil = data['berhasil'];

                if (berhasil) {
                    swal({
                        icon: 'success',
                        text: 'Produk berhasil ditambah!',
                        title: 'Selamat'
                    }).then(function () {
                        document.location.assign(`${document.location.origin}/master/produk`);
                    });
                } else {
                    swal({
                        icon: 'error',
                        text: 'Produk gagal ditambah!',
                        title: 'Maaf'
                    });
                }
            }
        });
    });

    tombolBatal.on('click', function () {
        document.location.assign(`${document.location.origin}/master/produk`);
    });
});
