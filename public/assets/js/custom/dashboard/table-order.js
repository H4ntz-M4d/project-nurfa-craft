"use strict";
var KTOrdersInfoList = (function () {
    var t, e;

    return {
        init: function () {
            e = document.querySelector("#kt_table_orders");

            if (!e) return;

            t = $(e).DataTable({
                processing: true,
                serverSide: true,
                ajax: "/dashboard/pesanan",
                columns: [
                    { data: 'order_id' },
                    { data: 'tanggal' },
                    { data: 'nama_user' },
                    { data: 'total' },
                    { data: 'status' }, // tambahkan ini!
                    { data: 'action' },
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

            $('select[data-kt-table-widget-4="filter_status"]').on('change', function() {
                t.ajax.reload(); // reload datatable sesuai filter
            });

            // Search input
            document.querySelector('[data-kt-table-widget-4="search" ]')
            .addEventListener("keyup", function (event) {
                t.search(event.target.value).draw();
            });

        },
    };
})();

KTUtil.onDOMContentLoaded(function () {
    KTOrdersInfoList.init();
});
