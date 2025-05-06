"use strict";
var KTModalKaryawanAdd = (function () {
    var t, e, o, n, r, i;
    return {
        init: function () {
            (i = new bootstrap.Modal(
                document.querySelector("#kt_modal_add_customer")
            ));
            (r = document.querySelector("#kt_modal_add_customer_form"));
            (t = r.querySelector("#kt_modal_add_customer_submit"));
            (e = r.querySelector("#kt_modal_add_customer_cancel"));
            (o = r.querySelector("#kt_modal_add_customer_close"));
            (n = FormValidation.formValidation(r, {
                fields: {
                    nama: {
                        validators: {
                            notEmpty: {
                                message: "Nama lengkap wajib diisi",
                            },
                        },
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: "Email wajib diisi",
                            },
                            emailAddress: {
                                message: "Format email tidak valid",
                            },
                        },
                    },
                    jkel: {
                        validators: {
                            notEmpty: {
                                message: "Jenis kelamin wajib dipilih",
                            },
                        },
                    },
                    no_telp: {
                        validators: {
                            notEmpty: {
                                message: "Nomor telepon wajib diisi",
                            },
                            regexp: {
                                regexp: /^[0-9]+$/,
                                message: "Hanya boleh berisi angka",
                            },
                        },
                    },
                    alamat: {
                        validators: {
                            notEmpty: {
                                message: "Alamat wajib diisi",
                            },
                        },
                    },
                    tempat_lahir: {
                        validators: {
                            notEmpty: {
                                message: "Tempat lahir wajib diisi",
                            },
                        },
                    },
                    tgl_lahir: {
                        validators: {
                            notEmpty: {
                                message: "Tanggal lahir wajib diisi",
                            },
                            date: {
                                format: 'YYYY-MM-DD',
                                message: "Format tanggal tidak valid",
                            },
                        },
                    },
                    
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "",
                        eleValidClass: "",
                    }),
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
                                        text: "Data berhasil disimpan!",
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
        },
    };
})();

KTUtil.onDOMContentLoaded(function () {
    KTModalKaryawanAdd.init();
});