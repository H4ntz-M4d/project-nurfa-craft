var KTCardOrdersMonth = {
    init: function () {

        axios.get('/dashboard/order-total')
            .then(function (response) {
                const data = response.data;

                // Format angka biasa
                const formatter = new Intl.NumberFormat('id-ID');

                const totalSpan = document.getElementById("order-this-month");
                const badgeSpan = document.getElementById("percentage-order");
                const goalText = document.getElementById("goal-text");
                const progressPercent = document.getElementById("progress-percent");
                const progressBar = document.getElementById("progress-bar");

                if (totalSpan) {
                    totalSpan.textContent = formatter.format(data.total);
                }

                if (badgeSpan) {
                    let badgeClass = 'badge-light-success';
                    let iconClass = 'ki-arrow-up text-success';
                    let symbol = '+';

                    if (data.percentage < 0) {
                        badgeClass = 'badge-light-danger';
                        iconClass = 'ki-arrow-down text-danger';
                        symbol = '';
                    }

                    badgeSpan.className = 'badge ' + badgeClass + ' fs-base';
                    badgeSpan.innerHTML = `
                        <i class="ki-duotone ${iconClass} fs-5 ms-n1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        ${symbol}${Math.abs(data.percentage)}%
                    `;
                }

                // Update bagian "1,048 to Goal" dan "62%"
                if (goalText && progressPercent && progressBar) {
                    let goalMessage = '';
                    if (data.goal_gap <= 0) {
                        goalMessage = `+${Math.abs(data.goal_gap)} orders above goal`;
                    } else {
                        goalMessage = `${formatter.format(data.goal_gap)} to Goal`;
                    }
                    goalText.textContent = goalMessage;

                    const percent = Math.min(data.goal_percentage, 100);
                    progressPercent.textContent = `${percent}%`;
                    progressBar.style.width = `${percent}%`;
                    progressBar.setAttribute('aria-valuenow', percent);
                }
            })
            .catch(function (error) {
                console.error("Gagal ambil data order bulanan:", error);
            });


    },
};
"undefined" != typeof module && (module.exports = KTCardOrdersMonth),
    KTUtil.onDOMContentLoaded(function () {
        KTCardOrdersMonth.init();
    });
