"use strict";
var KTAppSavePengeluaran = (function () {
    var t, e, o, n, r, i;
    return {
        init: function () {
            (i = new bootstrap.Modal(
                document.querySelector("#kt_modal_status_pengeluaran")
            ));
            (r = document.querySelector("#kt_modal_status_pengeluaran_form"));
            (t = r.querySelector("#kt_modal_status_pengeluaran_submit"));
            (e = r.querySelector("#kt_modal_status_pengeluaran_cancel"));
            (o = r.querySelector("#kt_modal_status_pengeluaran_close"));
            (n = FormValidation.formValidation(r, {
                fields: {
                    jasa_pengiriman: {
                        validators: {
                            notEmpty: {
                                message: "jasa Pengiriman wajib diisi",
                            },
                        },
                    },
                    no_resi: {
                        validators: {
                            notEmpty: {
                                message: "Nomor Resi wajib diisi",
                            },
                            stringLength: {
                                min: 5,
                                max: 50,
                                message: "Nomor Resi harus antara 5 hingga 50 karakter",
                            },
                        },
                    },
                    harga_pengiriman: {
                        validators: {
                            notEmpty: {
                                message: "Harga Pengiriman wajib diisi",
                            },
                        },
                    },
                    keterangan: {
                        validators: {
                            notEmpty: {
                                message: "Keterangan wajib diisi",
                            },
                        },
                    },
                },
            }));
            t.addEventListener("click", function (e) {
                e.preventDefault();
                
                if (n) {
                    n.validate().then(function (status) {
                        if (status === "Valid") {
                            t.setAttribute("data-kt-indicator", "on");
                            t.disabled = true;
            
                            let formData = new FormData(r);

                            let isUpdate = !!r.querySelector('[name="slug"]').value;
                            let url = isUpdate
                                ? `/pengeluaran-update/${r.querySelector('[name="slug"]').value}`  // contoh: /home-banner/5
                                : r.action;

                            let method = isUpdate ? "POST" : "POST";
                            if (isUpdate) formData.append('_method', 'PUT'); // Laravel butuh ini
            
                            fetch(url, {
                                method: method,
                                body: formData,
                                headers: {
                                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                                }
                            
                            })
                            .then(response => {
                                console.log("Response status:", response.status);
                                return response.json();
                            })
                            .then(data => {
                                t.removeAttribute("data-kt-indicator");
                                t.disabled = false;
            
                                if (data.success) {
                                    Swal.fire({
                                        text: data.message || "Data berhasil disimpan!",
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "OK",
                                        customClass: { confirmButton: "btn btn-primary" }
                                    }).then(function () {
                                        i.hide();
                                        window.location = r.getAttribute("data-kt-redirect");
                                    });
                                } else {
                                    Swal.fire({
                                        text: "Terjadi kesalahan saat menyimpan data!",
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Coba lagi",
                                        customClass: { confirmButton: "btn btn-primary" }
                                    });
                                }
                            })
                            .catch(error => {
                                console.log(error);
                                t.removeAttribute("data-kt-indicator");
                                t.disabled = false;
                                Swal.fire({
                                    text: "Terjadi kesalahan! Periksa kembali inputan Anda.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "OK",
                                    customClass: { confirmButton: "btn btn-primary" }
                                });
                            });
                        } else {
                            Swal.fire({
                                text: "Ada kesalahan pada input, silakan periksa kembali!",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "OK",
                                customClass: { confirmButton: "btn btn-primary" }
                            });
                        }
                    });
                }
            });
            e.addEventListener("click", function (t) {
                t.preventDefault(),
                    Swal.fire({
                        text: "Apakah Anda yakin ingin membatalkan?",
                        icon: "warning",
                        showCancelButton: !0,
                        buttonsStyling: !1,
                        confirmButtonText: "Ya, batalkan!",
                        cancelButtonText: "Tidak, kembali",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-active-light",
                        },
                    }).then(function (t) {
                        t.value ? (r.reset(), i.hide()) : null;
                    });
            });
            o.addEventListener("click", function (t) {
                t.preventDefault(),
                    Swal.fire({
                        text: "Apakah Anda yakin ingin membatalkan?",
                        icon: "warning",
                        showCancelButton: !0,
                        buttonsStyling: !1,
                        confirmButtonText: "Ya, batalkan!",
                        cancelButtonText: "Tidak, kembali",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-active-light",
                        },
                    }).then(function (t) {
                        t.value ? (r.reset(), i.hide()) : null;
                    });
            });

            $('#kt_pengeluaran_table').on('draw.dt', function () {
                document.querySelectorAll('.edit-pengeluaran-btn').forEach(button => {
                    button.addEventListener('click', function () {
                        const slug = this.dataset.slug;
                        const form = r;

                        // Reset form dulu
                        form.reset();

                        // Set slug di hidden input
                        form.querySelector('input[name="slug"]').value = slug;

                        fetch(`/detail-pengeluaran/${slug}`, {
                            method: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Set radio status
                            if (data.kategori_pengeluaran) {
                                const radio = form.querySelector(`input[name="kategori_pengeluaran"][value="${data.kategori_pengeluaran}"]`);
                                if (radio) radio.checked = true;
                            }

                            // Isi input lain
                            form.querySelector('input[name="nama_pengeluaran"]').value = data.nama_pengeluaran ?? '';
                            form.querySelector('input[name="jumlah_pengeluaran"]').value = data.jumlah_pengeluaran ?? '';
                            form.querySelector('input[name="tanggal_pengeluaran"]').value = data.tanggal_pengeluaran ?? '';
                            form.querySelector('textarea[name="keterangan"]').value = data.keterangan ?? '';
                        });
                    });
                });
            });
        },
    };
})();

KTUtil.onDOMContentLoaded(function () {
    KTAppSavePengeluaran.init();
});