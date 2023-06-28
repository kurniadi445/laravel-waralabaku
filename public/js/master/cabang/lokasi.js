'use strict';

$(function () {
    const uuid = document.location.pathname.split('/')[4];

    $.ajax(`${document.location.origin}/master/cabang/lokasi/${uuid}/data`, {
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

            let penanda;

            if (garisLintang && garisBujur) {
                penanda = L.marker(koordinat).addTo(lokasi);
            }

            lokasi.on('mouseover', function () {
                lokasi._container.style.cursor = 'default';
            });

            lokasi.on('dblclick', function (e) {
                if (penanda) {
                    lokasi.removeLayer(penanda);
                }

                koordinat = e.latlng;

                const garisLintang = koordinat.lat;
                const garisBujur = koordinat.lng;

                koordinat = [garisLintang, garisBujur];

                penanda = L.marker(koordinat).addTo(lokasi);

                console.log(koordinat);

                const tokenCSRF = $('meta[name="token-csrf"]').attr('content');

                $.ajax(`${document.location.origin}/master/cabang/lokasi/${uuid}`, {
                    data: {
                        'garis-bujur': garisBujur,
                        'garis-lintang': garisLintang
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
                    success: function () {
                        swal({
                            icon: 'success',
                            text: 'Lokasi berhasil diedit!',
                            title: 'Selamat'
                        });
                    }
                });
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
