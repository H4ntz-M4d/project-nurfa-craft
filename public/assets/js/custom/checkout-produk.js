"use strict";
var KTCheckoutProcess = (function () {
    return {
        init: function () {
            const form = document.getElementById("form-checkout");
            if (!form) {
                console.warn("Form dengan ID #form-checkout tidak ditemukan.");
                return;
            }

            const submitBtn = document.querySelector("button[type='submit']");

            submitBtn.addEventListener("click", function (e) {
                e.preventDefault();

                // Ambil inputan
                const provinsi = form.querySelector("[name='provinsi']").value.trim();
                const kota = form.querySelector("[name='kota']").value.trim();
                const alamat = form.querySelector("[name='alamat_pengiriman']").value.trim();
                                
                // Hapus format ribuan dari total dan subtotal
                const totalInput = form.querySelector("input[name='total']");
                const subtotalInput = form.querySelector("input[name='subtotal']");
                
                if (totalInput) {
                    totalInput.value = totalInput.value.replace(/\./g, "").replace(/[^\d]/g, "");
                }
                if (subtotalInput) {
                    subtotalInput.value = subtotalInput.value.replace(/\./g, "").replace(/[^\d]/g, "");
                }

                // Validasi manual
                let errors = [];

                if (!provinsi || provinsi === "Pilih Provinsi") {
                    errors.push("Provinsi wajib dipilih.");
                }

                if (!kota || kota === "Pilih Kabupaten") {
                    errors.push("Kabupaten/Kota wajib dipilih.");
                }

                if (!alamat) {
                    errors.push("Alamat pengiriman tidak boleh kosong.");
                } else if (alamat.length > 255) {
                    errors.push("Alamat maksimal 255 karakter.");
                }

                if (errors.length > 0) {
                        swal("Oops!", "Validasi gagal", "error");
                    return;
                }

                // Validasi sukses, kirim form
                submitBtn.setAttribute("data-kt-indicator", "on");
                submitBtn.disabled = true;

                const formData = new FormData(form);
                fetch(form.getAttribute("action"), {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        "Accept": "application/json",
                    },
                })
                .then((res) => res.json())
                .then((data) => {
                    submitBtn.removeAttribute("data-kt-indicator");
                    submitBtn.disabled = false;

                    if (data.success) {
                        swal("Ok","Checkout produk", "success");
                    } else {
                        swal("Oops!","Checkout gagal", "error");
                    }
                })
                .catch((err) => {
                    console.error(err);
                    swal("Gagal memproses transaksi. Silakan coba lagi", err, "error");
                });
            });
        }
    };
})();

document.addEventListener("DOMContentLoaded", function () {
    KTCheckoutProcess.init();
});
