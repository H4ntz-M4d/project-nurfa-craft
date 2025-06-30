"use strict";
var KTAppAddBlogPost = (function () {
    let quillJudul, quillDeskripsi;
    const e = () => {
            $("#kt_ecommerce_blog_post_conditions").repeater({
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
                    '[data-kt-ecommerce-catalog-add-category="condition_type"]'
                )
                .forEach((e) => {
                    $(e).hasClass("select2-hidden-accessible") ||
                        $(e).select2({ minimumResultsForSearch: -1 });
                });
            document
                .querySelectorAll(
                    '[data-kt-ecommerce-catalog-add-category="condition_equals"]'
                )
                .forEach((e) => {
                    $(e).hasClass("select2-hidden-accessible") ||
                        $(e).select2({ minimumResultsForSearch: -1 });
                });
        };
    return {
        init: function () {
            [
                "#kt_ecommerce_blog_judul",
                "#kt_ecommerce_blog_post_description",
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

                    if (e === "#kt_ecommerce_blog_judul") {
                        editor.format('header', 3);
                    } else if (e === "#kt_ecommerce_blog_post_description") {
                        editor.format('header', false); // normal text
                    }
                    
                    // Mengambil data judul dari atribut data
                    if (e === "#kt_ecommerce_blog_judul") {
                        const judulContent = t.getAttribute("data-content");
                        quillJudul = editor;

                        if (judulContent) {
                            editor.root.innerHTML = judulContent;
                        }
                    }

                    // Mengambil data deskripsi dari atribut data
                    if (e === "#kt_ecommerce_blog_post_description") {
                        const descContent = t.getAttribute("data-content");
                        quillDeskripsi = editor;

                        if (descContent) {
                            editor.root.innerHTML = descContent;
                        }
                    }

                }
            }),
                ["#kt_ecommerce_blog_post_tag"].forEach((e) => {
                    const t = document.querySelector(e);
                    t && new Tagify(t);
                }),
                e(),
                t(),
                (() => {
                    let e;
                    const t = document.getElementById(
                            "kt_ecommerce_blog_post_form"
                        ),
                        o = document.getElementById(
                            "kt_ecommerce_blog_post_submit"
                        );
                    (e = FormValidation.formValidation(t, {
                        fields: {
                            judul: {
                                validators: {
                                    callback: {
                                        message: "Judul tidak boleh kosong",
                                        callback: function () {
                                            return quillJudul && quillJudul.getText().trim().length > 0;
                                        }
                                    }
                                }
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
                            gambar: {
                                validators: {
                                    callback: {
                                        message: "Gambar wajib diunggah",
                                        callback: function (e) {
                                            const isEdit = !!t.querySelector('[name="id_blog"]').value;
                                            const fileSelected = e.value !== "";

                                            return isEdit || fileSelected;
                                        }
                                    }
                                },
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
                                            const judulEditor = document.querySelector('#kt_ecommerce_blog_judul .ql-editor');
                                            const deskripsiEditor = document.querySelector('#kt_ecommerce_blog_post_description .ql-editor');
                                            formData.set('judul', judulEditor.innerHTML);
                                            formData.set('deskripsi', deskripsiEditor.innerHTML);

                                            fetch(
                                                t.getAttribute(
                                                    "data-store-blog-url"
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
                                            .then(async response => {
                                                if (!response.ok) {
                                                    const errorData = await response.json();
                                                    throw { status: response.status, errors: errorData.errors };
                                                }

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
    KTAppAddBlogPost.init();
});
