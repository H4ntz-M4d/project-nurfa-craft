"use strict";

var KTCustomersList = (function () {
    var t, e;

    const handleRowDelete = () => {
        e.querySelectorAll('[data-kt-customer-table-filter="delete_row"]').forEach((btn) => {
            btn.addEventListener("click", function (event) {
                event.preventDefault();
                const row = event.target.closest("tr"),
                    nama = row.querySelectorAll("td")[2].innerText; // kolom ke-2 (nama)
                const id = btn.getAttribute("data-id");

                Swal.fire({
                    text: `Are you sure you want to delete ${nama}?`,
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
                        Swal.fire({
                            text: `You have deleted "${nama}".`,
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: { confirmButton: "btn fw-bold btn-primary" },
                        }).then(function () {
                            t.row($(row)).remove().draw();
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

    const handleBulkDelete = () => {
        const checkboxes = e.querySelectorAll('[type="checkbox"]:not([data-kt-check])'),
            deleteBtn = document.querySelector('[data-kt-customer-table-select="delete_selected"]');

        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener("click", () => {
                setTimeout(updateToolbar, 50);
            });
        });

        deleteBtn.addEventListener("click", () => {
            let selectedIds = [];
            checkboxes.forEach((checkbox) => {
                if (checkbox.checked) {
                    selectedIds.push(checkbox.value);
                }
            });

            if (selectedIds.length === 0) return;

            Swal.fire({
                text: "Are you sure you want to delete selected items?",
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
                    fetch("/customers/delete-selected", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute("content"),
                            "Content-Type": "application/json",
                            Accept: "application/json",
                        },
                        body: JSON.stringify({ ids: selectedIds }),
                    })
                    .then((res) => res.json())
                    .then((data) => {
                        if (data.success) {
                            Swal.fire({
                                text: "Data berhasil dihapus!",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton:
                                        "btn fw-bold btn-primary",
                                },
                            }).then(() => {
                                selectedIds.forEach((id) => {
                                    const row = e
                                        .querySelector(
                                            `input[value="${id}"]`
                                        )
                                        .closest("tr");
                                    t.row($(row)).remove().draw();
                                });

                                e.querySelector(
                                    "[data-kt-check]"
                                ).checked = false;
                                updateToolbar();
                            });
                        } else {
                            throw new Error(data.message);
                        }
                    })
                    .catch(() => {
                        Swal.fire({
                            text: "Terjadi kesalahan saat menghapus data.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            },
                        });
                    });
                } else if (result.dismiss === "cancel") {
                    Swal.fire({
                        text: "Selected items were not deleted.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        },
                    });
                }
            });
        });
    };

    const updateToolbar = () => {
        const baseToolbar = document.querySelector('[data-kt-customer-table-toolbar="base"]'),
            selectedToolbar = document.querySelector('[data-kt-customer-table-toolbar="selected"]'),
            selectedCount = document.querySelector('[data-kt-customer-table-select="selected_count"]'),
            checkboxes = e.querySelectorAll('tbody [type="checkbox"]:not([data-kt-check])');

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
            e = document.querySelector("#kt_customers_table");
            if (!e) return;

            t = $(e).DataTable({
                processing: true,
                serverSide: true,
                ajax: "/customers-data", // ganti sesuai route kamu
                columns: [
                    { data: 'checkbox', orderable: false, searchable: false, class: 'form-check form-check-sm form-check-custom form-check-solid' },
                    { 
                        data: null, 
                        name: 'no', 
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    { data: 'nama', name: 'nama' },
                    { data: 'email', name: 'email' },
                    { data: 'no_telp', name: 'no_telp' },
                    { data: 'alamat', name: 'alamat' },
                    { data: 'action', orderable: false, searchable: false }
                ],
                order: [],
                columnDefs: [
                    { orderable: false, targets: 0 },
                    { orderable: false, targets: 6 }
                ],
                drawCallback: function () {
                    handleBulkDelete();
                    handleRowDelete();
                    updateToolbar();
                    KTMenu.createInstances(); // dropdown dari template
                }
            });

            // Search input
            document.querySelector('[data-kt-customer-table-filter="search"]')
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
    KTCustomersList.init();
});