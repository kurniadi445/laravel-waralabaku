'use strict';

$(function () {
    const kartuCariProduk = $('#kartu-cari-produk');
    const kartuHasilPencarian = $('#kartu-hasil-pencarian');

    const formulirCariProduk = $('form[name="cari-produk"]');

    const masukanNamaProduk = $('input[name="nama-produk"]');

    document.getElementById('modal-cari-produk').addEventListener('shown.bs.modal', function () {
        masukanNamaProduk.focus();
    });

    document.getElementById('modal-cari-produk').addEventListener('hidden.bs.modal', function () {
        masukanNamaProduk.val('');
        kartuCariProduk.parent().removeClass('mb-3');
        kartuHasilPencarian.parent().addClass('d-none');
    });

    formulirCariProduk.on('submit', function (objekEvent) {
        objekEvent.preventDefault();

        const namaProduk = encodeURIComponent(masukanNamaProduk.val());

        $.ajax(`${document.location.origin}/master/transaksi/data`, {
            data: {
                'nama-produk': namaProduk
            },
            error: function () {
                modalCariProduk.hide();

                swal({
                    icon: 'error',
                    text: 'Terjadi kesalahan!',
                    title: 'Maaf'
                });
            },
            success: function (data) {
                kartuCariProduk.parent().addClass('mb-3');
                kartuHasilPencarian.parent().removeClass('d-none');

                const badanTabelHasilPencarian = $('#tabel-hasil-pencarian tbody');

                badanTabelHasilPencarian.empty();

                if (data.length > 0) {
                    $.each(data, function (indeksPadaArray, nilai) {
                        const no = nilai['no'];
                        const uuid = nilai['uuid_teks'];
                        const namaProduk = nilai['nama_produk'];
                        const harga = nilai['harga'];

                        const barisTabel = $('<tr>');

                        $('<td>').addClass('text-center').text(no).appendTo(barisTabel);
                        $('<td>').text(namaProduk).appendTo(barisTabel);
                        $('<td>').addClass('text-end').text(harga).appendTo(barisTabel);

                        const ikonKeranjangBelanja = $('<i>').addClass('fa-cart-shopping fas');
                        const spanKeranjangBelanja = $('<span>').addClass('badge badge-success').prepend(ikonKeranjangBelanja);
                        const pranalaAksi = $('<a>').addClass('tombol-keranjang-belanja').attr({
                            'data-uuid': uuid,
                            'data-harga': harga,
                            'href': '#'
                        }).prepend(spanKeranjangBelanja);

                        $('<td>').addClass('text-center').prepend(pranalaAksi).appendTo(barisTabel);

                        barisTabel.appendTo(badanTabelHasilPencarian);
                    });

                    const tombolKeranjangBelanja = $('.tombol-keranjang-belanja');

                    tombolKeranjangBelanja.on('click', function (objekEvent) {
                        objekEvent.preventDefault();

                        const barisTabel = $(this).closest('tr');
                        const selDataTabel = barisTabel.find('td');

                        const uuid = $(this).data('uuid');
                        const namaProduk = selDataTabel[1].innerHTML;
                        const kuantitas = 1;
                        const harga = $(this).data('harga');

                        const permintaan = window.indexedDB.open('waralabaku', 1);

                        permintaan.addEventListener('upgradeneeded', function (event) {
                            const db = event.target.result;

                            db.createObjectStore('produk', {
                                keyPath: 'uuid'
                            });
                        });

                        permintaan.addEventListener('success', function (event) {
                            const db = event.target.result;
                            const transaksi = db.transaction('produk', 'readwrite');
                            const penyimpananObjek = transaksi.objectStore('produk');

                            penyimpananObjek.add({
                                'uuid': uuid,
                                'nama_produk': namaProduk,
                                'kuantitas': kuantitas,
                                'harga': harga
                            });

                            transaksi.addEventListener('complete', function () {
                                db.close();

                                masukanNamaProduk.val('');

                                document.location.reload();
                            });
                        });
                    });
                } else {
                    const barisTabel = $('<tr>').addClass('text-center');

                    $('<td>').attr('colspan', 4).text('Tidak ada data yang tersedia').appendTo(barisTabel);

                    barisTabel.appendTo(badanTabelHasilPencarian);
                }
            }
        });
    });
});
