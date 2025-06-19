document.addEventListener('DOMContentLoaded', function () {
    const chartContainer = document.getElementById('chart-wrapper');
    if (!chartContainer) return;

    const chartData = JSON.parse(chartContainer.dataset.chart);
    const year = chartContainer.dataset.year;

    const ctx = document.getElementById('courrierChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: [
                'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
                'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
            ],
            datasets: [{
                label: `Courriers - ${year}`,
                data: chartData,
                borderColor: '#10B981',
                backgroundColor: 'rgba(16, 185, 129, 0.2)',
                tension: 0.4,
                pointBackgroundColor: '#10B981',
                fill: true,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });
});
