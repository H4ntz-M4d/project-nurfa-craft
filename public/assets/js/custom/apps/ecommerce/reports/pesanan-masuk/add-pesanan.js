"use strict";
var KTModalUpdateStatus = (function () {
    var t, e, o, n, r, i;
    return {
        init: function () {
            (i = new bootstrap.Modal(
                document.querySelector("#kt_modal_status_pesanan")
            ));
            (r = document.querySelector("#kt_modal_status_pesanan_form"));
            (t = r.querySelector("#kt_modal_status_pesanan_submit"));
            (e = r.querySelector("#kt_modal_status_pesanan_cancel"));
            (o = r.querySelector("#kt_modal_status_pesanan_close"));
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
            
                            fetch(r.action, {
                                method: "POST",
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

            $('#kt_pesanan_table').on('draw.dt', function () {
                document.querySelectorAll('.update-status-btn').forEach(button => {
                    button.addEventListener('click', function () {
                        const form = r; // form modal

                        form.querySelector('[name="slug"]').value = this.dataset.slug;

                        // Set status radio (proses, dikirim, selesai)
                        const status = this.dataset.status;
                        if (status) {
                            const radio = form.querySelector(`input[name="status"][value="${status}"]`);
                            if (radio) radio.checked = true;
                        }

                        // Set input lain
                        form.querySelector('input[name="jasa_pengiriman"]').value = this.dataset.jasa_pengiriman || '';
                        form.querySelector('input[name="no_resi"]').value = this.dataset.no_resi || '';
                        form.querySelector('input[name="harga_pengiriman"]').value = this.dataset.harga_pengiriman || '';
                        form.querySelector('textarea[name="keterangan"]').value = this.dataset.keterangan || '';
                    });
                });
            });
        },
    };
})();

KTUtil.onDOMContentLoaded(function () {
    KTModalUpdateStatus.init();
});