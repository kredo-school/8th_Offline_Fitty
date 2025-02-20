@extends('layouts.app')

@section('title', 'Create Post')

@section('content')

<!-- ハンバーガーメニューボタン -->
@include('sidebar.humburger')

<div class="row main-row">
    @if(Auth::user()->role == "A")
        @include('sidebar.admin-sidebar')
    @elseif(Auth::user()->role == "N")
        @include('sidebar.nutri-sidebar')
    @else
        @include('sidebar.user-sidebar')
    @endif


    <div class="col-md-9 ms-sm-auto col-lg-10" style="min-height: calc(100vh - 190px);">
        <div class="user-dailylog">

            <!-- Header Section -->
            <div class="user-dailylog-header">
                <h1>Meal Log ({{ \Carbon\Carbon::parse($date)->format('D M d') }})</h1>
            </div>



            @php
                $meal_names = [
                    'Breakfast' => '🍳 Breakfast',
                    'Lunch' => '🥗 Lunch',
                    'Dinner' => '🍲 Dinner',
                    'Other' => '🍽️ Other'
                ];
            @endphp

            @foreach ($dailylogs as $dailylog)
                @php
                    $mealType = $dailylog->meal_type;
                    $mealId = $dailylog->id; // unique ID for each meal log
                    $nutritions = json_decode($dailylog->nutritions, true);
                @endphp

                @if (isset($meal_names[$mealType]))
                    <div class="meal-card">
                        <div class="meal-title">{{ $meal_names[$mealType] }}</div>
                        @if($dailylog->image)
                        <img src="{{ $dailylog->image }}" alt="">
                        @endif
                        <p>Meal: {{ $dailylog->meal_content }}</p>
                        @if($dailylog->comment)
                        <p>Comment: {{ $dailylog->comment }}</p>
                        @endif
                        <div class="accordion" id="accordion{{ $mealType }}{{ $mealId }}">

                            @foreach ($categories as $category)
                                @if (isset($nutritions[$category->name]))
                                    @php
                                        $categoryData = $nutritions[$category->name];
                                        $subCategoryData = isset($nutritions["Subcategories"]) ? $nutritions["Subcategories"] : [];
                                    @endphp

                                    <div class="accordion-item custom-accordion-item">
                                        <h2 class="accordion-header" id="heading{{ $mealType }}{{ $category->id }}{{ $mealId }}">
                                            <button class="accordion-button custom-accordion-toggle collapsed" type="button"
                                                data-bs-target="#collapse{{ $mealType }}{{ $category->id }}{{ $mealId }}"
                                                aria-expanded="false"
                                                aria-controls="collapse{{ $mealType }}{{ $category->id }}{{ $mealId }}">
                                                <div class="d-flex justify-content-between align-items-center w-100">
                                                    <span>{{ $category->name }}: {{ $categoryData }}</span>
                                                    <span class="admin-categories-toggle-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <polyline points="8 10 12 14 16 10" class="icon-chevron-down"></polyline>
                                                            <polyline points="8 14 12 10 16 14" class="icon-chevron-up" style="display: none;"></polyline>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $mealType }}{{ $category->id }}{{ $mealId }}" class="accordion-collapse collapse"
                                            aria-labelledby="heading{{ $mealType }}{{ $category->id }}{{ $mealId }}">
                                            <div class="accordion-body">
                                                <ul>
                                                    @foreach ($category->subcategory as $sub_category)
                                                        @if (isset($subCategoryData[$sub_category->name]))
                                                            <li>
                                                                {{ $sub_category->name }}:
                                                                {{ $subCategoryData[$sub_category->name] }}
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="card">
                <div class="card-body">
                    @include('users.charts.radarchartDailylog', [
                        'satisfactionRates' => $satisfactionRates,
                        'user' => $user_profile,
                        'message' => $message ?? 'No data available.'
                    ])
                </div>
            </div>
    </div>
</div>



<script>
document.addEventListener('DOMContentLoaded', function () {
    const accordionButtons = document.querySelectorAll('.custom-accordion-toggle');

    accordionButtons.forEach(button => {
        const targetId = button.getAttribute('aria-controls');
        const target = document.getElementById(targetId);
        const chevronDown = button.querySelector('.icon-chevron-down');
        const chevronUp = button.querySelector('.icon-chevron-up');

        function setInitialState() {
            if (target.classList.contains('show')) {
                chevronDown.style.display = 'none';
                chevronUp.style.display = 'block';
            } else {
                chevronDown.style.display = 'block';
                chevronUp.style.display = 'none';
            }
        }
        setInitialState();

        button.addEventListener('click', function (event) {
            event.preventDefault();
            
            const isOpen = target.classList.contains('show');
            
            document.querySelectorAll('.accordion-collapse.show').forEach(collapse => {
                collapse.classList.remove('show');
                collapse.previousElementSibling.setAttribute('aria-expanded', 'false');
            });
            
            document.querySelectorAll('.custom-accordion-toggle').forEach(btn => {
                btn.setAttribute('aria-expanded', 'false');
            });
            
            document.querySelectorAll('.icon-chevron-down').forEach(icon => icon.style.display = 'block');
            document.querySelectorAll('.icon-chevron-up').forEach(icon => icon.style.display = 'none');

            if (isOpen) {
                target.classList.remove('show');
                button.setAttribute('aria-expanded', 'false');
                chevronDown.style.display = 'block';
                chevronUp.style.display = 'none';
            } else {
                target.classList.add('show');
                button.setAttribute('aria-expanded', 'true');
                chevronDown.style.display = 'none';
                chevronUp.style.display = 'block';
            }
        });
    });
});
</script>

@endsection
