var KTCardsReport = {
    init: function (tahun) {
        var element = document.getElementById('kt_apexcharts_5');
        if (!element) return;

        var height = parseInt(KTUtil.css(element, 'height'));
        var labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
        var borderColor = KTUtil.getCssVariableValue('--bs-gray-200');
        var baseColor = KTUtil.getCssVariableValue('--bs-primary');
        var baseLightColor = KTUtil.getCssVariableValue('--bs-primary-light');
        var secondaryColor = KTUtil.getCssVariableValue('--bs-info');

        function formatMoneyShort(value) {
            if (value >= 1_000_000_000) return (value / 1_000_000_000).toFixed(1) + 'B';
            if (value >= 1_000_000) return (value / 1_000_000).toFixed(1) + 'M';
            if (value >= 1_000) return (value / 1_000).toFixed(1) + 'K';
            return value;
        }


        // Ambil data via Axios dari Laravel
        axios.get('/grafik-report-omzet/' + tahun)
            .then(function (response) {
                const res = response.data;

                const options = {
                    series: [
                        {
                            name: 'Omzet',
                            type: 'bar',
                            stacked: true,
                            data: res.omzet
                        },
                        {
                            name: 'Pemasukan',
                            type: 'bar',
                            stacked: true,
                            data: res.pemasukan
                        },
                        {
                            name: 'Pengeluaran',
                            type: 'area',
                            data: res.pengeluaran
                        }
                    ],
                    chart: {
                        fontFamily: 'inherit',
                        stacked: true,
                        height: height,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            stacked: true,
                            horizontal: false,
                            endingShape: 'rounded',
                            columnWidth: ['12%']
                        },
                    },
                    legend: {
                        show: true
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: res.labels,
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            style: {
                                colors: labelColor,
                                fontSize: '12px'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: labelColor,
                                fontSize: '12px'
                            },
                            formatter: function (val) {
                                return 'Rp' + formatMoneyShort(val);
                            }
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        style: {
                            fontSize: '12px'
                        },
                        y: {
                            formatter: function (val) {
                                return 'Rp ' + val.toLocaleString();
                            }
                        }
                    },
                    colors: [baseColor, secondaryColor, baseLightColor],
                    grid: {
                        borderColor: borderColor,
                        strokeDashArray: 4,
                        yaxis: {
                            lines: {
                                show: true
                            }
                        },
                        padding: {
                            top: 0,
                            right: 0,
                            bottom: 0,
                            left: 0
                        }
                    }
                };

                var chart = new ApexCharts(element, options);
                chart.render();
            });
    }
};

"undefined" != typeof module && (module.exports = KTCardsReport);

