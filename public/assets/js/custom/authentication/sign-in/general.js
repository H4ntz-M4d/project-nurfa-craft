"use strict";
var KTSigninGeneral = (function () {
    var t, e, r;

    return {
        init: function () {
            t = document.querySelector("#kt_sign_in_form");
            e = document.querySelector("#kt_sign_in_submit");

            r = FormValidation.formValidation(t, {
                fields: {
                    email: {
                        validators: {
                            regexp: {
                                regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                                message: "The value is not a valid email address",
                            },
                            notEmpty: {
                                message: "Email address is required",
                            },
                        },
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: "The password is required",
                            },
                        },
                    },
                },
            });

            e.addEventListener("click", function (i) {
                i.preventDefault();

                r.validate().then(function (result) {
                    if (result === "Valid") {
                        e.setAttribute("data-kt-indicator", "on");
                        e.disabled = true;

                        // Submit form biasa, biarkan Laravel handle redirect
                        t.submit();
                    } else {
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary",
                            },
                        });
                    }
                });
            });
        },
    };
})();

KTUtil.onDOMContentLoaded(function () {
    KTSigninGeneral.init();
});
