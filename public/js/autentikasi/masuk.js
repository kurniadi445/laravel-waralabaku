'use strict';

$(function () {
    const formulirMasuk = $('form[name="masuk"]');

    formulirMasuk.on('submit', function (objekEvent) {
        objekEvent.preventDefault();

        const tokenCSRF = $('meta[name="token-csrf"]').attr('content');
        const namaPengguna = $('input[name="nama-pengguna"]').val();
        const kataSandi = $('input[name="kata-sandi"]').val();

        $.ajax(`${document.location.origin}/autentikasi/masuk`, {
            data: {
                'nama-pengguna': namaPengguna,
                'kata-sandi': kataSandi
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
                        text: 'Berhasil masuk!',
                        title: 'Selamat'
                    }).then(function () {
                        document.location.assign(document.location.origin);
                    });
                } else {
                    swal({
                        icon: 'error',
                        text: 'Gagal masuk!',
                        title: 'Maaf'
                    });
                }
            }
        });
    });
});
