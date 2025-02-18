@extends('layouts.app')

@section('title', 'Create Post')

@section('content')

@include('sidebar.humburger')
<div class="row main-row">
    @include('sidebar.include-sidebar')
    <div class="col-md-9 ms-sm-auto col-lg-10 user-history " style="">
        <div id="calendar" class="h-100"></div>

        <div class="d-flex justify-content-center mt-3 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    @if (!empty($weightData['labels']) && !empty($weightData['weights']))
                        @include('nutritionists.charts.lineGraphMothly', [
                            'type' => $weightData['type'],
                            'dates' => $weightData['labels'],
                            'weights' => $weightData['weights'],
                            'message' => $weightData['message']
                        ])
                    @else
                        <p>No weight data available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<!-- FullCalendar Styles -->
@push('styles')
<style>
    #calendar {
        max-width: 60%;
        margin: 0 auto;
        background: #ffffff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        padding: 20px;
    }
    #weightChart {
    display: block; /* canvas要素をブロック要素にする */
    margin: 0 auto; /* 左右のmarginをautoに設定して中央揃え */
}

    .main-content {
    padding-bottom: 500px; /* 必要に応じて値を調整 */
}

    .user-history {
    min-height: auto !important;
    height: auto !important;
}

    .fc-toolbar {
        margin-bottom: 20px;
    }

    .fc-toolbar-title {
    font-size: 50px; /* フォントサイズを大きく */
    font-weight: bold; /* 太字にする */
    color: #202F55; /* 既存のカラーと統一 */
}

.fc-toolbar-title {
    font-size: 50px; /* デフォルト: 大画面向け */
    font-weight: bold;
    color: #202F55;
}

    .fc-col-header-cell {
    font-size: 25px; /* 曜日のフォントサイズを大きく */
    font-weight: bold;
    color: #202F55; /* 黒に変更 */
    background-color: #f8f9fa; /* 背景を少し明るいグレーに（オプション） */
    padding: 10px 0; /* 上下に余白を追加 */

}

.fc-col-header-cell a {
    text-decoration: none !important;
    color: inherit; /* 既存の色をそのまま適用 */
}

    .fc-daygrid-event {
        background-color: #4caf50;
        color: white;
        border: none;
        border-radius: 6px;
    }
    .fc-daygrid-day:hover {
        background-color: rgba(0, 128, 0, 0.1);
        cursor: pointer;
    }

    .fc-daygrid-day-number {
    font-size: 25px; /* デフォルトより大きめのフォント */
    font-weight: bold;
    color: #202F55; /* 文字色を濃くする */
}

.fc a {
    text-decoration: none !important;
}

.card {
    width: 60%;
}


/* 📌 レスポンシブ調整 */
@media (max-width: 1200px) {
    #calendar {
        max-width: 90%; /* 画面サイズが小さい場合、カレンダーを広げる */
        min-height: 800px; /* 小さい画面では縦長に */
    }
    .fc-toolbar-title {
        font-size: 30px;
    }

    .fc-col-header-cell {
        font-size: 19px;
    }

    .card {
        width: 90% !important;
    }
}

@media (max-width: 768px) {
    #calendar {
        max-width: 100%; /* モバイルでは画面幅いっぱい */
        padding: 10px;
        min-height: 500px; /* 小さい画面では縦長に */
    }
    .fc-toolbar-title {
        font-size: 25px; /* モバイルでは少し小さめに */
    }

    .fc-col-header-cell {
        font-size: 17px;
    }

    .card{
        width: 100%;
    }
}

@media (max-width: 480px) {
    .fc-toolbar-title {
        font-size: 22px; /* 極小デバイスではさらに縮小 */
    }


    .fc-col-header-cell {
        font-size: 15px;
        font-weight: lighter;
    }
}






</style>
@endpush

<!-- FullCalendar Script -->
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js"></script>
<script>
 document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var userId = "{{ auth()->user()->id }}";

    var mealOrder = { 'Breakfast': 1, 'Lunch': 2, 'Dinner': 3, 'Other': 4 };

    var mealColors = {
        'Breakfast': '#FFA07A', // Light Salmon 🟥
        'Lunch': '#98FB98', // Pale Green 🟩
        'Dinner': '#87CEFA', // Light Sky Blue 🟦
        'Other': '#FFD700' // Gold 🟨
    };

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: ''
        },
        editable: true,
        droppable: true,
        themeSystem: 'standard',

        // 📌 イベントを取得してカレンダーに表示
      events: function(fetchInfo, successCallback, failureCallback) {
        fetch(`/user/${userId}/history/events`)
    .then(response => response.json())
                .then(events => {
                    console.log("取得したイベント:", events); // デバッグ用
                    let mealFullNames = { 'B': 'Breakfast', 'L': 'Lunch', 'D': 'Dinner', 'O': 'Other' };
let mealOrder = { 'Breakfast': 1, 'Lunch': 2, 'Dinner': 3, 'Other': 4 };

let formattedEvents = events.map(event => {
    let mealType = mealFullNames[event.title.charAt(0)] || 'Other'; // 一文字をフルネームに変換

    return {
        title: mealType, // タイトルをフルネームに変更
        start: event.start,
        backgroundColor: event.backgroundColor || mealColors[mealType] || '#808080',
        borderColor: event.borderColor || mealColors[mealType] || '#808080',
        textColor: event.textColor || '#fff',
        mealOrder: mealOrder[mealType] || 99 // ソート用
    };
}).sort((a, b) => a.mealOrder - b.mealOrder); // Breakfast → Lunch → Dinner → Other の順にソート

console.log("Formatted Events:", formattedEvents); // すべてのイベントを表示


                    successCallback(formattedEvents);
                })
                .catch(error => {
                    console.error("イベント取得エラー:", error);
                    failureCallback(error);
                });
},

        // 📌 日付クリック時の処理
        dateClick: function(info) {
            var userId = "{{ auth()->user()->id }}";
            var clickedDate = info.dateStr;
            var url = `/user/${userId}/dailylog/${clickedDate}`;
            window.location.href = url;
        }
    });

    calendar.render();
});




</script>
@endpush
