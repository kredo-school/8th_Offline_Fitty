@extends('layouts.app')

@section('title', 'Create Post')

@section('content')

@include('sidebar.humburger')
<div class="row main-row">
    <!-- Header Section -->
    @include('sidebar.user-sidebar')
    <div class="col-md-9 ms-sm-auto col-lg-10 user-history">
        <!-- main content -->
        <h1 class="text-center">History</h1>

        <!-- FullCalendar Section -->
        <div id="calendar" class="mt-4"></div>
    </div>
</div>

<!-- FullCalendar Styles -->
<style>
    #calendar {
        max-width: 100%;
        margin: 0 auto;
        background: #ffffff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        padding: 20px;
    }
    .fc-toolbar {
        margin-bottom: 20px;
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
</style>

<!-- FullCalendar Script -->
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            events: [
                {
                    title: 'Sample Event 1',
                    start: '2025-02-01',
                    color: '#ff5722'
                },
                {
                    title: 'Sample Event 2',
                    start: '2025-02-07',
                    end: '2025-02-10',
                    color: '#2196f3'
                }
            ],
            editable: true,
            droppable: true,
            themeSystem: 'standard'
        });
        calendar.render();
    });
</script>
@endpush
@endsection
