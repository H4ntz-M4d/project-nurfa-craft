"use strict";
var KTProjectSettings = {
    init: function () {
        !(function () {
            var t;
            $("#kt_datepicker_1").flatpickr();
            var e = document.getElementById("kt_project_settings_form");
            (t = FormValidation.formValidation(e, {
                fields: {
                    name: {
                        validators: {
                            notEmpty: { message: "Project name is required" },
                        },
                    },
                    type: {
                        validators: {
                            notEmpty: { message: "Project type is required" },
                        },
                    },
                    description: {
                        validators: {
                            notEmpty: {
                                message: "Project Description is required",
                            },
                        },
                    },
                    date: {
                        validators: {
                            notEmpty: { message: "Due Date is required" },
                        },
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                    }),
                },
            }));
        })();
    },
};
KTUtil.onDOMContentLoaded(function () {
    KTProjectSettings.init();
});
