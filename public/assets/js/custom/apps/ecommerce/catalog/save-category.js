"use strict";
var KTAppEcommerceSaveCategory = (function () {
  const e = () => {
      $("#kt_ecommerce_add_category_conditions").repeater({
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
        let editors = {};
        [
        "#kt_ecommerce_add_category_description",
        "#kt_ecommerce_add_category_meta_description",
        ].forEach((e) => {
        let t = document.querySelector(e);
        if (t) {
            ClassicEditor
                .create(t)
                .then(editor => {
                    editors[e.replace("#", "")] = editor;
                })
                .catch(error => {
                    console.error(error);
                });
        }
      }),
        ["#kt_ecommerce_add_category_meta_keywords"].forEach((e) => {
          const t = document.querySelector(e);
          t && new Tagify(t);
        }),
        e(),
        t(),
        (() => {
          const e = document.getElementById("kt_ecommerce_add_category_status"),
            t = document.getElementById(
              "kt_ecommerce_add_category_status_select"
            ),
            o = ["bg-success", "bg-warning", "bg-danger"];
          $(t).on("change", function (t) {
            switch (t.target.value) {
              case "published":
                e.classList.remove(...o), e.classList.add("bg-success"), r();
                break;
              case "unpublished":
                e.classList.remove(...o), e.classList.add("bg-danger"), r();
            }
          });
          const a = document.getElementById(
            "kt_ecommerce_add_category_status_datepicker"
          );
          $("#kt_ecommerce_add_category_status_datepicker").flatpickr({
            enableTime: !0,
            dateFormat: "Y-m-d H:i",
          });
          const c = () => {
              a.parentNode.classList.remove("d-none");
            },
            r = () => {
              a.parentNode.classList.add("d-none");
            };
        })(),
        (() => {
          const e = document.querySelectorAll('[name="method"][type="radio"]'),
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
          let e;
          const t = document.getElementById("kt_ecommerce_add_category_form"),
            o = document.getElementById("kt_ecommerce_add_category_submit");
          (e = FormValidation.formValidation(t, {
            fields: {
                nama_kategori: {
                    validators: {
                    notEmpty: { message: "Category name is required" },
                    },
                },
                status: {
                    validators: {
                    notEmpty: { message: "Status name is required" },
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
          })),
            o.addEventListener("click", (a) => {
              a.preventDefault(),
                e &&
                  e.validate().then(function (e) {
                    console.log("validated!");
                    if (e === "Valid") {
                        o.setAttribute("data-kt-indicator", "on");
                        o.disabled = true;
        
                        // Sinkronkan isi CKEditor ke textarea sebelum buat FormData
                        Object.values(editors).forEach(editor => {
                            editor.updateSourceElement();
                        });

                        
                        let formData = new FormData(t);
                        
                        const status = document.getElementById('kt_ecommerce_add_category_status_select').value;
                        formData.set('status', status);
        
                        fetch(t.getAttribute("data-store-kategori-url"), {
                            method: "POST",
                            body: formData,
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                                "Accept": "application/json"
                            }
                        
                        })
                        .then(response => {
                            console.log("Response status:", response.status);
                            return response.json();
                        })
                        .then(data => {
                            o.removeAttribute("data-kt-indicator");
                            o.disabled = false;
        
                            if (data.success) {
                                Swal.fire({
                                    text: "Data berhasil disimpan!",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "OK",
                                    customClass: { confirmButton: "btn btn-primary" }
                                }).then(function () {
                                    window.location = t.getAttribute("data-kt-redirect");
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
                            o.removeAttribute("data-kt-indicator");
                            o.disabled = false;
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
            });
        })();
    },
  };
})();
KTUtil.onDOMContentLoaded(function () {
  KTAppEcommerceSaveCategory.init();
});
