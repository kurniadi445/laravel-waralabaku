'use strict';

let connectCabang

$(function () {
    const kartuCariCabang = $('#kartu-cari-cabang');
    const kartuHasilPencarian = $('#kartu-hasil-pencarian');

    const formulirCariCabang = $('form[name="cari-cabang"]');

    const masukanNamaCabang = $('input[name="nama-cabang"]');

    connectCabang = [];

    document.getElementById('modal-connect-cabang').addEventListener('shown.bs.modal', function () {
        masukanNamaCabang.focus();
    });

    document.getElementById('modal-connect-cabang').addEventListener('hidden.bs.modal', function () {
        masukanNamaCabang.val('');
        kartuCariCabang.parent().removeClass('mb-3');
        kartuHasilPencarian.parent().addClass('d-none');
    });

    formulirCariCabang.on('submit', function (objekEvent) {
        objekEvent.preventDefault();

        const namaCabang = encodeURIComponent(masukanNamaCabang.val());

        $.ajax(`${document.location.origin}/master/pengguna/tambah/data`, {
            data: {
                'nama-cabang': namaCabang
            },
            error: function () {
                modalConnectCabang.hide();

                swal({
                    icon: 'error',
                    text: 'Terjadi kesalahan!',
                    title: 'Maaf'
                });
            },
            success: function (data) {
                kartuCariCabang.parent().addClass('mb-3');
                kartuHasilPencarian.parent().removeClass('d-none');

                const badanTabelHasilPencarian = $('#tabel-hasil-pencarian tbody');

                badanTabelHasilPencarian.empty();

                if (data.length > 0) {
                    $.each(data, function (indeksPadaArray, nilai) {
                        const no = nilai['no'];
                        const uuid = nilai['uuid_teks'];
                        const namaCabang = nilai['nama_cabang'];

                        const barisTabel = $('<tr>');

                        $('<td>').addClass('text-center').text(no).appendTo(barisTabel);
                        $('<td>').text(namaCabang).appendTo(barisTabel);

                        let ikon = $('<i>');
                        let span = $('<span>');
                        let pranalaAksi = $('<a>').addClass('tombol');

                        const cariIndeks = connectCabang.findIndex(function (elemen) {
                            return elemen === uuid;
                        });

                        if (cariIndeks !== -1) {
                            ikon = ikon.addClass('fa-xmark fas');
                            span = span.addClass('badge badge-danger').prepend(ikon);
                            pranalaAksi = pranalaAksi.addClass('tombol-tanda-x');
                        } else {
                            ikon = ikon.addClass('fa-paperclip fas');
                            span = span.addClass('badge badge-success').prepend(ikon);
                        }

                        pranalaAksi = pranalaAksi.attr({
                            'data-uuid': uuid,
                            'href': '#'
                        }).prepend(span);

                        $('<td>').addClass('text-center').prepend(pranalaAksi).appendTo(barisTabel);

                        barisTabel.appendTo(badanTabelHasilPencarian);
                    });

                    const tombol = $('.tombol');

                    tombol.on('click', function (objekEvent) {
                        objekEvent.preventDefault();

                        const pranalaAksi = $(this);
                        const span = pranalaAksi.children();
                        const ikon = span.children();

                        const uuid = pranalaAksi.data('uuid');

                        if (pranalaAksi.hasClass('tombol-tanda-x')) {
                            pranalaAksi.removeClass('tombol-tanda-x');
                            span.removeClass('badge-danger').addClass('badge-success');
                            ikon.removeClass('fa-xmark').addClass('fa-paperclip');

                            const cariIndeks = connectCabang.findIndex(function (elemen) {
                                return elemen === uuid;
                            });

                            if (cariIndeks !== -1) {
                                connectCabang.splice(cariIndeks, 1);
                            }
                        } else {
                            pranalaAksi.addClass('tombol-tanda-x');
                            span.removeClass('badge-success').addClass('badge-danger');
                            ikon.removeClass('fa-paperclip').addClass('fa-xmark');

                            connectCabang.push(uuid);
                        }
                    });
                } else {
                    const barisTabel = $('<tr>').addClass('text-center');

                    $('<td>').attr('colspan', 3).text('Tidak ada data yang tersedia').appendTo(barisTabel);

                    barisTabel.appendTo(badanTabelHasilPencarian);
                }
            }
        });
    });
});
