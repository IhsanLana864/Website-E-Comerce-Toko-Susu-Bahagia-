// Chart hanya dipakai di dashboard.blade.php
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById("myChart");
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Barang Masuk', 'Barang Keluar'],
                datasets: [{
                    label: 'Jumlah',
                    data: [120, 90],
                    backgroundColor: ['#007bff', '#ffc107']
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
});
