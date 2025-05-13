document.addEventListener('DOMContentLoaded', function() {
    // مخطط توزيع المهام حسب الأولوية
    const priorityCtx = document.getElementById('priorityChart').getContext('2d');
    const priorityChart = new Chart(priorityCtx, {
        type: 'doughnut',
        data: {
            labels: ['منخفضة', 'متوسطة', 'عالية'],
            datasets: [{
                data: [priorityData.low, priorityData.medium, priorityData.high],
                backgroundColor: [
                    '#28a745',
                    '#ffc107',
                    '#dc3545'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    rtl: true
                }
            }
        }
    });

    // مخطط إنجاز المهام حسب الأولوية
    const completionCtx = document.getElementById('completionChart').getContext('2d');
    const completionChart = new Chart(completionCtx, {
        type: 'bar',
        data: {
            labels: ['منخفضة', 'متوسطة', 'عالية'],
            datasets: [
                {
                    label: 'مكتملة',
                    data: [completionData.low, completionData.medium, completionData.high],
                    backgroundColor: '#4361ee'
                },
                {
                    label: 'غير مكتملة',
                    data: [
                        priorityData.low - completionData.low,
                        priorityData.medium - completionData.medium,
                        priorityData.high - completionData.high
                    ],
                    backgroundColor: '#6c757d'
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    stacked: true,
                },
                y: {
                    stacked: true,
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    rtl: true
                }
            }
        }
    });
});