
        <h5 class="card-title">5 Major Nutrients</h5>
        <div class="text-center">
            @if (!empty($satisfactionRates))
                <canvas id="nutritionRadarChart" width="200" height="200"></canvas>
            @else
                <p>{{ $message ?? 'No data available.' }}</p>
            @endif
        </div>

@if (!empty($satisfactionRates))
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
   document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('nutritionRadarChart').getContext('2d');

    // PHPから渡された充足率データを取得
    const satisfactionRates = @json($satisfactionRates);

    const labels = Object.keys(satisfactionRates); // 栄養素名
    const values = Object.values(satisfactionRates); // 栄養ごとの充足率

    const chart = new Chart(ctx, {
        type: 'radar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Nutrient Adequacy (%)',
                data: values,
                fill: true,
                backgroundColor: 'rgba(255, 165, 0, 0.2)', // オレンジの透明色
                borderColor: 'rgba(255, 165, 0, 1)', // オレンジの境界線
                pointBackgroundColor: 'rgba(255, 165, 0, 1)', // オレンジのデータポイント
            }]
        },
        options: {
            responsive: true,
            scales: {
                r: {
                    suggestedMin: 0,
                    suggestedMax: 140, // 必要に応じて調整
                    grid: {
                        color: function(context) {
                            return context.index === 5 ? 'green' : 'rgba(0, 0, 0, 0.1)';
                        }
                    },
                    ticks: {
                        stepSize: 20 // グリッド線の間隔
                    },
                    pointLabels: {
                        font: {
                            size: 16, // フォントサイズを大きく
                            weight: 'bold', // 太く表示
                        },
                        color: 'rgba(0, 0, 0, 0.8)' // ラベルの色を変更（黒に近い）
                    }
                }
            }
        }
    });
});

</script>
@endif
