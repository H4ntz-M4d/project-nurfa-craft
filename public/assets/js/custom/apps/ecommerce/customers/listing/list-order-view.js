"use strict";

var KTOrderViewList = (function () {
    var t, e;

    const handleDeleteButtons = () => {
        e.querySelectorAll('[data-kt-orderView-table-filter="delete_row"]').forEach((el) => {
            el.addEventListener("click", function (ev) {
                ev.preventDefault();
                const row = el.closest("tr"),
                    nama = row.querySelectorAll("td")[2].innerText;
                Swal.fire({
                    text: `Yakin ingin menghapus "${nama}"?`,
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, delete!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary",
                    },
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url: `/customers/${row.dataset.slug}`, // Pastikan `data-slug` ada di <tr>
                            type: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (res) {
                                if (res.success) {
                                    Swal.fire({
                                        text: res.message,
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: { confirmButton: "btn fw-bold btn-primary" },
                                    }).then(() => {
                                        t.row($(row)).remove().draw();
                                    });
                                }
                            }
                        });                        
                    } else if (result.dismiss === "cancel") {
                        Swal.fire({
                            text: `"${nama}" was not deleted.`,
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: { confirmButton: "btn fw-bold btn-primary" },
                        });
                    }
                });
            });
        });
    };

    return {
        init: function () {
            e = document.querySelector("#kt_orderView_table");
            if (!e) return;
            console.log("data:"+e.dataset.id); // Debugging: Cek id yang diambil

            t = $(e).DataTable({
                processing: true,
                serverSide: true,
                ajax: "/orders-view/" + e.dataset.id, // Ambil id dari data atribut
                pageLength: 5,
                columns: [
                    { data: 'order_id', },
                    { data: 'status', },
                    { data: 'total', },
                    {
                        data: 'tanggal', name: 'tanggal',
                    },
                    { data: 'action', orderable: false, searchable: false }
                ],createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-slug', data.slug); // penting agar row.dataset.slug bisa dipakai
                },    
                order: [],
                columnDefs: [
                    { orderable: false, targets: 0 },
                    { orderable: false, targets: 4 }
                ],
                drawCallback: function () {
                    handleDeleteButtons();
                    KTMenu.createInstances(); // dropdown dari template
                }
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
                    .appendTo($("#kt_transaksi_views_export")),
                    document
                        .querySelectorAll(
                            "#kt_transaksi_views_export_menu [data-kt-view-transaksi-export]"
                        )
                        .forEach((t) => {
                            t.addEventListener("click", (t) => {
                                t.preventDefault();
                                const e = t.target.getAttribute("data-kt-view-transaksi-export");
                                document.querySelector(".dt-buttons .buttons-" + e).click();
                            });
                        });
            })(),

            // Search input
            document.querySelector('[data-kt-orderView-table-filter="search"]')
                .addEventListener("keyup", function (event) {
                    t.search(event.target.value).draw();
                });

            // Optional: Dropdown filter status
            const filter = document.querySelector('[data-kt-ecommerce-order-filter="status"]');
            if (filter) {
                $(filter).on("change", (e) => {
                    let value = e.target.value;
                    t.column(3).search(value === "all" ? "" : value).draw();
                });
            }
        }
    };
})();

KTUtil.onDOMContentLoaded(function () {
    KTOrderViewList.init();
});