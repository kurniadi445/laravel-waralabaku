'use strict';

$(function () {
    const tombolEdit = $('.tombol-edit');

    tombolEdit.on('click', function (objekEvent) {
        objekEvent.preventDefault();

        const barisTabel = $(this).closest('tr');

        const uuid = $(this).data('uuid');
        const stok = barisTabel.find('td')[2].innerText;

        const masukanKuantitas = document.createElement('input');

        masukanKuantitas.classList.add('form-control');
        masukanKuantitas.setAttribute('name', 'stok');
        masukanKuantitas.setAttribute('type', 'number');
        masukanKuantitas.setAttribute('value', stok);

        barisTabel.find('td')[2].innerHTML = masukanKuantitas.outerHTML;

        document.querySelectorAll('input[name="stok"]').forEach(function (elemen) {
            let waktuHabis;

            elemen.addEventListener('change', function () {
                clearTimeout(waktuHabis);

                const masukanKuantitas = this;

                waktuHabis = setTimeout(function () {
                    const tokenCSRF = $('meta[name="token-csrf"]').attr('content');
                    const stok = masukanKuantitas.value;

                    $.ajax(`${document.location.origin}/master/stok`, {
                        data: {
                            'uuid': uuid,
                            'stok': stok
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
                                    text: 'Stok berhasil diedit!',
                                    title: 'Selamat'
                                }).then(function () {
                                    document.location.reload();
                                });
                            } else {
                                swal({
                                    icon: 'error',
                                    text: 'Stok gagal diedit!',
                                    title: 'Maaf'
                                });
                            }
                        }
                    });
                }, 2000);
            });
        });
    });
});
