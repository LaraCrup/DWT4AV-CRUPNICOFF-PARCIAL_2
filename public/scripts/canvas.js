document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('salesChart').getContext('2d');

    const dailySalesData = window.dailySalesData || [];

    const labels = dailySalesData.map(item => item.fecha);
    const data = dailySalesData.map(item => item.total);

    const hasData = labels.length > 0;
    const chartLabels = hasData ? labels : ['29/08', '30/08', '31/08', '1/09', '3/09', '4/09', '5/09'];
    const chartData = hasData ? data : [12450, 9800, 10200, 11500, 13200, 16300, 15240];

    const salesData = {
        labels: chartLabels,
        datasets: [{
            label: 'Ventas diarias ($)',
            data: chartData,
            backgroundColor: 'rgba(147, 129, 255, 0.2)',
            borderColor: '#9381FF',
            borderWidth: 2,
            tension: 0.3,
            fill: true,
            pointBackgroundColor: '#9381FF',
            pointRadius: 4
        }]
    };

    const config = {
        type: 'line',
        data: salesData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        callback: function (value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return '$' + context.raw.toLocaleString();
                        }
                    }
                }
            }
        }
    };

    new Chart(ctx, config);
});