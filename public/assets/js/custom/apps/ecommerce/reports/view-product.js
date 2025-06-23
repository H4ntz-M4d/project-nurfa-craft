"use strict";
var KTViewProductList = (function () {
    var t, e;

    const updateToolbar = () => {
        const baseToolbar = document.querySelector('[data-kt-stocks-table-toolbar="base"]');
        const selectedToolbar = document.querySelector('[data-kt-stocks-table-toolbar="selected"]');
        const selectedCount = document.querySelector('[data-kt-stocks-table-select="selected_count"]');
        const checkboxes = e.querySelectorAll('tbody [type="checkbox"]');

        let count = 0;
        checkboxes.forEach((checkbox) => {
            if (checkbox.checked) count++;
        });

        if (count > 0) {
            selectedCount.innerHTML = count;
            baseToolbar.classList.add("d-none");
            selectedToolbar.classList.remove("d-none");
        } else {
            baseToolbar.classList.remove("d-none");
            selectedToolbar.classList.add("d-none");
        }
    };

    return {
        init: function () {
            e = document.querySelector("#kt_view_product_table");

            if (!e) return;

            t = $(e).DataTable({
                processing: true,
                serverSide: true,
                ajax: "/view-product-data",
                columns: [
                    { data: 'nama_produk' },
                    { data: 'stok', class:'text-center' },
                    { data: 'jumlah_dilihat', class:'text-center' },
                    { data: 'persentase_dilihat', class:'text-center' },
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
                const e = "Laporan Produk yang sering dilihat";
                new $.fn.dataTable.Buttons(t, {
                    buttons: [
                        { extend: "copyHtml5", title: e },
                        { extend: "excelHtml5", title: e },
                        { extend: "csvHtml5", title: e },
                        { extend: "pdfHtml5", title: e },
                    ],
                })
                    .container()
                    .appendTo($("#kt_view-product_report_views_export")),
                    document
                        .querySelectorAll(
                            "#kt_view-product_report_views_export_menu [data-kt-view-product-export]"
                        )
                        .forEach((t) => {
                            t.addEventListener("click", (t) => {
                                t.preventDefault();
                                const e = t.target.getAttribute("data-kt-view-product-export");
                                document.querySelector(".dt-buttons .buttons-" + e).click();
                            });
                        });
            })(),

            t.on("draw", function () {
                KTMenu.createInstances(); // dropdown dari template
                
            });

            // Search input
            document.querySelector('[data-kt-view-product-table-filter="search"]')
            .addEventListener("keyup", function (event) {
                t.search(event.target.value).draw();
            });

        },
    };
})();

KTUtil.onDOMContentLoaded(function () {
    KTViewProductList.init();
});
