"use strict";
var KTAppEcommerceSaveProduct = (function () {
    const e = () => {
        $("#kt_ecommerce_add_product_options").repeater({
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
                    '[data-kt-ecommerce-catalog-add-product="product_option"]'
                )
                .forEach((e) => {
                    $(e).hasClass("select2-hidden-accessible") ||
                        $(e).select2({ minimumResultsForSearch: -1 });
                });
        };
    return {
        init: function () {
            var o, a;
            [
                "#kt_ecommerce_add_product_description",
                "#kt_ecommerce_add_product_meta_description",
            ].forEach((e) => {
                let t = document.querySelector(e);
                if (t) {
                    let editor = new Quill(e, {
                        modules: {
                            toolbar: [
                                [{ header: [1, 2, !1] }],
                                ["bold", "italic", "underline"],
                                ["image", "code-block"],
                            ],
                        },
                        placeholder: "Type your text here...",
                        theme: "snow",
                    });
                    
                    // Mengambil data deskripsi dari atribut data
                    if (e === "#kt_ecommerce_add_product_description") {
                        const descContent = t.getAttribute("data-content");
                        if (descContent) {
                            editor.root.innerHTML = descContent;
                        }
                    }
                    
                    // Mengambil data meta_desc dari atribut data
                    if (e === "#kt_ecommerce_add_product_meta_description") {
                        const metaDescContent = t.getAttribute("data-content");
                        if (metaDescContent) {
                            editor.root.innerHTML = metaDescContent;
                        }
                    }
                }
            }),
                [
                    "#kt_ecommerce_add_product_meta_keywords",
                ].forEach((e) => {
                    const t = document.querySelector(e);
                    t &&
                        new Tagify(t, {
                            whitelist: [
                                "new",
                                "trending",
                                "sale",
                                "discounted",
                                "selling fast",
                                "last 10",
                            ],
                            dropdown: {
                                maxItems: 20,
                                classname: "tagify__inline__suggestions",
                                enabled: 0,
                                closeOnSelect: !1,
                            },
                        });
                }),
                (o = document.querySelector(
                    "#kt_ecommerce_add_product_discount_slider"
                )),
                (a = document.querySelector(
                    "#kt_ecommerce_add_product_discount_label"
                )),
                noUiSlider.create(o, {
                    start: [10],
                    connect: !0,
                    range: { min: 1, max: 100 },
                }),
                o.noUiSlider.on("update", function (e, t) {
                    (a.innerHTML = Math.round(e[t])),
                        t && (a.innerHTML = Math.round(e[t]));
                }),
                e(),
                new Dropzone("#kt_ecommerce_add_product_media", {
                    url: "https://keenthemes.com/scripts/void.php",
                    paramName: "file",
                    maxFiles: 10,
                    maxFilesize: 10,
                    addRemoveLinks: !0,
                    accept: function (e, t) {
                        "wow.jpg" == e.name ? t("Naha, you don't.") : t();
                    },
                }),
                t(),
                (() => {
                    const e = document.getElementById(
                        "kt_ecommerce_add_product_status"
                    ),
                        t = document.getElementById(
                            "kt_ecommerce_add_product_status_select"
                        ),
                        o = ["bg-success", "bg-danger"];
                    $(t).on("change", function (t) {
                        switch (t.target.value) {
                            case "published":
                                e.classList.remove(...o),
                                    e.classList.add("bg-success"),
                                    c();
                                break;
                            case "unpublished":
                                e.classList.remove(...o),
                                    e.classList.add("bg-danger"),
                                    c();
                        }
                    });
                    const a = document.getElementById(
                        "kt_ecommerce_add_product_status_datepicker"
                    );
                    $("#kt_ecommerce_add_product_status_datepicker").flatpickr({
                        enableTime: !0,
                        dateFormat: "Y-m-d H:i",
                    });
                    const d = () => {
                        a.parentNode.classList.remove("d-none");
                    },
                        c = () => {
                            a.parentNode.classList.add("d-none");
                        };
                })(),
                (() => {
                    const e = document.querySelectorAll(
                        '[name="method"][type="radio"]'
                    ),
                        t = document.querySelector(
                            '[data-kt-ecommerce-catalog-add-category="auto-options"]'
                        );
                    e.forEach((e) => {
                        e.addEventListener("change", (e) => {
                            "1" === e.target.value
                                ? t.classList.remove("d-none")
                                : t.classList.add("d-none");
                        });
                    });
                })(),
                (() => {
                    const e = document.querySelectorAll(
                        'input[name="discount_option"]'
                    ),
                        t = document.getElementById(
                            "kt_ecommerce_add_product_discount_percentage"
                        ),
                        o = document.getElementById(
                            "kt_ecommerce_add_product_discount_fixed"
                        );
                    e.forEach((e) => {
                        e.addEventListener("change", (e) => {
                            switch (e.target.value) {
                                case "2":
                                    t.classList.remove("d-none"),
                                        o.classList.add("d-none");
                                    break;
                                case "3":
                                    t.classList.add("d-none"),
                                        o.classList.remove("d-none");
                                    break;
                                default:
                                    t.classList.add("d-none"),
                                        o.classList.add("d-none");
                            }
                        });
                    });
                })(),
                (() => {
                    let e;
                    const t = document.getElementById(
                        "kt_ecommerce_add_product_form"
                    ),
                        o = document.getElementById(
                            "kt_ecommerce_add_product_submit"
                        );
                    (e = FormValidation.formValidation(t, {
                        fields: {
                            nama_produk: { // Tambahkan validasi untuk field baru
                                validators: {
                                    notEmpty: {
                                        message: "Nama produk wajib diisi",
                                    },
                                },
                            },
                            harga: {
                                validators: {
                                    notEmpty: {
                                        message: "Harga wajib diisi",
                                    },
                                    numeric: {
                                        message: "Harga harus berupa angka",
                                    },
                                },
                            },
                            stok: {
                                validators: {
                                    notEmpty: {
                                        message: "Stok wajib diisi",
                                    },
                                    integer: {
                                        message: "Stok harus bilangan bulat",
                                    },
                                },
                            },
                            sku: {
                                validators: {
                                    notEmpty: {
                                        message: "SKU wajib diisi",
                                    },
                                },
                            },
                        },
                    })),
                        o.addEventListener("click", (a) => {
                            a.preventDefault(),
                                e &&
                                e.validate().then(function (e) {
                                    if ("Valid" == e) {
                                        console.log('validate');
                                        // Mulai proses submit
                                        o.setAttribute("data-kt-indicator", "on");
                                        o.disabled = !0;

                                        // Kumpulkan data form
                                        const formData = new FormData(t);

                                        const kategori = document.querySelector('[name="kategori_id"]').value;
                                        formData.append('kategori_id', kategori);

                                        const status = document.getElementById('kt_ecommerce_add_product_status_select').value;
                                        formData.set('status', status);
                                        
                                        // Ambil konten editor
                                        const deskripsiEditor = document.querySelector('#kt_ecommerce_add_product_description .ql-editor');
                                        const metaDescEditor = document.querySelector('#kt_ecommerce_add_product_meta_description .ql-editor');
                                        formData.set('deskripsi', deskripsiEditor.innerHTML);
                                        formData.set('meta_desc', metaDescEditor.innerHTML);

                                        // Kumpulkan variant
                                        document.querySelectorAll('[data-repeater-item]').forEach(item => {
                                            // 1. Gunakan selector yang lebih spesifik
                                            const select = item.querySelector('select[name="product_option"]');
                                            const input = item.querySelector('input[name="nilai_variant"]');
                                            
                                            // 2. Tambahkan null checking
                                            if(select && input) {
                                                // 3. Ambil nilai dari Select2 jika digunakan
                                                const attributeValue = $(select).val(); // Menggunakan jQuery Select2
                                                const variantValue = input.value;
                                                
                                                // 4. Skip jika nilai kosong
                                                if(attributeValue && variantValue) {
                                                    variants.push({
                                                        attribute: attributeValue,
                                                        value: variantValue
                                                    });
                                                }
                                            }
                                        });

                                        // Kirim ke server
                                        fetch(t.getAttribute("data-store-produk-url"), {
                                            method: "POST",
                                            body: formData,
                                            headers: {
                                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                                            }
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if(data.success) {
                                                Swal.fire({
                                                    text: "Produk berhasil disimpan!",
                                                    icon: "success",
                                                    buttonsStyling: false,
                                                    confirmButtonText: "Ok, mengerti!",
                                                    customClass: {
                                                        confirmButton: "btn btn-primary",
                                                    },
                                                }).then(() => {
                                                    window.location = t.getAttribute("data-kt-redirect");
                                                });
                                            } else {
                                                throw new Error(data.message || 'Terjadi kesalahan');
                                            }
                                        })
                                        .catch(error => {
                                            Swal.fire({
                                                text: error.message,
                                                icon: "error",
                                                buttonsStyling: false,
                                                confirmButtonText: "Ok, mengerti!",
                                                customClass: {
                                                    confirmButton: "btn btn-primary",
                                                },
                                            });
                                        })
                                        .finally(() => {
                                            o.removeAttribute("data-kt-indicator");
                                            o.disabled = !1;
                                        });

                                    } else {
                                        Swal.fire({
                                            html: "Silakan periksa kembali form Anda",
                                            icon: "error",
                                            buttonsStyling: !1,
                                            confirmButtonText: "Ok, mengerti!",
                                            customClass: {
                                                confirmButton: "btn btn-primary",
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
    KTAppEcommerceSaveProduct.init();
});