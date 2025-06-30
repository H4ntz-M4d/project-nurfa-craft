"use strict";
var KTAppAddAbout = (function () {
    let quillDeskripsi;
    const e = () => {
            $("#kt_ecommerce_about_conditions").repeater({
                initEmpty: !1,
                defaultValues: { "text-input": "foo" },
                show: function () {
                    $(this).slideDown(), t();
                },
                hide: function (e) {
                    $(this).slideUp(e);
                },
            });
        },
        t = () => {
            document
                .querySelectorAll(
                    '[data-kt-ecommerce-about-add-category="condition_type"]'
                )
                .forEach((e) => {
                    $(e).hasClass("select2-hidden-accessible") ||
                        $(e).select2({ minimumResultsForSearch: -1 });
                });
            document
                .querySelectorAll(
                    '[data-kt-ecommerce-about-add-category="condition_equals"]'
                )
                .forEach((e) => {
                    $(e).hasClass("select2-hidden-accessible") ||
                        $(e).select2({ minimumResultsForSearch: -1 });
                });
        };
    return {
        init: function () {
            [
                "#kt_ecommerce_about_description",
            ].forEach((e) => {
                let t = document.querySelector(e);
                if (t) {
                    let editor = new Quill(e, {
                        modules: {
                            toolbar: [
                                [{ header: [1, 2, 3, !1] }],
                                ["bold", "italic", "underline"],
                                ["image", "code-block"],
                            ],
                        },
                        placeholder: "Type your text here...",
                        theme: "snow",
                    });

                    // Mengambil data deskripsi dari atribut data
                    if (e === "#kt_ecommerce_about_description") {
                        const descContent = t.getAttribute("data-content");
                        quillDeskripsi = editor;
                        if (descContent) {
                            editor.root.innerHTML = descContent;
                        }
                    }

                }
            }),
                e(),
                t(),
                (() => {
                    let e;
                    const t = document.getElementById(
                            "kt_ecommerce_about_form"
                        ),
                        o = document.getElementById(
                            "kt_ecommerce_about_submit"
                        );
                    (e = FormValidation.formValidation(t, {
                        fields: {
                            judul: {
                                validators: {
                                    notEmpty: {
                                        message: "Judul is required",
                                    },
                                },
                            },
                            deskripsi: {
                                validators: {
                                    callback: {
                                        message: "Deskripsi tidak boleh kosong",
                                        callback: function () {
                                            return quillDeskripsi && quillDeskripsi.getText().trim().length > 0;
                                        }
                                    }
                                }
                            },
                        },
                    })),
                        o.addEventListener("click", (a) => {
                            a.preventDefault(),
                                e &&
                                    e.validate().then(function (e) {
                                        console.log("validated!");
                                        console.log("Form validation result:", e);
                                        if (e === "Valid") {
                                            o.setAttribute(
                                                "data-kt-indicator",
                                                "on"
                                            );
                                            o.disabled = true;

                                            let formData = new FormData(t);
                                            
                                            // Ambil konten editor
                                            const deskripsiEditor = document.querySelector('#kt_ecommerce_about_description .ql-editor');
                                            formData.set('deskripsi', deskripsiEditor.innerHTML);

                                            fetch(
                                                t.getAttribute(
                                                    "data-store-about-url"
                                                ),
                                                {
                                                    method: "POST",
                                                    body: formData,
                                                    headers: {
                                                        "X-CSRF-TOKEN":
                                                            document.querySelector(
                                                                'meta[name="csrf-token"]'
                                                            ).content,
                                                        Accept: "application/json",
                                                    },
                                                }
                                            )
                                            .then((response) => {
                                                console.log(
                                                    "Response status:",
                                                    response.status
                                                );
                                                return response.json();
                                            })
                                            .then((data) => {
                                                o.removeAttribute(
                                                    "data-kt-indicator"
                                                );
                                                o.disabled = false;

                                                if (data.success) {
                                                    Swal.fire({
                                                        text: "Data berhasil disimpan!",
                                                        icon: "success",
                                                        buttonsStyling: false,
                                                        confirmButtonText:
                                                            "OK",
                                                        customClass: {
                                                            confirmButton:
                                                                "btn btn-primary",
                                                        },
                                                    }).then(function () {
                                                        window.location =
                                                            t.getAttribute(
                                                                "data-kt-redirect"
                                                            );
                                                    });
                                                } else {
                                                    Swal.fire({
                                                        text: "Terjadi kesalahan saat menyimpan data!",
                                                        icon: "error",
                                                        buttonsStyling: false,
                                                        confirmButtonText:
                                                            "Coba lagi",
                                                        customClass: {
                                                            confirmButton:
                                                                "btn btn-primary",
                                                        },
                                                    });
                                                }
                                            })
                                            .catch((error) => {
                                                console.log(error);
                                                o.removeAttribute(
                                                    "data-kt-indicator"
                                                );
                                                o.disabled = false;
                                                Swal.fire({
                                                    text: "Terjadi kesalahan! Periksa kembali inputan Anda.",
                                                    icon: "error",
                                                    buttonsStyling: false,
                                                    confirmButtonText: "OK",
                                                    customClass: {
                                                        confirmButton:
                                                            "btn btn-primary",
                                                    },
                                                });
                                            });
                                        } else {
                                            Swal.fire({
                                                text: "Ada kesalahan pada input, silakan periksa kembali!",
                                                icon: "error",
                                                buttonsStyling: false,
                                                confirmButtonText: "OK",
                                                customClass: {
                                                    confirmButton:
                                                        "btn btn-primary",
                                                },
                                            });
                                        }
                                    });
                        });
                })();
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTAppAddAbout.init();
});
