var KTCardTotalCustomers = {
    init: function () {
        axios.get('/dashboard/total-customers')
            .then(function (response) {
                const total = response.data.total;
                const latestUsers = response.data.latest_users;

                // Format angka
                const formatted = formatNumber(total);
                const totalSpan = document.getElementById("total-customers");
                if (totalSpan) {
                    totalSpan.textContent = formatted;
                }

                // Tampilkan 6 user terbaru
                const userContainer = document.getElementById("latest-users-group");
                if (userContainer) {
                    userContainer.innerHTML = ''; // Clear sebelumnya

                    const bgColors = [
                        'bg-primary',
                        'bg-success',
                        'bg-danger',
                        'bg-warning',
                        'bg-info',
                        'bg-dark'
                    ];

                    const totalDisplayed = 6;

                    latestUsers.forEach((user, index) => {
                        const namaCustomer = user.customers?.nama || 'U';
                        const firstLetter = namaCustomer.charAt(0).toUpperCase();
                        const tooltip = namaCustomer;
                        const colorClass = bgColors[index % bgColors.length];

                        const el = document.createElement('div');
                        el.className = 'symbol symbol-35px symbol-circle';
                        el.setAttribute('data-bs-toggle', 'tooltip');
                        el.setAttribute('title', tooltip);
                        el.innerHTML = `
                            <span class="symbol-label ${colorClass} text-white fw-bold">${firstLetter}</span>
                        `;
                        userContainer.appendChild(el);
                    });

                    // Tambahkan badge "+N" jika total > 6
                    if (total > totalDisplayed) {
                        const moreCount = total - totalDisplayed;
                        const moreEl = document.createElement('a');
                        moreEl.href = "#";
                        moreEl.className = 'symbol symbol-35px symbol-circle';
                        moreEl.setAttribute('data-bs-toggle', 'modal');
                        moreEl.setAttribute('data-bs-target', '#kt_modal_view_users');
                        moreEl.innerHTML = `
                            <span class="symbol-label bg-light text-gray-400 fs-8 fw-bold">+${moreCount}</span>
                        `;
                        userContainer.appendChild(moreEl);
                    }

                    // Re-init tooltip
                    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    tooltipTriggerList.map(function (tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl);
                    });

                }
            })
            .catch(function (error) {
                console.error("Gagal mengambil data total customers:", error);
            });
    }
};

// Format angka ke singkatan k / M
function formatNumber(num) {
    if (num >= 1000000) return (num / 1000000).toFixed(1) + "M";
    if (num >= 1000) return (num / 1000).toFixed(1) + "k";
    return num.toString();
}

"undefined" != typeof module && (module.exports = KTCardTotalCustomers),
    KTUtil.onDOMContentLoaded(function () {
        KTCardTotalCustomers.init();
    });
