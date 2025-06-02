"use strict";
var KTBlogPostList = (function () {
    var t, e;

    const handleDeleteButtons = () => {
        e.querySelectorAll('[data-kt-blog-table-filter="delete_row"]').forEach((el) => {
            el.addEventListener("click", function (ev) {
                ev.preventDefault();
                const row = el.closest("tr"),
                    nama = row.querySelectorAll("td")[2].innerText;
                Swal.fire({
                    text: `Are you sure you want to delete "${nama}"?`,
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
                            url: `/blog-post/${row.dataset.slug}`, // Pastikan `data-slug` ada di <tr>
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
        const deleteSelectedBtn = document.querySelector('[data-kt-blog-table-select="delete_selected"]');

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
                text: "Are you sure you want to delete selected categories?",
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
                        url: '/blog-post-delete-selected',
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            ids: selectedSlugsArray
                        },
                        success: function (res) {
                            if (res.success) {
                                Swal.fire({
                                    text: "You have deleted all selected categories!",
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
                        text: "Selected categories were not deleted.",
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
        const baseToolbar = document.querySelector('[data-kt-blog-table-toolbar="base"]');
        const selectedToolbar = document.querySelector('[data-kt-blog-table-toolbar="selected"]');
        const selectedCount = document.querySelector('[data-kt-blog-table-select="selected_count"]');
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
            e = document.querySelector("#kt_blog_table");

            if (!e) return;

            t = $(e).DataTable({
                processing: true,
                serverSide: true,
                ajax: "/blog-post-data",
                columns: [
                    { data: 'checkbox', orderable: false, searchable: false, class: 'form-check form-check-sm form-check-custom form-check-solid' },
                    { data: 'gambar' },
                    { data: 'judul' },
                    { data: 'deskripsi' },
                    { data: 'tag' },
                    { data: 'action', orderable: false, searchable: false },
                ],createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-slug', data.id_blog); // penting agar row.dataset.slug bisa dipakai
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

            handleGroupActions();
            handleDeleteButtons();

            // Search input
            document.querySelector('[data-kt-blog-table-filter="search"]')
            .addEventListener("keyup", function (event) {
                t.search(event.target.value).draw();
            });

        },
    };
})();

KTUtil.onDOMContentLoaded(function () {
    KTBlogPostList.init();
});
