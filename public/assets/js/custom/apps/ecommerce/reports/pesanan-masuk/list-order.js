"use strict";
var KTOrderList = (function () {
    var t, e;

    const handleDeleteButtons = () => {
        e.querySelectorAll('[data-kt-pesanan-table-filter="delete_row"]').forEach((el) => {
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
                            url: `/pesanan/${row.dataset.slug}`, // Pastikan `data-slug` ada di <tr>
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

    const handleGroupActions = () => {
        const checkboxes = e.querySelectorAll('[type="checkbox"]');
        const deleteSelectedBtn = document.querySelector('[data-kt-pesanan-table-select="delete_selected"]');

        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener("click", function () {
                setTimeout(() => updateToolbar(), 50);
            });
        });

        deleteSelectedBtn.addEventListener("click", function () {
            let selectedSlugsArray = [];
            e.querySelectorAll('tbody [type="checkbox"]:checked').forEach((checkbox) => {
                const row = checkbox.closest("tr");
                const slug = row.getAttribute("data-slug");
                if (slug) selectedSlugsArray.push(slug);
            });
            Swal.fire({
                text: "Yakin ingin menghapus pilihan Produk?",
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
                        url: '/pesanan-delete-selected',
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            ids: selectedSlugsArray
                        },
                        success: function (res) {
                            if (res.success) {
                                Swal.fire({
                                    text: "Kamu berhasil menghapus pilihan Produk!",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: { confirmButton: "btn fw-bold btn-primary" },
                                }).then(function () {
                                    checkboxes.forEach((checkbox) => {
                                        if (checkbox.checked) {
                                            t.row($(checkbox.closest("tbody tr"))).remove().draw();
                                        }
                                    });
                                    e.querySelector('[type="checkbox"]').checked = false;
                                });
                            }
                        }
                    });
                    
                } else if (result.dismiss === "cancel") {
                    Swal.fire({
                        text: "Selected Produk were not deleted.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: { confirmButton: "btn fw-bold btn-primary" },
                    });
                }
            });
        });
    };

    const updateToolbar = () => {
        const baseToolbar = document.querySelector('[data-kt-pesanan-table-toolbar="base"]');
        const selectedToolbar = document.querySelector('[data-kt-pesanan-table-toolbar="selected"]');
        const selectedCount = document.querySelector('[data-kt-pesanan-table-select="selected_count"]');
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
            e = document.querySelector("#kt_pesanan_table");

            if (!e) return;

            t = $(e).DataTable({
                processing: true,
                serverSide: true,
                ajax: "/pesanan-data",
                columns: [
                    { data: 'checkbox', orderable: false, searchable: false, class: 'form-check form-check-sm form-check-custom form-check-solid' },
                    { data: 'nama_user' },
                    { data: 'order_id' },
                    { data: 'status' },
                    { data: 'tanggaldibuat' },
                    { data: 'tanggaldiupdate' },
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
                handleDeleteButtons();
                handleGroupActions();
                updateToolbar();
                KTMenu.createInstances(); // dropdown dari template
                
            });

            (() => {
                const e = "Laporan Pesanan";
                new $.fn.dataTable.Buttons(t, {
                    buttons: [
                        {
                            extend: "copyHtml5",
                            title: e,
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5] // tanpa kolom action
                            }
                        },
                        {
                            extend: "excelHtml5",
                            title: e,
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5]
                            }
                        },
                        {
                            extend: "csvHtml5",
                            title: e,
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5]
                            }
                        },
                        {
                            extend: "pdfHtml5",
                            title: e,
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5]
                            }
                        },
                    ],

                })
                    .container()
                    .appendTo($("#kt_pesanan_report_views_export")),
                    document
                        .querySelectorAll(
                            "#kt_pesanan_report_views_export_menu [data-kt-pesanan-export]"
                        )
                        .forEach((t) => {
                            t.addEventListener("click", (t) => {
                                t.preventDefault();
                                const e = t.target.getAttribute("data-kt-pesanan-export");
                                document.querySelector(".dt-buttons .buttons-" + e).click();
                            });
                        });
            })(),

            handleGroupActions();
            handleDeleteButtons();

            // Search input
            document.querySelector('[data-kt-pesanan-table-filter="search"]')
            .addEventListener("keyup", function (event) {
                t.search(event.target.value).draw();
            });

        },
    };
})();

KTUtil.onDOMContentLoaded(function () {
    KTOrderList.init();
});
