'use strict';

$(function () {
    const tipe = encodeURIComponent('lokasi cabang');

    $.ajax(`${document.location.origin}/data`, {
        data: {
            'tipe': tipe
        },
        error: function () {
            swal({
                icon: 'error',
                text: 'Terjadi kesalahan!',
                title: 'Maaf'
            });
        },
        success: function (data) {
            const koordinat = [-0.789275, 113.921327];

            const lokasiCabang = L.map('lokasi-cabang', {
                center: koordinat,
                zoom: 3
            });

            data.forEach(function (elemen) {
                const garisLintang = elemen['garis_lintang'];
                const garisBujur = elemen['garis_bujur'];

                if (garisLintang && garisBujur) {
                    const namaCabang = elemen['nama_cabang'];

                    const koordinat = [garisLintang, garisBujur];

                    const penanda = L.marker(koordinat).addTo(lokasiCabang);

                    penanda.bindPopup(namaCabang);
                }
            });

            lokasiCabang.on('mouseover', function () {
                lokasiCabang._container.style.cursor = 'default';
            });

            lokasiCabang.on('movestart', function () {
                lokasiCabang._container.style.cursor = 'grabbing';
            });

            lokasiCabang.on('moveend', function () {
                lokasiCabang._container.style.cursor = 'default';
            });

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                maxZoom: 19
            }).addTo(lokasiCabang);
        }
    });
});
