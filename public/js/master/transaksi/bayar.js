'use strict';

$(function () {
    const tombolBayar = $('#tombol-bayar');

    tombolBayar.on('click', function () {
        const keranjangBelanja = [];

        const permintaan = window.indexedDB.open('waralabaku', 1);

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

            penyimpananObjek.openCursor().addEventListener('success', function (event) {
                const kursor = event.target.result;

                if (kursor) {
                    const uuid = kursor.value.uuid;
                    const kuantitas = kursor.value.kuantitas;

                    keranjangBelanja.push({
                        'uuid': uuid,
                        'kuantitas': kuantitas
                    });

                    kursor.continue();
                } else {
                    const tokenCSRF = $('meta[name="token-csrf"]').attr('content');

                    $.ajax(`${document.location.origin}/master/transaksi`, {
                        data: {
                            'keranjang-belanja': keranjangBelanja
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

                            modalCariProduk.hide();

                            if (berhasil) {
                                const transaksi = db.transaction('produk', 'readwrite');
                                const penyimpananObjek = transaksi.objectStore('produk');
                                const permintaanPenyimpananObjek = penyimpananObjek.clear();

                                permintaanPenyimpananObjek.addEventListener('success', function () {
                                    swal({
                                        icon: 'success',
                                        text: 'Transaksi berhasil ditambah!',
                                        title: 'Selamat'
                                    }).then(function () {
                                        document.location.reload();
                                    });
                                });
                            } else {
                                swal({
                                    icon: 'error',
                                    text: 'Transaksi gagal dihapus!',
                                    title: 'Maaf'
                                });
                            }
                        }
                    });
                }
            });
        });
    });
});
