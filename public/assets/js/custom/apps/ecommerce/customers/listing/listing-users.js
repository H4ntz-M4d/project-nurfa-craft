"use strict";

var KTUsersList = (function () {
    var t, e;

    const handleDeleteButtons = () => {
        e.querySelectorAll('[data-kt-users-table-filter="delete_row"]').forEach((el) => {
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
                            url: `/users/${row.dataset.slug}`, // Pastikan `data-slug` ada di <tr>
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
        const deleteSelectedBtn = document.querySelector('[data-kt-users-table-select="delete_selected"]');

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
                text: "Yakin ingin menghapus pilihan users?",
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
                        url: '/users-delete-selected',
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            ids: selectedSlugsArray
                        },
                        success: function (res) {
                            if (res.success) {
                                Swal.fire({
                                    text: "Kamu berhasil menghapus pilihan userss!",
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
        const baseToolbar = document.querySelector(
                '[data-kt-users-table-toolbar="base"]'
            ),
            selectedToolbar = document.querySelector(
                '[data-kt-users-table-toolbar="selected"]'
            ),
            selectedCount = document.querySelector(
                '[data-kt-users-table-select="selected_count"]'
            ),
            checkboxes = e.querySelectorAll(
                'tbody [type="checkbox"]:not([data-kt-check])'
            );

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
                ajax: "/users-data",
                columns: [
                    {
                        data: "checkbox",
                        orderable: false,
                        searchable: false,
                        class: "form-check form-check-sm form-check-custom form-check-solid",
                    },
                    { 
                        data: null, 
                        name: 'no', 
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    { data: "username", name: "username" },
                    { data: "email", name: "email" },
                    { data: "created_at", name: "created_at", render: function(data) {
                        return moment(data).format('DD-MM-YYYY:mm:ss');
                    }},
                    { data: "action", orderable: false, searchable: false },
                ],createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-slug', data.slug); // penting agar row.dataset.slug bisa dipakai
                },
                order: [],
                columnDefs: [
                    { orderable: false, targets: 0 },
                    { orderable: false, targets: 5 },
                ],
                drawCallback: function () {
                    handleDeleteButtons();
                    handleGroupActions();
                    updateToolbar();
                    KTMenu.createInstances(); // dropdown dari template
                },
            });

            // Search input
            document
                .querySelector('[data-kt-users-table-filter="search"]')
                .addEventListener("keyup", function (event) {
                    t.search(event.target.value).draw();
                });

            // Optional: Dropdown filter status
            const filter = document.querySelector(
                '[data-kt-ecommerce-order-filter="status"]'
            );
            if (filter) {
                $(filter).on("change", (e) => {
                    let value = e.target.value;
                    t.column(3)
                        .search(value === "all" ? "" : value)
                        .draw();
                });
            }
        },
    };
})();

KTUtil.onDOMContentLoaded(function () {
    KTUsersList.init();
});