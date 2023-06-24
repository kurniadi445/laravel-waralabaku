'use strict';

$(function () {
    const formulirEditCabang = $('form[name="edit-cabang"]');

    const tombolBatal = $('#tombol-batal');

    formulirEditCabang.on('submit', function (objekEvent) {
        objekEvent.preventDefault();

        const tokenCSRF = $('meta[name="token-csrf"]').attr('content');
        const uuid = document.location.pathname.split('/')[4];
        const namaCabang = $('input[name="nama-cabang"]').val();
        const alamat = $('input[name="alamat"]').val();

        $.ajax(`${document.location.origin}/master/cabang/edit/${uuid}`, {
            data: {
                'nama-cabang': namaCabang,
                'alamat': alamat
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
                        text: 'Cabang berhasil diedit!',
                        title: 'Selamat'
                    }).then(function () {
                        document.location.assign(`${document.location.origin}/master/cabang`);
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
        document.location.assign(`${document.location.origin}/master/cabang`);
    });
});
