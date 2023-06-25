'use strict';

$(function () {
    const grafikRingkasanPendapatan = new Chart(document.getElementById('grafik-ringkasan-pendapatan'), {
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [
                {
                    backgroundColor: 'rgba(78, 115, 223, 0.05)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    data: [],
                    label: 'Pendapatan',
                    lineTension: 0.3,
                    pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointBorderColor: 'rgba(78, 115, 223, 1)',
                    pointBorderWidth: 2,
                    pointHitRadius: 10,
                    pointHoverBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                    pointHoverRadius: 3,
                    pointRadius: 3
                }
            ],
        },
        options: {
            layout: {
                padding: {
                    bottom: 0,
                    left: 10,
                    right: 25,
                    top: 25
                }
            },
            legend: {
                display: false
            },
            maintainAspectRatio: false,
            scales: {
                xAxes: [
                    {
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        },
                        time: {
                            unit: 'date'
                        }
                    }
                ],
                yAxes: [
                    {
                        gridLines: {
                            borderDash: [2],
                            color: 'rgb(234, 236, 244)',
                            drawBorder: false,
                            zeroLineBorderDash: [2],
                            zeroLineColor: 'rgb(234, 236, 244)'
                        },
                        ticks: {
                            callback: function (nilai) {
                                return new Intl.NumberFormat('id-ID', {
                                    currency: 'IDR',
                                    maximumFractionDigits: 0,
                                    style: 'currency'
                                }).format(nilai);
                            },
                            maxTicksLimit: 5,
                            padding: 10
                        }
                    }
                ],
            },
            tooltips: {
                backgroundColor: 'rgb(255,255,255)',
                bodyFontColor: '#858796',
                borderColor: '#dddfeb',
                borderWidth: 1,
                callbacks: {
                    label: function (itemTooltip, data) {
                        let label = data.datasets[itemTooltip.datasetIndex].label || '';

                        if (label) {
                            label += ': ';
                        }

                        label += new Intl.NumberFormat('id-ID', {
                            currency: 'IDR',
                            maximumFractionDigits: 0,
                            style: 'currency'
                        }).format(itemTooltip.yLabel);

                        return label;
                    }
                },
                caretPadding: 10,
                displayColors: false,
                intersect: false,
                mode: 'index',
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                titleMarginBottom: 10,
                xPadding: 15,
                yPadding: 15
            }
        },
        type: 'line'
    });

    const tipe = encodeURIComponent('ringkasan pendapatan');

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
            grafikRingkasanPendapatan.data.datasets[0].data = data.reduce(function (pengakumulasi, nilaiSekarang) {
                pengakumulasi.push(nilaiSekarang['total']);

                return pengakumulasi;
            }, []);

            grafikRingkasanPendapatan.update();
        }
    });
});
