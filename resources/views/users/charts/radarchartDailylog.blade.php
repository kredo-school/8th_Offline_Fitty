
<h3 class="card-title text-center">5 Major Nutrients</h3>
<div class="text-center">
    @if (!empty($satisfactionRates))
        <canvas id="nutritionRadarChart" width="200" height="200" class="mx-auto"></canvas>
    @else
        <p>{{ $message ?? 'No data available.' }}</p>
    @endif
</div>

@if (!empty($satisfactionRates))
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
const ctx = document.getElementById('nutritionRadarChart').getContext('2d');

const satisfactionRates = @json($satisfactionRates);
const labels = Object.keys(satisfactionRates);
const values = Object.values(satisfactionRates);

const chart = new Chart(ctx, {
type: 'radar',
data: {
    labels: labels,
    datasets: [{
        label: 'Nutrient Adequacy (%)',
        data: values,
        fill: true,
        backgroundColor: 'rgba(255, 165, 0, 0.2)',
        borderColor: 'rgba(255, 165, 0, 1)',
        pointBackgroundColor: 'rgba(255, 165, 0, 1)',
    }]
},
options: {
    responsive: true,
    maintainAspectRatio: false, // ← これを追加
    scales: {
        r: {
            suggestedMin: 0,
            suggestedMax: 140,
            ticks: {
                stepSize: 20
            },
            pointLabels: {
                font: {
                    size: 14,
                    weight: 'bold'
                }
            }
        }
    }
}
});
});


</script>
@endif
