"use strict";
var KTTransactionsList = (function () {
    var t, e;
    let startDate = null;
    let endDate = null;


    return {
        init: function () {
            e = document.querySelector("#kt_transaksi_record_table");
            if (!e) return;

            t = $(e).DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/transactions-data",
                    data: function (d) {
                        if (startDate && endDate) {
                            d.start = startDate;
                            d.end = endDate;
                        }

                    }
                },
                columns: [
                    { data: 'nama_user' },
                    { data: 'email_user' },
                    { data: 'order_id', class: 'text-center' },
                    { data: 'tanggal' },
                    { data: 'total' },
                    { data: 'action' },
                ],
                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-slug', data.slug);
                },
                order: [],
                columnDefs: [
                    { targets: 0, orderable: false },
                    { targets: -1, orderable: false },
                ],
            });

            // Daterangepicker init
            (() => {
                var t0 = moment().startOf("month"),
                    t1 = moment();
                const $picker = $("#kt_ecommerce_report_customer_orders_daterangepicker");

                function updateRange(t0, t1) {
                    $picker.html(t0.format("MMMM D, YYYY") + " - " + t1.format("MMMM D, YYYY"));
                    startDate = t0.format('YYYY-MM-DD');
                    endDate = t1.format('YYYY-MM-DD');
                    t.ajax.reload();
                }

                $picker.daterangepicker(
                    {
                        startDate: t0,
                        endDate: t1,
                        ranges: {
                            Today: [moment(), moment()],
                            Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
                            "Last 7 Days": [moment().subtract(6, "days"), moment()],
                            "Last 30 Days": [moment().subtract(29, "days"), moment()],
                            "This Month": [moment().startOf("month"), moment().endOf("month")],
                            "Last Month": [
                                moment().subtract(1, "month").startOf("month"),
                                moment().subtract(1, "month").endOf("month")
                            ],
                        }
                    },
                    updateRange
                );

                $picker.on('apply.daterangepicker', function (ev, picker) {
                    updateRange(picker.startDate, picker.endDate);
                });
            })();

            // Export Buttons
            (() => {
                const e = "Laporan Transaksi";
                new $.fn.dataTable.Buttons(t, {
                    buttons: [
                        {
                            extend: "copyHtml5",
                            title: e,
                            exportOptions: { columns: [0, 1, 2, 3, 4] }
                        },
                        {
                            extend: "excelHtml5",
                            title: e,
                            exportOptions: { columns: [0, 1, 2, 3, 4] }
                        },
                        {
                            extend: "csvHtml5",
                            title: e,
                            exportOptions: { columns: [0, 1, 2, 3, 4] }
                        },
                        {
                            extend: "pdfHtml5",
                            title: e,
                            exportOptions: { columns: [0, 1, 2, 3, 4] }
                        },
                    ]
                }).container().appendTo($("#kt_transactions_report_views_export"));

                document.querySelectorAll("#kt_transactions_report_views_export_menu [data-kt-transactions-export]").forEach((el) => {
                    el.addEventListener("click", (e) => {
                        e.preventDefault();
                        const type = el.getAttribute("data-kt-transactions-export");
                        document.querySelector(".dt-buttons .buttons-" + type).click();
                    });
                });
            })();

            // Search input
            document.querySelector('[data-kt-transactions-table-filter="search"]')
                .addEventListener("keyup", function (event) {
                    t.search(event.target.value).draw();
                });
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTTransactionsList.init();
});
