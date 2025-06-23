var KTCardsDailySales = {
    init: function () {
        !(function () {
            var e = document.getElementById("daily_sales_chart");
            if (e) {
                var t = parseInt(KTUtil.css(e, "height")),
                    a = KTUtil.getCssVariableValue("--bs-gray-500"),
                    l = KTUtil.getCssVariableValue("--bs-border-dashed-color"),
                    r = KTUtil.getCssVariableValue("--bs-primary"),
                    o = KTUtil.getCssVariableValue("--bs-gray-300"),
                    i = new ApexCharts(e, {
                        series: [
                            {
                                name: "Sales",
                                data: [],
                            },
                        ],
                        chart: {
                            fontFamily: "inherit",
                            type: "bar",
                            height: t,
                            toolbar: { show: !1 },
                            sparkline: { enabled: !0 },
                        },
                        plotOptions: {
                            bar: {
                                horizontal: !1,
                                columnWidth: ["55%"],
                                borderRadius: 6,
                            },
                        },
                        legend: { show: !1 },
                        dataLabels: { enabled: !1 },
                        stroke: { show: !0, width: 9, colors: ["transparent"] },
                        xaxis: {
                            axisBorder: { show: !1 },
                            axisTicks: { show: !1, tickPlacement: "between" },
                            labels: {
                                show: !1,
                                style: { colors: a, fontSize: "12px" },
                            },
                            crosshairs: { show: !1 },
                        },
                        yaxis: {
                            labels: {
                                show: !1,
                                style: { colors: a, fontSize: "12px" },
                            },
                        },
                        fill: { type: "solid" },
                        states: {
                            normal: { filter: { type: "none", value: 0 } },
                            hover: { filter: { type: "none", value: 0 } },
                            active: {
                                allowMultipleDataPointsSelection: !1,
                                filter: { type: "none", value: 0 },
                            },
                        },
                        tooltip: {
                            style: { fontSize: "12px" },
                            x: {
                                formatter: function (e) {
                                    return "Tanggal " + e;
                                },
                            },
                            y: {
                                formatter: function (e) {
                                    return e;
                                },
                            },
                        },
                        colors: [r, o],
                        grid: {
                            padding: { left: 10, right: 10 },
                            borderColor: l,
                            strokeDashArray: 4,
                            yaxis: { lines: { show: !0 } },
                        },
                    });
                setTimeout(function () {
                    i.render();
                    axios.get('/chart/daily-sales')
                        .then(function (response) {
                            const res = response.data;

                            i.updateOptions({
                                xaxis: {
                                    categories: res.labels, // ["2025-06-01", "2025-06-02", ...]
                                },
                                series: [{
                                    name: "Total Transaksi",
                                    data: res.data, // [5, 8, 3, ...]
                                }],
                            });
                        })
                        .catch(function (error) {
                            console.error("Gagal memuat data chart transaksi harian:", error);
                        });

                }, 300);
            }
        })();

        axios.get('/dashboard/daily-income')
            .then(function (response) {
                const data = response.data;

                // Format angka ke format ribuan
                const formatter = new Intl.NumberFormat({
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                });

                const totalSpan = document.getElementById("total-pendapatan-hari-ini");
                const badgeSpan = document.getElementById("pendapatan-percentage");

                if (totalSpan) {
                    totalSpan.textContent = formatter.format(data.today);
                }

                if (badgeSpan) {
                    let badgeClass = 'badge-light-success';
                    let iconClass = 'ki-arrow-up text-success';
                    let symbol = '+';

                    if (data.percentage < 0) {
                        badgeClass = 'badge-light-danger';
                        iconClass = 'ki-arrow-down text-danger';
                        symbol = '';
                    }

                    badgeSpan.className = 'badge ' + badgeClass + ' fs-base';
                    badgeSpan.innerHTML = `
                        <i class="ki-duotone ${iconClass} fs-5 ms-n1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        ${symbol}${data.percentage}%
                    `;
                }
            })
            .catch(function (error) {
                console.error("Gagal ambil data pendapatan harian:", error);
            });

    },
};
"undefined" != typeof module && (module.exports = KTCardsDailySales),
    KTUtil.onDOMContentLoaded(function () {
        KTCardsDailySales.init();
    });
