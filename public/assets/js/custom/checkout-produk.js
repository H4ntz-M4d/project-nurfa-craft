"use strict";
var KTCheckoutProcess = (function () {
    return {
        init: function () {
            const form = document.getElementById("form-checkout");
            if (!form) {
                console.warn("Form dengan ID #form-checkout tidak ditemukan.");
                return;
            }

            const submitBtn = document.querySelector("button[type='button']");

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

                const formPay = document.getElementById("form-payment");

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

                        if (data.success && data.snap_token) {
                            // Simpan token dan slug ke sessionStorage
                            sessionStorage.setItem("snap_token", data.snap_token);
                            sessionStorage.setItem("slug", data.slug);

                            formPay.classList.add("d-none");

                            window.snap.embed(data.snap_token, {
                                embedId: 'snap-container',
                                onSuccess: function (result) {
                                    sessionStorage.clear(); // Hapus setelah berhasil
                                    fetch('/delete-keranjang', {
                                            method: 'DELETE',
                                            headers: {
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                                'Accept': 'application/json'
                                            },
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                console.log("Keranjang dihapus:", data);
                                                window.location.href = "/shopping/" + data.slug;
                                            } else {
                                                swal("Gagal menghapus keranjang", data.message || "Terjadi kesalahan", "error");
                                            }
                                        })
                                        .catch(error => {
                                            console.error("Gagal hapus keranjang:", error);
                                        });
                                },
                                onPending: function (result) {
                                    swal("Menunggu Pembayaran", "Transaksi belum selesai.", "info");
                                },
                                onError: function (result) {
                                    swal("Gagal", "Terjadi kesalahan pembayaran.", "error");
                                },
                                onClose: function () {
                                    swal("Dibatalkan", "Kamu menutup pembayaran.", "warning");
                                }
                            });
                        } else {
                            swal("Oops!", data.message || "Checkout gagal", "error");
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

// Deteksi refresh dan tampilkan kembali snap jika token tersedia
document.addEventListener("DOMContentLoaded", function () {
    const existingSnapToken = sessionStorage.getItem("snap_token");
    const slug = sessionStorage.getItem("slug");
    const formPay = document.getElementById("form-payment");

    if (existingSnapToken && slug) {
        // Snap token tersedia, tampilkan embed Snap
        formPay.classList.add("d-none");
        window.snap.embed(existingSnapToken, {
            embedId: 'snap-container',
            onSuccess: function (result) {
                sessionStorage.clear(); // Bersihkan setelah sukses
                fetch('/delete-keranjang', {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log("Keranjang dihapus:", data);
                            window.location.href = "/shopping/" + data.slug;
                        } else {
                            swal("Gagal menghapus keranjang", data.message || "Terjadi kesalahan", "error");
                        }
                    })
                    .catch(error => {
                        console.error("Gagal hapus keranjang:", error);
                    });

            },
            onPending: function (result) {
                swal("Menunggu Pembayaran", "Transaksi belum selesai.", "info");
            },
            onError: function (result) {
                swal("Gagal", "Terjadi kesalahan pembayaran.", "error");
            },
            onClose: function () {
                swal("Dibatalkan", "Kamu menutup pembayaran.", "warning");
            }
        });
    } else {
        // Jalankan proses normal
        KTCheckoutProcess.init();
    }
});
