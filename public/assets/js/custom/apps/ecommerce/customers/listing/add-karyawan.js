"use strict";
var KTModalEmployee = (function () {
    var e, t, o;
    return {
        init: function () {
            (e = document.querySelector("#kt_modal_employee_stepper")),
            (o = document.querySelector("#kt_modal_employee_form")),
            (t = new KTStepper(e));
        },
        getStepper: function () {
            return e;
        },
        getStepperObj: function () {
            return t;
        },
        getForm: function () {
            return o;
        },
    };
})();

// First step validation and actions - Account details
var KTModalEmployeeAccount = (function () {
    var e, t, o, r;  
    return {
        init: function () {
            (o = KTModalEmployee.getForm()),
            (r = KTModalEmployee.getStepperObj()),
            (e = KTModalEmployee.getStepper().querySelector(
                '[data-kt-element="account-next"]'
            )),
            (t = FormValidation.formValidation(o, {
                fields: {
                    username: {
                        validators: {
                            notEmpty: { message: "Username is required" },
                        },
                    },
                    email: {
                        validators: {
                            notEmpty: { message: "Email is required" },
                            emailAddress: { message: "The value is not a valid email address" },
                        },
                    },
                    password: {
                        validators: {
                            notEmpty: { message: "Password is required" },
                            stringLength: {
                                min: 8,
                                message: "Password must be at least 8 characters long"
                            }
                        },
                    },
                    password_confirmation: {
                        validators: {
                            notEmpty: { message: "Confirm password is required" },
                            identical: {
                                compare: function() {
                                    return o.querySelector('[name="password"]').value;
                                },
                                message: 'The password and confirmation password do not match'
                            }
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
            e.addEventListener("click", function (o) {
                o.preventDefault(),
                (e.disabled = !0),
                t && t.validate().then(function (t) {
                    console.log("validated!"),
                    "Valid" == t
                        ? (e.setAttribute("data-kt-indicator", "on"),
                          // Save account data to database via AJAX
                          saveAccountData().then(function(response) {
                              if (response.success) {
                                  e.removeAttribute("data-kt-indicator");
                                  e.disabled = !1;
                                  // Store id_user for the next step
                                  document.querySelector('[name="id_user"]').value = response.id_user;
                                  r.goNext();
                              } else {
                                  e.removeAttribute("data-kt-indicator");
                                  e.disabled = !1;
                                  Swal.fire({
                                      text: response.message || "error respon.",
                                      icon: "error",
                                      buttonsStyling: !1,
                                      confirmButtonText: "Ok, got it!",
                                      customClass: {
                                          confirmButton: "btn btn-primary",
                                      },
                                  });
                              }
                          }).catch(function(error) {
                              e.removeAttribute("data-kt-indicator");
                              e.disabled = !1;
                              Swal.fire({
                                  text: "error melakukan save.",
                                  icon: "error",
                                  buttonsStyling: !1,
                                  confirmButtonText: "Ok, got it!",
                                  customClass: {
                                      confirmButton: "btn btn-primary",
                                  },
                              });
                          }))
                        : ((e.disabled = !1),
                          Swal.fire({
                              text: "aneh are some errors detected, please try again.",
                              icon: "error",
                              buttonsStyling: !1,
                              confirmButtonText: "Ok, got it!",
                              customClass: {
                                  confirmButton: "btn btn-primary",
                              },
                          }));
                });
            });

            // Function to save account data
            function saveAccountData() {
                return new Promise(function(resolve, reject) {
                    const formData = new FormData();
                    formData.append('username', o.querySelector('[name="username"]').value);
                    formData.append('email', o.querySelector('[name="email"]').value);
                    formData.append('password', o.querySelector('[name="password"]').value);
                    
                    fetch(o.getAttribute("data-kt-account-url"), {
                        method: "POST",
                        body: formData,
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => resolve(data))
                    .catch(error => reject(error));
                });
            }
        },
    };
})();

// Second step validation and actions - Employee details
var KTModalEmployeeDetails = (function () {
    var e, t, a, i, o;
    return {
        init: function () {
            (i = KTModalEmployee.getForm()),
            (o = KTModalEmployee.getStepperObj()),
            (e = KTModalEmployee.getStepper().querySelector(
                '[data-kt-element="details-next"]'
            )),
            (t = KTModalEmployee.getStepper().querySelector(
                '[data-kt-element="details-previous"]'
            )),
            // Initialize date picker
            $(i.querySelector('[name="birth_date"]')).flatpickr({ 
                dateFormat: "Y-m-d" 
            }),
            (a = FormValidation.formValidation(i, {
                fields: {
                    nama: {
                        validators: {
                            notEmpty: { message: "Full name is required" },
                        },
                    },
                    no_telp: {
                        validators: {
                            notEmpty: { message: "Phone number is required" },
                            regexp: {
                                regexp: /^[0-9]+$/,
                                message: "The phone number can only contain digits",
                            },
                        },
                    },
                    alamat: {
                        validators: {
                            notEmpty: { message: "Address is required" },
                        },
                    },
                    tempat_lahir: {
                        validators: {
                            notEmpty: { message: "Birth place is required" },
                        },
                    },
                    tgl_lahir: {
                        validators: {
                            notEmpty: { message: "Birth day is required" },
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
            e.addEventListener("click", function (t) {
                t.preventDefault(),
                (e.disabled = !0),
                a && a.validate().then(function (t) {
                    console.log("validated!"),
                    "Valid" == t
                        ? (e.setAttribute("data-kt-indicator", "on"),
                          saveEmployeeDetails().then(function(response) {
                              if (response.success) {
                                  e.removeAttribute("data-kt-indicator");
                                  e.disabled = !1;
                                  o.goNext();
                                  // Show success message in the final step
                                  Swal.fire({
                                      text: "Employee data has been successfully saved!",
                                      icon: "success",
                                      buttonsStyling: !1,
                                      confirmButtonText: "Ok, got it!",
                                      customClass: {
                                          confirmButton: "btn btn-primary",
                                      },
                                  }).then(function() {
                                      // Optional: redirect or other action after completion
                                      // window.location.href = response.redirect;
                                  });
                              } else {
                                  e.removeAttribute("data-kt-indicator");
                                  e.disabled = !1;
                                  Swal.fire({
                                      text: response.message || "Sorry, looks like there are some errors detected, please try again.",
                                      icon: "error",
                                      buttonsStyling: !1,
                                      confirmButtonText: "Ok, got it!",
                                      customClass: {
                                          confirmButton: "btn btn-primary",
                                      },
                                  });
                              }
                          }).catch(function(error) {
                              e.removeAttribute("data-kt-indicator");
                              e.disabled = !1;
                              Swal.fire({
                                  text: "Sorry, looks like there are some errors detected, please try again.",
                                  icon: "error",
                                  buttonsStyling: !1,
                                  confirmButtonText: "Ok, got it!",
                                  customClass: {
                                      confirmButton: "btn btn-primary",
                                  },
                              });
                          }))
                        : ((e.disabled = !1),
                          Swal.fire({
                              text: "Sorry, looks like there are some errors detected, please try again.",
                              icon: "error",
                              buttonsStyling: !1,
                              confirmButtonText: "Ok, got it!",
                              customClass: {
                                  confirmButton: "btn btn-primary",
                              },
                          }));
                });
            }),
            
            t.addEventListener("click", function () {
                o.goPrevious();
            });

            // Function to save employee details
            function saveEmployeeDetails() {
                return new Promise(function(resolve, reject) {
                    const formData = new FormData();
                    formData.append('id_user', i.querySelector('[name="id_user"]').value);
                    formData.append('nama', i.querySelector('[name="nama"]').value);
                    formData.append('no_telp', i.querySelector('[name="no_telp"]').value);
                    formData.append('alamat', i.querySelector('[name="alamat"]').value);
                    formData.append('jkel', i.querySelector('[name="jkel"]').value);
                    formData.append('tempat_lahir', i.querySelector('[name="tempat_lahir"]').value);
                    formData.append('tgl_lahir', i.querySelector('[name="tgl_lahir"]').value);
                    
                    fetch(i.getAttribute("data-kt-details-url"), {
                        method: "POST",
                        body: formData,
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => resolve(data))
                    .catch(error => reject(error));
                });
            }
        },
    };
})();

// For the completion step
var KTModalEmployeeComplete = (function () {
    var e, t;
    return {
        init: function () {
            (t = KTModalEmployee.getStepperObj()),
            (e = KTModalEmployee.getStepper().querySelector(
                '[data-kt-element="complete-start"]'
            )),
            e && e.addEventListener("click", function () {
                // Reset form and go back to first step
                KTModalEmployee.getForm().reset();
                t.goTo(1);
            });
        },
    };
})();

// Initialize on DOM content loaded
KTUtil.onDOMContentLoaded(function () {
    document.querySelector("#kt_modal_employee") &&
        (KTModalEmployee.init(),
        KTModalEmployeeAccount.init(),
        KTModalEmployeeDetails.init(),
        KTModalEmployeeComplete.init());
});

// Export for module use if needed
"undefined" != typeof module &&
    void 0 !== module.exports &&
    (window.KTModalEmployee = module.exports = KTModalEmployee);