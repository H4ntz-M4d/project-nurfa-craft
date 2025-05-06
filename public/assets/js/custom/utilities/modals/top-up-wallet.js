"use strict";
var KTModalTambahKaryawan = (function () {
    var t,
        e,
        o,
        n,
        a,
        r,
        l,
        i = [];
    return {
        init: function () {
            (e = document.querySelector("#kt_modal_tambah_karyawan")) &&
                ((t = new bootstrap.Modal(e)),
                (o = document.querySelector(
                    "#kt_modal_tambah_karyawan_stepper"
                )),
                (n = document.querySelector("#kt_modal_tambah_karyawan_form")),
                (a = o.querySelector('[data-kt-stepper-action="submit"]')),
                (r = o.querySelector('[data-kt-stepper-action="next"]')),
                (l = new KTStepper(o)).on("kt.stepper.changed", function (t) {
                    3 === l.getCurrentStepIndex()
                        ? (a.classList.remove("d-none"),
                          a.classList.add("d-inline-block"),
                          r.classList.add("d-none"))
                        : (a.classList.remove("d-inline-block"),
                          a.classList.add("d-none"),
                          r.classList.remove("d-none"));
                }),
                l.on("kt.stepper.next", function (t) {
                    console.log("stepper.next");
                    var e = i[t.getCurrentStepIndex() - 1];
                    e
                        ? e.validate().then(function (e) {
                              console.log("validated!"),
                                  "Valid" == e
                                      ? t.goNext()
                                      : Swal.fire({
                                            text: "Maaf, sepertinya ada beberapa kesalahan yang terdeteksi, silakan coba lagi.",
                                            icon: "error",
                                            buttonsStyling: !1,
                                            confirmButtonText:
                                                "Baik, mengerti!",
                                            customClass: {
                                                confirmButton: "btn btn-light",
                                            },
                                        }).then(function () {});
                          })
                        : (t.goNext(), KTUtil.scrollTop());
                }),
                l.on("kt.stepper.previous", function (t) {
                    console.log("stepper.previous"),
                        t.goPrevious(),
                        KTUtil.scrollTop();
                }),
                a.addEventListener("click", function (t) {
                    t.preventDefault();

                    // Dapatkan step aktif
                    const currentStep = l.getCurrentStepIndex();

                    // Validasi sesuai step
                    if (currentStep === 3) {
                        // Submit di step 3
                        const validatorStep2 = i[1]; // Validator step 2
                        if (!validatorStep2) {
                            Swal.fire({
                                text: "Terjadi kesalahan konfigurasi validasi!",
                                icon: "error"
                            });
                            return;
                        }
                        
                        // [FIX 3] Reset indikator jika validasi gagal
                        a.disabled = true;
                        a.setAttribute("data-kt-indicator", "on");
                        
                        validatorStep2.validate().then((result) => {
                            if (result === "Valid") {
                                // Form valid, lakukan submit
                                a.disabled = true;
                                a.setAttribute("data-kt-indicator", "on");

                                // Collect form data
                                const formData = new FormData(n);

                                // Kirim data ke server menggunakan AJAX
                                fetch("/karyawan/store", {
                                    method: "POST",
                                    body: formData,
                                    headers: {
                                        "X-CSRF-TOKEN": document
                                            .querySelector(
                                                'meta[name="csrf-token"]'
                                            )
                                            .getAttribute("content"),
                                    },
                                })
                                .then((response) => response.json())
                                .then((data) => {
                                    a.removeAttribute("data-kt-indicator");
                                    a.disabled = false;

                                    if (data.status) {
                                        // Sukses, pindah ke step berikutnya
                                        l.goNext();

                                        // Tampilkan notifikasi sukses
                                        Swal.fire({
                                            text: "Data karyawan berhasil disimpan!",
                                            icon: "success",
                                            buttonsStyling: false,
                                            confirmButtonText:
                                                "Baik, mengerti!",
                                            customClass: {
                                                confirmButton:
                                                    "btn btn-primary",
                                            },
                                        }).then(function () {
                                            t.hide();
                                            window.location = n.getAttribute("data-kt-redirect");
                                        });
                                    } else {
                                        // Error
                                        Swal.fire({
                                            text:
                                                data.message ||
                                                "Terjadi kesalahan saat menyimpan data.",
                                            icon: "error",
                                            buttonsStyling: false,
                                            confirmButtonText:
                                                "Baik, mengerti!",
                                            customClass: {
                                                confirmButton:
                                                    "btn btn-light",
                                            },
                                        });
                                    }
                                })
                                .catch((error) => {
                                    a.removeAttribute("data-kt-indicator");
                                    a.disabled = false;

                                    Swal.fire({
                                        text: "Terjadi kesalahan saat menghubungi server.",
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText:
                                            "Baik, mengerti!",
                                        customClass: {
                                            confirmButton: "btn btn-light",
                                        },
                                    });
                                });
                            }
                        });
                    }
                }),
                // Event handler untuk tombol "Tambah Karyawan Baru" di halaman sukses
                document
                    .querySelector("#kt_modal_tambah_karyawan_create_new")
                    .addEventListener("click", function () {
                        n.reset();
                        l.goTo(1);
                    }),
                // Validasi form step 1: Data Pribadi
                i.push(
                    FormValidation.formValidation(n, {
                        fields: {
                            nama: {
                                validators: {
                                    notEmpty: {
                                        message: "Nama karyawan wajib diisi",
                                    },
                                    stringLength: {
                                        min: 3,
                                        max: 255,
                                        message:
                                            "Nama harus antara 3 dan 255 karakter",
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
                                    stringLength: {
                                        min: 10,
                                        max: 15,
                                        message:
                                            "Nomor telepon harus antara 10 hingga 15 digit",
                                    },
                                    regexp: {
                                        regexp: /^[0-9]+$/,
                                        message:
                                            "Nomor telepon hanya boleh angka",
                                    },
                                },
                            },
                            alamat: {
                                validators: {
                                    notEmpty: {
                                        message: "Alamat wajib diisi",
                                    },
                                    stringLength: {
                                        max: 255,
                                        message: "Alamat maksimal 255 karakter",
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
                                        format: "YYYY-MM-DD",
                                        message: "Format tanggal tidak valid",
                                    },
                                },
                            },
                        },
                    })
                ),
                console.log("Step validator ditambahkan:", i.length),
                // Validasi form step 2: Akun Pengguna
                i.push(
                    FormValidation.formValidation(n, {
                        fields: {
                            username: {
                                validators: {
                                    notEmpty: {
                                        message: "Username wajib diisi",
                                    },
                                    stringLength: {
                                        min: 4,
                                        max: 50,
                                        message:
                                            "Username harus antara 4 hingga 50 karakter",
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
                            password: {
                                validators: {
                                    notEmpty: {
                                        message: "Password wajib diisi",
                                    },
                                    stringLength: {
                                        min: 6,
                                        message: "Password minimal 6 karakter",
                                    },
                                },
                            },
                            password_confirmation: {
                                validators: {
                                    notEmpty: {
                                        message:
                                            "Konfirmasi password wajib diisi",
                                    },
                                    identical: {
                                        compare: function () {
                                            return n.querySelector(
                                                '[name="password"]'
                                            ).value;
                                        },
                                        message:
                                            "Password dan konfirmasi tidak sama",
                                    },
                                },
                            },
                        },
                    })
                ),
                console.log("Step validator ditambahkan:", i.length),
                (() => {
                    e.querySelector(
                        '[data-kt-modal-action-type="close"]'
                    ).addEventListener("click", (t) => {
                        o(t);
                    });
                    const o = (e) => {
                        e.preventDefault(),
                            Swal.fire({
                                text: "Are you sure you would like to cancel?",
                                icon: "warning",
                                showCancelButton: !0,
                                buttonsStyling: !1,
                                confirmButtonText: "Yes, cancel it!",
                                cancelButtonText: "No, return",
                                customClass: {
                                    confirmButton: "btn btn-primary",
                                    cancelButton: "btn btn-active-light",
                                },
                            }).then(function (e) {
                                e.value
                                    ? (n.reset(), t.hide())
                                    : "cancel" === e.dismiss &&
                                      Swal.fire({
                                          text: "Your form has not been cancelled!.",
                                          icon: "error",
                                          buttonsStyling: !1,
                                          confirmButtonText: "Ok, got it!",
                                          customClass: {
                                              confirmButton: "btn btn-primary",
                                          },
                                      });
                            });
                    };
                })());
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTModalTambahKaryawan.init();
});
