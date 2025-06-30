"use strict";
var KTModalHomeBannerAdd = (function () {
    var t, e, o, n, r, i;
    return {
        init: function () {
            (i = new bootstrap.Modal(
                document.querySelector("#kt_modal_add_banner_home")
            ));
            (r = document.querySelector("#kt_modal_add_banner_home_form"));
            (t = r.querySelector("#kt_modal_add_banner_home_submit"));
            (e = r.querySelector("#kt_modal_add_banner_home_cancel"));
            (o = r.querySelector("#kt_modal_add_banner_home_close"));
            (n = FormValidation.formValidation(r, {
                fields: {
                    gambar: {
                        validators: {
                            callback: {
                                message: "Gambar wajib diunggah",
                                callback: function(input) {
                                    const isEdit = !!r.querySelector('[name="id"]').value;
                                    const fileSelected = input.value !== "";

                                    // Jika sedang create (id kosong), maka gambar harus dipilih
                                    return isEdit || fileSelected;
                                }
                            }
                        },
                    },
                    judul: {
                        validators: {
                            notEmpty: {
                                message: "Email wajib diisi",
                            },
                        },
                    },
                    label: {
                        validators: {
                            notEmpty: {
                                message: "Jenis kelamin wajib dipilih",
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

                            let isUpdate = !!r.querySelector('[name="id"]').value;
                            let url = isUpdate
                                ? `/home-banner/${r.querySelector('[name="id"]').value}`  // contoh: /home-banner/5
                                : r.action;

                            let method = isUpdate ? "POST" : "POST";
                            if (isUpdate) formData.append('_method', 'PUT'); // Laravel butuh ini

                            fetch(url, {
                                method: method,
                                body: formData,
                                headers: {
                                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                                    Accept: "application/json",
                                }
                            
                            })
                            .then(async response => {
                                if (!response.ok) {
                                    const errorData = await response.json();
                                    throw { status: response.status, errors: errorData.errors };
                                }

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
                            .catch(async error => {
                                t.removeAttribute("data-kt-indicator");
                                t.disabled = false;

                                if (error.status === 422) {
                                    let errorMessages = Object.values(error.errors).flat().join('<br>');
                                    Swal.fire({
                                        html: errorMessages,
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "OK",
                                        customClass: { confirmButton: "btn btn-primary" }
                                    });
                                } else {
                                    Swal.fire({
                                        text: "Terjadi kesalahan! Periksa kembali inputan Anda.",
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "OK",
                                        customClass: { confirmButton: "btn btn-primary" }
                                    });
                                }
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
                        r.reset();
                        r.querySelector('[name="id"]').value = '';
                        r.querySelector('.image-input-wrapper').style.backgroundImage = "url('/assets/media/misc/no-image.png')";
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
                        r.reset();
                        r.querySelector('[name="id"]').value = '';
                        r.querySelector('.image-input-wrapper').style.backgroundImage = "url('/assets/media/misc/no-image.png')";

                        t.value ? (r.reset(), i.hide()) : null;
                    });
            });

            $('#kt_home_banner_table').on('draw.dt', function () {
                document.querySelectorAll('.edit-banner-btn').forEach(button => {
                    button.addEventListener('click', function () {
                        i.show();

                        r.querySelector('[name="id"]').value = this.dataset.id;
                        r.querySelector('[name="judul"]').value = this.dataset.judul;
                        r.querySelector('[name="label"]').value = this.dataset.label;

                        let wrapper = r.querySelector('.image-input-wrapper');
                        if (this.dataset.gambar) {
                            wrapper.style.backgroundImage = `url('${this.dataset.gambar}')`;
                        }
                    });
                });
            });

        },
    };
})();

KTUtil.onDOMContentLoaded(function () {
    KTModalHomeBannerAdd.init();
});