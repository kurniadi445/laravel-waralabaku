'use strict';

let modalCariProduk;

$(function () {
    const tombolCariProduk = $('#tombol-cari-produk');

    modalCariProduk = new bootstrap.Modal(document.getElementById('modal-cari-produk'));

    const tombolTutup = $('#tombol-tutup');

    const permintaan = window.indexedDB.open('waralabaku', 1);

    tombolCariProduk.on('click', function () {
        modalCariProduk.show();
    });

    tombolTutup.on('click', function () {
        modalCariProduk.hide();
    });

    permintaan.addEventListener('upgradeneeded', function (event) {
        const db = event.target.result;

        db.createObjectStore('produk', {
            keyPath: 'uuid'
        });
    });

    permintaan.addEventListener('success', function (event) {
        const db = event.target.result;
        const transaksi = db.transaction('produk', 'readonly');
        const penyimpananObjek = transaksi.objectStore('produk');
        const hitungPermintaan = penyimpananObjek.count();

        hitungPermintaan.addEventListener('success', function () {
            const tabelDetailTransaksi = $('#tabel-detail-transaksi');

            const masukanTotal = $('input[name="total"]');

            if (hitungPermintaan.result > 0) {
                let iterasi = 1;
                let total = 0;

                penyimpananObjek.openCursor().addEventListener('success', function (event) {
                    const kursor = event.target.result;

                    if (kursor) {
                        const uuid = kursor.value.uuid;
                        const namaProduk = kursor.value.nama_produk;
                        const kuantitas = kursor.value.kuantitas;
                        const harga = kursor.value.harga;
                        const subtotal = kuantitas * harga;

                        total += subtotal;

                        const barisTabel = $('<tr>');

                        $('<td>').addClass('text-center').text(iterasi).appendTo(barisTabel);
                        $('<td>').text(namaProduk).appendTo(barisTabel);

                        const masukanKuantitas = $('<input>').addClass('form-control').attr({
                            'data-uuid': uuid,
                            'name': 'kuantitas',
                            'type': 'number'
                        }).val(kuantitas);

                        $('<td>').prepend(masukanKuantitas).appendTo(barisTabel);
                        $('<td>').addClass('text-end').text(harga).appendTo(barisTabel);
                        $('<td>').addClass('text-end').text(subtotal).appendTo(barisTabel);

                        const ikonTandaX = $('<i>').addClass('fa-xmark fas');
                        const spanTandaX = $('<span>').addClass('badge badge-danger').prepend(ikonTandaX);
                        const pranalaAksi = $('<a>').addClass('tombol-tanda-x').attr({
                            'data-uuid': uuid,
                            'href': '#'
                        }).prepend(spanTandaX);

                        $('<td>').addClass('text-center').prepend(pranalaAksi).appendTo(barisTabel);

                        barisTabel.appendTo(tabelDetailTransaksi);

                        iterasi++;

                        kursor.continue();
                    } else {
                        const masukanKuantitas = $('input[name="kuantitas"]');

                        const tombolTandaX = $('.tombol-tanda-x');

                        masukanKuantitas.on('change', function () {
                            const barisTabel = $(this).closest('tr');

                            const uuid = $(this).data('uuid');
                            const namaProduk = barisTabel.find('td')[1].innerText;
                            const kuantitas = $(this).val();
                            const harga = barisTabel.find('td')[3].innerText;
                            const subtotal = kuantitas * harga;

                            const transaksi = db.transaction('produk', 'readwrite');

                            transaksi.objectStore('produk').put({
                                'uuid': uuid,
                                'nama_produk': namaProduk,
                                'kuantitas': kuantitas,
                                'harga': harga
                            });

                            transaksi.addEventListener('complete', function () {
                                barisTabel.find('td')[4].innerText = subtotal;

                                let total = 0;

                                const transaksi = db.transaction('produk', 'readonly');
                                const penyimpananObjek = transaksi.objectStore('produk');

                                penyimpananObjek.openCursor().addEventListener('success', function (event) {
                                    const kursor = event.target.result;

                                    if (kursor) {
                                        const kuantitas = kursor.value.kuantitas;
                                        const harga = kursor.value.harga;
                                        const subtotal = kuantitas * harga;

                                        total += subtotal;

                                        kursor.continue();
                                    } else {
                                        masukanTotal.val(total);
                                    }
                                });
                            });
                        });

                        tombolTandaX.on('click', function (objekEvent) {
                            objekEvent.preventDefault();

                            const uuid = $(this).data('uuid');

                            const transaksi = db.transaction('produk', 'readwrite');

                            transaksi.objectStore('produk').delete(uuid);

                            transaksi.addEventListener('complete', function () {
                                db.close();

                                document.location.reload();
                            });
                        });

                        masukanTotal.val(total);
                    }
                });
            } else {
                const barisTabel = $('<tr>').addClass('text-center');

                $('<td>').attr('colspan', 6).text('Tidak ada data yang tersedia').appendTo(barisTabel);

                barisTabel.appendTo(tabelDetailTransaksi);

                masukanTotal.val(0);
            }
        });
    });
});
