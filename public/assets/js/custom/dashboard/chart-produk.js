var KTCardProdukCount = {
    init: function () {
        axios.get('/dashboard/produk-stat')
            .then(function (response) {
                const data = response.data;
                const formatter = new Intl.NumberFormat('id-ID');

                // Update angka total produk
                document.getElementById('total-produk').textContent = formatter.format(data.total);

                // Pie chart with ApexCharts
                var chartOptions = {
                    chart: {
                        type: 'donut',
                        height: 150
                    },
                    labels: [
                        data.kategori1?.nama_kategori || 'Kategori 1',
                        data.kategori2?.nama_kategori || 'Kategori 2',
                        'Others'
                    ],
                    series: [
                        data.kategori1?.jumlah || 0,
                        data.kategori2?.jumlah || 0,
                        data.others || 0
                    ],
                    colors: [
                        KTUtil.getCssVariableValue("--bs-danger"),
                        KTUtil.getCssVariableValue("--bs-primary"),
                        KTUtil.getCssVariableValue("--bs-info"),
                    ],
                    legend: {
                        show: false,
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function (val, opts) {
                            return formatter.format(opts.w.config.series[opts.seriesIndex]);
                        }
                    }
                };

                var chart = new ApexCharts(document.querySelector("#produk_total_count"), chartOptions);
                chart.render();

            })
            .catch(function (error) {
                console.error("Gagal ambil data produk:", error);
            });
    }
};
"undefined" != typeof module && (module.exports = KTCardProdukCount),
    KTUtil.onDOMContentLoaded(function () {
        KTCardProdukCount.init();
    });
