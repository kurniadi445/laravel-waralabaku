'use strict';

$(function () {
    const formulirEditProduk = $('form[name="edit-produk"]');

    const tombolBatal = $('#tombol-batal');

    formulirEditProduk.on('submit', function (objekEvent) {
        objekEvent.preventDefault();

        const tokenCSRF = $('meta[name="token-csrf"]').attr('content');
        const uuid = document.location.pathname.split('/')[4];
        const namaProduk = $('input[name="nama-produk"]').val();
        const harga = $('input[name="harga"]').val();

        $.ajax(`${document.location.origin}/master/produk/edit/${uuid}`, {
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
            method: 'PUT',
            success: function (data) {
                const berhasil = data['berhasil'];

                if (berhasil) {
                    swal({
                        icon: 'success',
                        text: 'Produk berhasil diedit!',
                        title: 'Selamat'
                    }).then(function () {
                        document.location.assign(`${document.location.origin}/master/produk`);
                    });
                } else {
                    swal({
                        icon: 'error',
                        text: 'Produk gagal diedit!',
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
