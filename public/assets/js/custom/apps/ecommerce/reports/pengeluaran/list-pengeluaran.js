"use strict";
var KTPengeluaranList = (function () {
    var t, e;
    let startDate = null;
    let endDate = null;

    const handleDeleteButtons = () => {
        e.querySelectorAll('[data-kt-pengeluaran-table-filter="delete_row"]').forEach((el) => {
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
                            url: `/pengeluaran/${row.dataset.slug}`, // Pastikan `data-slug` ada di <tr>
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
        const deleteSelectedBtn = document.querySelector('[data-kt-pengeluaran-table-select="delete_selected"]');

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
                        url: '/pengeluaran-delete-selected',
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
        const baseToolbar = document.querySelector('[data-kt-pengeluaran-table-toolbar="base"]');
        const selectedToolbar = document.querySelector('[data-kt-pengeluaran-table-toolbar="selected"]');
        const selectedCount = document.querySelector('[data-kt-pengeluaran-table-select="selected_count"]');
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
            e = document.querySelector("#kt_pengeluaran_table");

            if (!e) return;

            t = $(e).DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/pengeluaran-data",
                    data: function (d) {
                        if (startDate && endDate) {
                            d.start = startDate;
                            d.end = endDate;
                        }

                    }
                },
                columns: [
                    { data: 'checkbox', orderable: false, searchable: false, class: 'form-check form-check-sm form-check-custom form-check-solid' },
                    { data: 'nama_pengeluaran' },
                    { data: 'kategori_pengeluaran' },
                    { data: 'jum_pengeluaran' },
                    { data: 'nama_user' },
                    { data: 'tanggaldibuat' },
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

            (() => {
                const e = "Laporan Pengeluaran"; // Judul laporan
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
                    .appendTo($("#kt_pengeluaran_report_views_export")),
                    document
                        .querySelectorAll(
                            "#kt_pengeluaran_report_views_export_menu [data-kt-pengeluaran-export]"
                        )
                        .forEach((t) => {
                            t.addEventListener("click", (t) => {
                                t.preventDefault();
                                const e = t.target.getAttribute("data-kt-pengeluaran-export");
                                document.querySelector(".dt-buttons .buttons-" + e).click();
                            });
                        });
            })(),

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

            t.on("draw", function () {
                handleDeleteButtons();
                handleGroupActions();
                updateToolbar();
                KTMenu.createInstances(); // dropdown dari template
                
            });

            handleGroupActions();
            handleDeleteButtons();

            // Search input
            document.querySelector('[data-kt-pengeluaran-table-filter="search"]')
            .addEventListener("keyup", function (event) {
                t.search(event.target.value).draw();
            });

        },
    };
})();

KTUtil.onDOMContentLoaded(function () {
    KTPengeluaranList.init();
});
