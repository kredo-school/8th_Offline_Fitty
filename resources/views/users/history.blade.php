@extends('layouts.app')

@section('title', 'Create Post')

@section('content')

@include('sidebar.humburger')
<div class="row main-row">
    <!-- Header Section -->
    @include('sidebar.include-sidebar')
    <div class="col-md-9 ms-sm-auto col-lg-10 user-history " style="min-height: calc(100vh - 190px);">
        <!-- main content -->
        <!-- FullCalendar Section -->
        <div id="calendar" class="h-100"></div>
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
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth', // 📌 デフォルトビューを「月」に固定
        headerToolbar: {
            left: 'prev,next today',  // 📌 ナビゲーションボタンのみ
            center: 'title',
            right: '' // 📌 他のビュー切り替えボタンを削除
        },
        editable: true,
        droppable: true,
        themeSystem: 'standard',

        // 📌 追加: 日付クリック時の処理
        dateClick: function(info) {
            var userId = "{{ auth()->user()->id }}"; // 現在のユーザーIDを取得
            var clickedDate = info.dateStr; // クリックされた日付

            // URLを生成
            var url = `/user/${userId}/dailylog/${clickedDate}`;

            // 画面遷移
            window.location.href = url;
        }
    });
    calendar.render();
});

</script>
@endpush
