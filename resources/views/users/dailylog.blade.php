@extends('layouts.app')

@section('title', 'Create Post')

@section('content')

<!-- ハンバーガーメニューボタン -->
@include('sidebar.humburger')

<div class="row main-row">
    @include('sidebar.user-sidebar')

    <div class="col-md-9 ms-sm-auto col-lg-10">
        <div class="user-dailylog">

            <!-- Header Section -->
            <div class="user-dailylog-header">
                <h1>Daily Log ({{ \Carbon\Carbon::parse($date)->format('D M d') }})</h1>
            </div>

            @php
                $meal_names = ['Breakfast' => '🍳 Breakfast', 'Lunch' => '🥗 Lunch', 'Dinner' => '🍲 Dinner'];
            @endphp

            @foreach ($dailylogs as $dailylog)
                @php
                    $mealType = $dailylog->meal_type; // 各dailylogの食事タイプ（Breakfast, Lunch, Dinner）
                    $nutritions = json_decode($dailylog->nutritions, true); // JSON を配列に変換
                @endphp

                @if (isset($meal_names[$mealType]))
                    <div class="meal-card">
                        <div class="meal-title">{{ $meal_names[$mealType] }}</div>
                        <p>Weight: {{ $dailylog->weight }}Kg</p>
                        <div class="accordion" id="accordion{{ $mealType }}">

                            @foreach ($categories as $category)
                                @if (isset($nutritions[$category->name])) 
                                    @php
                                        $categoryData = $nutritions[$category->name];
                                        $subCategoryData = $nutritions["Subcategories"];
                                    @endphp
                                    
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading{{ $mealType }}{{ $category->id }}">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse{{ $mealType }}{{ $category->id }}" 
                                                aria-expanded="true" 
                                                aria-controls="collapse{{ $mealType }}{{ $category->id }}">
                                                {{ $category->name }}: {{ $categoryData  }}
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $mealType }}{{ $category->id }}" class="accordion-collapse collapse"
                                            aria-labelledby="heading{{ $mealType }}{{ $category->id }}" 
                                            data-bs-parent="#accordion{{ $mealType }}">
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
    </div>
</div>

@endsection
