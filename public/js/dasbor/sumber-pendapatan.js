'use strict';

$(function () {
    const grafikSumberPendapatan = new Chart(document.getElementById('grafik-sumber-pendapatan'), {
        data: {
            labels: [],
            datasets: [
                {
                    backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                    data: [],
                    hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
                    hoverBorderColor: 'rgba(234, 236, 244, 1)'
                }
            ]
        },
        options: {
            cutoutPercentage: 80,
            legend: {
                display: false
            },
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: 'rgb(255,255,255)',
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                caretPadding: 10,
                displayColors: false,
                xPadding: 15,
                yPadding: 15
            }
        },
        type: 'doughnut'
    });

    const tipe = encodeURIComponent('sumber pendapatan');

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
            grafikSumberPendapatan.data.labels = data.reduce(function (pengakumulasi, nilaiSekarang) {
                pengakumulasi.push(nilaiSekarang['nama_cabang']);

                return pengakumulasi;
            }, []);

            grafikSumberPendapatan.data.datasets[0].data = data.reduce(function (pengakumulasi, nilaiSekarang) {
                pengakumulasi.push(nilaiSekarang['jumlah_transaksi']);

                return pengakumulasi;
            }, []);

            grafikSumberPendapatan.update();
        }
    });
});
