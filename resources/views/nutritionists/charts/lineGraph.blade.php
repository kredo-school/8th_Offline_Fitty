<div>
    @if(empty($weights))
        <p>{{ $message }}</p>
    @else
        <canvas id="weightChart"></canvas>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('weightChart').getContext('2d');
        const weightChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($dates), // 修正: 日付ごとのラベル
                datasets: [{
                    label: 'Daily Average Weight (kg)',
                    data: @json($weights), // 修正: 平均体重
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Weight (kg)'
                        },
                        beginAtZero: false
                    }
                }
            }
        });
    });
</script>
