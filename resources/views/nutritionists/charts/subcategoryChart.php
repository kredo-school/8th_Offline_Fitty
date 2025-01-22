<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ $category }} Subcategories</h5>
        <div class="text-center">
            @if (!empty($subCategoryRates))
                <canvas id="subcategoryChart_{{ $category }}" width="400" height="400"></canvas>
            @else
                <p class="text-danger">{{ $message ?? 'No data available.' }}</p>
            @endif
        </div>
    </div>
</div>

@if (!empty($subCategoryRates))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('subcategoryChart_{{ $category }}').getContext('2d');
        const subCategoryRates = @json($subCategoryRates);

        const labels = Object.keys(subCategoryRates); // サブカテゴリ名
        const values = Object.values(subCategoryRates); // 各サブカテゴリの充足率

        const chart = new Chart(ctx, {
            type: 'bar', // レーダー以外にバーも可能
            data: {
                labels: labels,
                datasets: [{
                    label: '{{ $category }} Subcategories (%)',
                    data: values,
                    backgroundColor: 'rgba(255, 165, 0, 0.6)',
                    borderColor: 'rgba(255, 165, 0, 1)',
                    borderWidth: 1,
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        suggestedMax: 150 // 必要に応じて調整
                    }
                }
            }
        });
    });
</script>
@endif
