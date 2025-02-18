<div>
    <button id="dailyBtn">Daily</button>
    <button id="weeklyBtn">Weekly</button>
    <button id="monthlyBtn">Monthly</button>
</div>

<div>
    <p id="message">{{ $message }}</p>
    <canvas id="weightChart" style="display: none;"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    let chart = null; // チャートを格納する変数
    const ctx = document.getElementById('weightChart').getContext('2d');
    const messageElement = document.getElementById('message');
    const canvasElement = document.getElementById('weightChart');
    const userId = "{{ $user->id }}"; // BladeからユーザーIDを取得

    function createChart(labels, weights, type) {
        if (chart) {
            chart.destroy(); // 既存のチャートを削除
        }

        chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: type.charAt(0).toUpperCase() + type.slice(1) + ' Average Weight (kg)',
                    data: weights,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
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
    }

    // 🚀 `fetchData` を `window` に登録（どこからでも呼び出せるようにする）
    window.fetchData = function(type) {
    console.log("Fetching data for:", type);

    fetch(`/user/${userId}/history/weight-data?type=${type}`) // ✅ 修正
        .then(response => {
            console.log("Raw Response:", response);

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            return response.json();
        })
        .then(data => {
            console.log("Fetched Data:", data);

            if (!data.weightData || !data.weightData.labels || !data.weightData.weights) {
                console.error("Invalid response data:", data);
                messageElement.innerText = "Data could not be retrieved.";
                canvasElement.style.display = 'none';
                return;
            }

            if (data.weightData.weights.length === 0) {
                messageElement.innerText = data.weightData.message || 'No data available.';
                canvasElement.style.display = 'none';
            } else {
                messageElement.innerText = '';
                canvasElement.style.display = 'block';
                createChart(data.weightData.labels, data.weightData.weights, type);
            }
        })
        .catch(error => {
            console.error("Error fetching data:", error);
            messageElement.innerText = "Error fetching data.";
            canvasElement.style.display = 'none';
        });
    };


    // 📌 初期ロード時にデフォルトのデータを表示（例: monthly）
    fetchData('monthly');

    // 📌 ボタンに `fetchData()` を紐付け（イベントリスナーを使用）
    document.getElementById('dailyBtn').addEventListener('click', () => fetchData('daily'));
    document.getElementById('weeklyBtn').addEventListener('click', () => fetchData('weekly'));
    document.getElementById('monthlyBtn').addEventListener('click', () => fetchData('monthly'));
});
</script>
