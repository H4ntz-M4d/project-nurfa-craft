var KTCardsProdukTerlaris = {
    init: function (tahun) {
        var element = document.getElementById('produk-terlaris');
        if (!element) return;

        var borderColor = KTUtil.getCssVariableValue('--bs-gray-200');
        var labelColor = KTUtil.getCssVariableValue('--bs-gray-500');

        axios.get('/grafik-produk-terlaris/' + tahun)
            .then(function (res) {
                var options = {
                    series: [{
                        name: 'Total Terjual',
                        data: res.data.data
                    }],
                    chart: {
                        type: 'bar',
                        height: 350,
                        toolbar: { show: false }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '45%',
                            endingShape: 'rounded',
                            borderRadius: 6,
                            distributed: true
                        },
                    },
                    dataLabels: { enabled: false },
                    xaxis: {
                        categories: res.data.labels,
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            rotate: -45,
                            style: {
                                colors: labelColor,
                                fontSize: '12px'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            formatter: val => val + 'x'
                        },
                        title: { text: 'Jumlah Terjual' }
                    },
                    tooltip: {
                        y: {
                            formatter: val => val + ' produk'
                        }
                    },
                    colors: [
                        '#0d6efd', '#ffc107',
                        '#6f42c1', '#fd7e14', '#20c997', '#0dcaf0',
                        '#6610f2', '#d63384', '#198754', '#dc3545'
                    ],
                    grid: {
                        borderColor: borderColor,
                        strokeDashArray: 4,
                        yaxis: {
                            lines: { show: true }
                        },
                        padding: { top: 0, right: 0, bottom: 0, left: 0 }
                    }
                };

                var chart = new ApexCharts(element, options);
                chart.render();
            });
    }
};

"undefined" != typeof module && (module.exports = KTCardsProdukTerlaris);
