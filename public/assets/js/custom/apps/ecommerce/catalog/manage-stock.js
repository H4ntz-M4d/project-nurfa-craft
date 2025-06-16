"use strict";
var KTPStocksList = (function () {
    var t, e;

    return {
        init: function () {
            e = document.querySelector("#kt_stok_produk_table");

            if (!e) return;

            t = $(e).DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/stocks-produk-data",
                    data: function(d) {
                        d.status_filter = $('select[data-kt-table-widget-5="filter_status"]').val();
                    }
                },
                columns: [
                    { data: 'nama_produk' },
                    { data: 'use_variant', class: 'text-center' },
                    { data: 'harga' },
                    { data: 'stok' },
                    { data: 'status' },
                    { data: 'action', orderable: false, searchable: false },
                ],createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-slug', data.slug); // penting agar row.dataset.slug bisa dipakai
                },                
                order: [],
                columnDefs: [
                    { targets: 0, orderable: false },
                    { targets: -1, orderable: false },
                ],
            });

            t.on("draw", function () {
                KTMenu.createInstances(); // dropdown dari template
                
            });
            
            $('select[data-kt-table-widget-5="filter_status"]').on('change', function() {
                t.ajax.reload(); // reload datatable sesuai filter
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
    KTPStocksList.init();
});
