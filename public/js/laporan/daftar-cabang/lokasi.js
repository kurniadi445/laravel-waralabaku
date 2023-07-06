'use strict';

$(function () {
    const uuid = document.location.pathname.split('/')[4];

    $.ajax(`${document.location.origin}/laporan/daftar-cabang/lokasi/${uuid}/data`, {
        error: function () {
            swal({
                icon: 'error',
                text: 'Terjadi kesalahan!',
                title: 'Maaf'
            });
        },
        success: function (data) {
            const garisLintang = data['garis_lintang'];
            const garisBujur = data['garis_bujur'];

            let koordinat = [garisLintang || -0.789275, garisBujur || 113.921327];

            const opsi = {
                center: koordinat
            };

            opsi.zoom = garisLintang && garisBujur ? 13 : 3;

            const lokasi = L.map('lokasi', opsi);
            const penanda = L.marker(koordinat).addTo(lokasi);

            lokasi.on('mouseover', function () {
                lokasi._container.style.cursor = 'default';
            });

            lokasi.on('movestart', function () {
                lokasi._container.style.cursor = 'grabbing';
            });

            lokasi.on('moveend', function () {
                lokasi._container.style.cursor = 'default';
            });

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                maxZoom: 19
            }).addTo(lokasi);
        }
    });
});
