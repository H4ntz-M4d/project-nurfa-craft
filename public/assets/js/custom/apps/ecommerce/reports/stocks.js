"use strict";
var KTStocksList = (function () {
    var t, e;

    return {
        init: function () {
            e = document.querySelector("#kt_stok_table");

            if (!e) return;

            t = $(e).DataTable({
                processing: true,
                serverSide: true,
                ajax: "/stocks-data",
                columns: [
                    { data: 'nama_user' },
                    { data: 'nama_produk' },
                    { data: 'stok_awal' },
                    { data: 'stok_masuk' },
                    { data: 'stok_akhir' },
                    { data: 'tanggal' },
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
                const e = "Laporan Perubahan Stok";
                new $.fn.dataTable.Buttons(t, {
                    buttons: [
                        { extend: "copyHtml5", title: e },
                        { extend: "excelHtml5", title: e },
                        { extend: "csvHtml5", title: e },
                        { extend: "pdfHtml5", title: e },
                    ],
                })
                    .container()
                    .appendTo($("#kt_stocks_report_views_export")),
                    document
                        .querySelectorAll(
                            "#kt_stocks_report_views_export_menu [data-kt-stocks-export]"
                        )
                        .forEach((t) => {
                            t.addEventListener("click", (t) => {
                                t.preventDefault();
                                const e = t.target.getAttribute("data-kt-stocks-export");
                                document.querySelector(".dt-buttons .buttons-" + e).click();
                            });
                        });
            })(),

            t.on("draw", function () {
                KTMenu.createInstances(); // dropdown dari template
                
            });


            // Search input
            document.querySelector('[data-kt-stocks-table-filter="search"]')
            .addEventListener("keyup", function (event) {
                t.search(event.target.value).draw();
            });

        },
    };
})();

KTUtil.onDOMContentLoaded(function () {
    KTStocksList.init();
});
