'use strict';

$(function () {
    const tombolHapus = $('.tombol-hapus');

    const modalHapusCabang = new bootstrap.Modal(document.getElementById('modal-hapus-cabang'));
    const badanModal = $('#badan-modal > p > strong');

    const tombolTutup = $('#tombol-tutup');
    const tombolYakin = $('#tombol-yakin');

    let uuid;

    tombolHapus.on('click', function (objekEvent) {
        objekEvent.preventDefault();

        const barisTabel = $(this).closest('tr');

        uuid = $(this).data('uuid');

        const namaCabang = barisTabel.find('td')[1].innerText;

        badanModal.text(namaCabang);

        modalHapusCabang.show();
    });

    tombolTutup.on('click', function () {
        modalHapusCabang.hide();
    });

    document.getElementById('modal-hapus-cabang').addEventListener('hidden.bs.modal', function () {
        uuid = undefined;

        badanModal.text('');
    });

    tombolYakin.on('click', function () {
        const tokenCSRF = $('meta[name="token-csrf"]').attr('content');

        $.ajax(`${document.location.origin}/master/cabang/hapus/${uuid}`, {
            error: function () {
                modalHapusCabang.hide();

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

                modalHapusCabang.hide();

                if (berhasil) {
                    swal({
                        icon: 'success',
                        text: 'Cabang berhasil dihapus!',
                        title: 'Selamat'
                    }).then(function () {
                        document.location.reload();
                    });
                } else {
                    swal({
                        icon: 'error',
                        text: 'Cabang gagal dihapus!',
                        title: 'Maaf'
                    });
                }
            }
        });
    });
});
