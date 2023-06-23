'use strict';

$(function () {
    const formulirTambahCabang = $('form[name="tambah-cabang"]');

    const tombolBatal = $('#tombol-batal');

    formulirTambahCabang.on('submit', function (objekEvent) {
        objekEvent.preventDefault();

        const tokenCSRF = $('meta[name="token-csrf"]').attr('content');
        const namaCabang = $('input[name="nama-cabang"]').val();
        const alamat = $('input[name="alamat"]').val();

        $.ajax(`${document.location.origin}/master/cabang/tambah`, {
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
            method: 'POST',
            success: function (data) {
                const berhasil = data['berhasil'];

                if (berhasil) {
                    swal({
                        icon: 'success',
                        text: 'Cabang berhasil ditambah!',
                        title: 'Selamat'
                    }).then(function () {
                        document.location.assign(`${document.location.origin}/master/cabang`);
                    });
                } else {
                    swal({
                        icon: 'error',
                        text: 'Cabang gagal ditambah!',
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
