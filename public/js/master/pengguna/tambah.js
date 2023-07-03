'use strict';

$(function () {
    const formulirTambahPengguna = $('form[name="tambah-pengguna"]');

    const tombolBatal = $('#tombol-batal');

    formulirTambahPengguna.on('submit', function (objekEvent) {
        objekEvent.preventDefault();

        const tokenCSRF = $('meta[name="token-csrf"]').attr('content');
        const namaPengguna = $('input[name="nama-pengguna"]').val();
        const kataSandi = $('input[name="kata-sandi"]').val();
        const namaDepan = $('input[name="nama-depan"]').val();
        const namaBelakang = $('input[name="nama-belakang"]').val();
        const level = $('select[name="level"]').val();

        $.ajax(`${document.location.origin}/master/pengguna/tambah`, {
            data: {
                'nama-pengguna': namaPengguna,
                'kata-sandi': kataSandi,
                'nama-depan': namaDepan,
                'nama-belakang': namaBelakang,
                'level': level
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
                        text: 'Pengguna berhasil ditambah!',
                        title: 'Selamat'
                    }).then(function () {
                        document.location.assign(`${document.location.origin}/master/pengguna`);
                    });
                } else {
                    swal({
                        icon: 'error',
                        text: 'Pengguna gagal ditambah!',
                        title: 'Maaf'
                    });
                }
            }
        });
    });

    tombolBatal.on('click', function () {
        document.location.assign(`${document.location.origin}/master/pengguna`);
    });
});
