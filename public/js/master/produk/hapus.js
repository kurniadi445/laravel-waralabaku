'use strict';

$(function () {
    const tombolHapus = $('.tombol-hapus');

    const modalHapusProduk = new bootstrap.Modal(document.getElementById('modal-hapus-produk'));
    const badanModal = $('#badan-modal > p > strong');

    const tombolTutup = $('#tombol-tutup');
    const tombolYakin = $('#tombol-yakin');

    let uuid;

    tombolHapus.on('click', function (objekEvent) {
        objekEvent.preventDefault();

        const barisTabel = $(this).closest('tr');

        uuid = $(this).data('uuid');

        const namaProduk = barisTabel.find('td')[1].innerText;

        badanModal.text(namaProduk);

        modalHapusProduk.show();
    });

    tombolTutup.on('click', function () {
        modalHapusProduk.hide();
    });

    document.getElementById('modal-hapus-produk').addEventListener('hidden.bs.modal', function () {
        uuid = undefined;

        badanModal.text('');
    });

    tombolYakin.on('click', function () {
        const tokenCSRF = $('meta[name="token-csrf"]').attr('content');

        $.ajax(`${document.location.origin}/master/produk/hapus/${uuid}`, {
            error: function () {
                modalHapusProduk.hide();

                swal({
                    icon: 'error',
                    text: 'Terjadi kesalahan!',
                    title: 'Maaf'
                });
            },
            headers: {
                'X-CSRF-TOKEN': tokenCSRF
            },
            method: 'DELETE',
            success: function (data) {
                const berhasil = data['berhasil'];

                modalHapusProduk.hide();

                if (berhasil) {
                    swal({
                        icon: 'success',
                        text: 'Produk berhasil dihapus!',
                        title: 'Selamat'
                    }).then(function () {
                        document.location.reload();
                    });
                } else {
                    swal({
                        icon: 'error',
                        text: 'Produk gagal dihapus!',
                        title: 'Maaf'
                    });
                }
            }
        });
    });
});
