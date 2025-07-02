"use strict";
var KTReportOmzetList = (function () {
    var t, e;

    return {
        init: function () {
            e = document.querySelector("#kt_report_omzet_table");

            if (!e) return;

            t = $(e).DataTable({
                processing: true,
                serverSide: false,
                ajax: "/report-omset-tahunan/data",
                columns: [
                    { data: 'tahun', class:'text-center' },
                    { data: 'pemasukan', class:'text-center' },
                    { data: 'pengeluaran', class:'text-center' },
                    { data: 'ongkos_kirim', class:'text-center' },
                    { data: 'omzet_tahunan', class:'text-center' },
                    { data: 'action', class:'text-center' },
                ],createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-slug', data.slug); // penting agar row.dataset.slug bisa dipakai
                },                
                order: [],
                columnDefs: [
                    { targets: 0, orderable: false },
                    { targets: -1, orderable: false },
                ],
            });

            (() => {
                const e = "Laporan Transaksi";
                new $.fn.dataTable.Buttons(t, {
                    buttons: [
                        {
                            extend: "copyHtml5",
                            title: e,
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4] // tanpa kolom action
                            }
                        },
                        {
                            extend: "excelHtml5",
                            title: e,
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4]
                            }
                        },
                        {
                            extend: "csvHtml5",
                            title: e,
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4]
                            }
                        },
                        {
                            extend: "pdfHtml5",
                            title: e,
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4]
                            }
                        },
                    ],

                })
                    .container()
                    .appendTo($("#kt_transactions_report_views_export")),
                    document
                        .querySelectorAll(
                            "#kt_transactions_report_views_export_menu [data-kt-transactions-export]"
                        )
                        .forEach((t) => {
                            t.addEventListener("click", (t) => {
                                t.preventDefault();
                                const e = t.target.getAttribute("data-kt-transactions-export");
                                document.querySelector(".dt-buttons .buttons-" + e).click();
                            });
                        });
            })(),

            t.on("draw", function () {
                KTMenu.createInstances(); // dropdown dari template
                
            });

            // Search input
            document.querySelector('[data-kt-transactions-table-filter="search"]')
            .addEventListener("keyup", function (event) {
                t.search(event.target.value).draw();
            });

        },
    };
})();

KTUtil.onDOMContentLoaded(function () {
    KTReportOmzetList.init();
});
