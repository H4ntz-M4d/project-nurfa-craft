"use strict";
var KTAccountSettingsProfileDetails = (function () {
    var e, t, submitButton;
    return {
        init: function () {
            e = document.getElementById("kt_account_profile_details_form");
            submitButton = document.getElementById("kt_account_profile_details_submit");

            if (!e) return;

            t = FormValidation.formValidation(e, {
                fields: {
                    nama: {
                        validators: {
                            notEmpty: { message: "Nama wajib diisi" },
                        },
                    },
                    no_telp: {
                        validators: {
                            notEmpty: { message: "Nomor telepon wajib diisi" },
                        },
                    },
                    tempat_lahir: {
                        validators: {
                            notEmpty: { message: "Tempat lahir wajib diisi" },
                        },
                    },
                    tgl_lahir: {
                        validators: {
                            notEmpty: { message: "Tanggal lahir wajib diisi" },
                        },
                    },
                },
            });

            e.addEventListener("submit", function (event) {
                event.preventDefault();

                t.validate().then(function (status) {
                    if (status === "Valid") {
                        submitButton.disabled = true;
                        submitButton.innerHTML = `<span class="spinner-border spinner-border-sm align-middle me-2"></span> Saving...`;

                        let formData = new FormData(e);
                        let slug = e.getAttribute("data-slug");

                        fetch(`/update-karyawan/${slug}`, {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                                Accept: "application/json",
                            },
                            body: formData,
                        })
                        .then((response) => response.json())
                        .then((res) => {
                            submitButton.disabled = false;
                            submitButton.innerHTML = `Save Changes`;

                            if (res.success) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Berhasil",
                                    text: res.message,
                                });
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Gagal",
                                    text: "Terjadi kesalahan saat menyimpan.",
                                });
                            }
                        })
                        .catch((err) => {
                            submitButton.disabled = false;
                            submitButton.innerHTML = `Save Changes`;
                            console.error(err);
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: "Terjadi kesalahan pada server.",
                            });
                        });
                    }
                });
            });
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTAccountSettingsProfileDetails.init();
});