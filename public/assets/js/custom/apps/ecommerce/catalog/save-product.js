"use strict";
var KTAppEcommerceSaveProduct = (function () {
    const e = () => {

        $('#kt_docs_repeater_nested').repeater({
            initEmpty: !1,
            defaultValues: { "text-input": "foo" },
            repeaters: [{
                selector: '.inner-repeater',
                show: function () {
                    $(this).slideDown();
                },

                hide: function (deleteElement) {
                    $(this).slideUp(deleteElement);
                }
            }],

            show: function () {
                $(this).slideDown();

                $(this).find('[data-kt-repeater="select2"]').select2();

            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            },
        });
    },
        t = () => {
            document
                .querySelectorAll(
                    '[data-kt-ecommerce-catalog-add-product="product_option"]'
                )
                .forEach((e) => {
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
                e();
                let myDropzone = new Dropzone("#kt_ecommerce_add_product_media", {
                    url: "/produk/upload-gambar",
                    paramName: "gambar",
                    maxFiles: 10,
                    maxFilesize: 10,
                    addRemoveLinks: true,
                    autoProcessQueue: false, // <--- penting!
                    uploadMultiple: false,
                    parallelUploads: 10,
                    acceptedFiles: ".png,.jpg,.jpeg",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    },
                    init: function () {
                        const dropzone = this;

                        dropzone.uploadStarted = false;

                        dropzone.removedFiles = []; // ⬅ langsung set ke property Dropzone

                        dropzone.on("removedfile", function (file) {
                            if (file.name && !file.upload) {
                                dropzone.removedFiles.push(file.name); // ⬅ pastikan masuk ke properti
                            }
                        });

                        // Jika halaman edit, preload gambar
                        const isEdit = document.getElementById('edit_mode');
                        const produkId = document.getElementById('produk_id')?.value;

                        if (isEdit && produkId) {
                            fetch(`/produk/get-gambar/${produkId}`)
                                .then(res => res.json())
                                .then(files => {
                                    files.forEach(file => {
                                        let mockFile = {
                                            name: file.name,
                                            size: file.size,
                                            type: 'image/*', // atau sesuaikan dengan mime type
                                        };

                                        dropzone.emit("addedfile", mockFile);
                                        dropzone.emit("thumbnail", mockFile, file.url);
                                        dropzone.emit("complete", mockFile);

                                        dropzone.files.push(mockFile);
                                        
                                    });
                                });
                        }

                        dropzone.on("queuecomplete", function () {
                            if (dropzone.uploadStarted) {
                                Swal.fire({
                                    text: "Produk berhasil disimpan!",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, mengerti!",
                                    customClass: {
                                        confirmButton: "btn btn-primary",
                                    },
                                }).then(() => {
                                    window.location = document.querySelector("#kt_ecommerce_add_product_form").getAttribute("data-kt-redirect");
                                });
                            }
                        });

                    }
                });
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
                    const e = document.getElementById(
                        "kt_ecommerce_add_product_variant_checkbox"
                    ),
                        t = document.getElementById("kt_ecommerce_add_product_variant"),
                        o = document.getElementById("kt_ecommerce_add_product_pricing"),
                        a = document.getElementById("kt_ecommerce_add_product_inventory");
                    e.addEventListener("change", (e) => {
                        e.target.checked
                            ? t.classList.remove("d-none")
                            : t.classList.add("d-none");
                        e.target.checked
                            ? o.classList.add("d-none")
                            : o.classList.remove("d-none");
                        e.target.checked
                            ? a.classList.add("d-none")
                            : a.classList.remove("d-none");
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
                            nama_produk: { // Tambahkan validasi untuk field baru
                                validators: {
                                    notEmpty: {
                                        message: "Nama produk wajib diisi",
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

                                        // Tambahkan data file yang dihapus ke FormData
                                        formData.append('removed_files', JSON.stringify(myDropzone.removedFiles || []));

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
                                            if (data.success) {
                                                const produkId = data.produkId;
                                                console.log('Produk ID:', produkId);

                                                // Set ID produk ke Dropzone params agar dikirim di upload gambar
                                                myDropzone.options.params = {
                                                    id_master_produk: produkId
                                                };

                                                if (myDropzone.getQueuedFiles().length > 0) {
                                                    // Tunggu semua file selesai diunggah
                                                    myDropzone.on("queuecomplete", function () {
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
                                                    });
                                                    
                                                    myDropzone.uploadStarted = true;
                                                    myDropzone.processQueue(); // ⏫ Mulai upload gambar
                                                } else {
                                                    // Tidak ada gambar, langsung tampilkan notifikasi dan redirect
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
                                                }
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