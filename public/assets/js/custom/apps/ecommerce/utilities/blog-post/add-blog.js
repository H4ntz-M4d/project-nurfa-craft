"use strict";
var KTAppAddBlogPost = (function () {
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
                        if (judulContent) {
                            editor.root.innerHTML = judulContent;
                        }
                    }

                    // Mengambil data deskripsi dari atribut data
                    if (e === "#kt_ecommerce_blog_post_description") {
                        const descContent = t.getAttribute("data-content");
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
                            tag: {
                                validators: {
                                    notEmpty: {
                                        message: "Judul is required",
                                    },
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
    KTAppAddBlogPost.init();
});
