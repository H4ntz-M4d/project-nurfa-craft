var KTChartsMonthSales = (function () {
    var e = { self: null, rendered: !1 },
        t = function (e) {
            var t = document.getElementById("month-sales-chart");
            if (t) {
                var a = parseInt(KTUtil.css(t, "height")),
                    l = KTUtil.getCssVariableValue("--bs-gray-500"),
                    r = KTUtil.getCssVariableValue("--bs-border-dashed-color"),
                    o = KTUtil.getCssVariableValue("--bs-success");

                e.self = new ApexCharts(t, {
                    series: [{ name: "Pendapatan", data: [] }],
                    chart: {
                        fontFamily: "inherit",
                        type: "area",
                        height: a,
                        toolbar: { show: !1 },
                    },
                    fill: {
                        type: "gradient",
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.4,
                            opacityTo: 0,
                            stops: [0, 80, 100],
                        },
                    },
                    stroke: {
                        curve: "smooth",
                        width: 3,
                        colors: [o],
                    },
                    xaxis: {
                        categories: [],
                        labels: {
                            rotate: 0,
                            style: { colors: l, fontSize: "12px" },
                        },
                        axisBorder: { show: !1 },
                        axisTicks: { show: !1 },
                        crosshairs: {
                            position: "front",
                            stroke: { color: o, width: 1, dashArray: 3 },
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    yaxis: {
                        labels: {
                            style: { colors: l, fontSize: "12px" },
                            formatter: function (value) {
                                if (value >= 1000000) return (value / 1000000).toFixed(1) + 'M';
                                if (value >= 1000) return (value / 1000).toFixed(1) + 'K';
                                return value.toString();
                            }
                        }
                    },
                    tooltip: {
                        style: { fontSize: "12px" },
                        y: {
                            formatter: function (value) {
                                return "Rp " + value.toLocaleString("id-ID");
                            },
                        },
                    },
                    grid: {
                        borderColor: r,
                        strokeDashArray: 4,
                        yaxis: { lines: { show: !0 } },
                    },
                    markers: { strokeColor: o, strokeWidth: 3 },
                });

                // Render awal
                e.self.render();
                e.rendered = !0;

                axios.get('/chart/month-sales')
                    .then(function (response) {
                        const res = response.data;

                        e.self.updateOptions({
                            xaxis: {
                                categories: res.labels
                            },
                            series: [{
                                name: "Pendapatan",
                                data: res.data
                            }]
                        });

                        const formatter = new Intl.NumberFormat({
                            style: 'currency',
                            currency: 'IDR',
                            minimumFractionDigits: 0
                        });

                        // Update HTML
                        const span = document.getElementById('pendapatan-perbulan');
                        if (span && res.total !== undefined) {
                            span.textContent = formatter.format(res.total);
                        }
                    })
                    .catch(function (error) {
                        console.error("Gagal mengambil data chart penjualan bulanan:", error);
                    });

            }
        };
    return {
        init: function () {
            t(e),
                KTThemeMode.on("kt.thememode.change", function () {
                    e.rendered && e.self.destroy(), t(e);
                });
        },
    };
})();
"undefined" != typeof module && (module.exports = KTChartsMonthSales),
    KTUtil.onDOMContentLoaded(function () {
        KTChartsMonthSales.init();
    });
