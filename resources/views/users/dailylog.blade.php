@extends('layouts.app')

@section('title', 'Create Post')

@section('content')

<div class="container user-dailylog">
    <!-- Header Section -->
    <div class="user-dailylog-header">
        <h1>Daily Log (Thu Dec 26)</h1>
        <p>Weight: 64.5Kg</p>
    </div>

    <!-- 朝食 -->
    <div class="meal-card">
        <div class="meal-title">🍳 Breakfast</div>
        <div class="accordion" id="accordionBreakfast">
            <!-- タンパク質（アコーディオン） -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingProteinBreakfast">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProteinBreakfast" aria-expanded="true" aria-controls="collapseProteinBreakfast">
                        Protein: 20g
                    </button>
                </h2>
                <div id="collapseProteinBreakfast" class="accordion-collapse collapse" aria-labelledby="headingProteinBreakfast" data-bs-parent="#accordionBreakfast">
                    <div class="accordion-body">
                        <ul>
                            <li>ロイシン (Leucine): 2100mg</li>
                            <li>イソロイシン (Isoleucine): 1200mg</li>
                            <li>バリン (Valine): 1300mg</li>
                            <li>リジン (Lysine): 1500mg</li>
                            <li>メチオニン (Methionine): 500mg</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 昼食 -->
    <div class="meal-card">
        <div class="meal-title">🥗 Lunch</div>
        <div class="accordion" id="accordionLunch">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingProteinLunch">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProteinLunch" aria-expanded="true" aria-controls="collapseProteinLunch">
                        タンパク質: 25g
                    </button>
                </h2>
                <div id="collapseProteinLunch" class="accordion-collapse collapse" aria-labelledby="headingProteinLunch" data-bs-parent="#accordionLunch">
                    <div class="accordion-body">
                        <ul>
                            <li>アミノ酸A: 12g</li>
                            <li>アミノ酸B: 8g</li>
                            <li>アミノ酸C: 5g</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 夕食 -->
    <div class="meal-card">
        <div class="meal-title">🍲 Dinner</div>
        <div class="accordion" id="accordionDinner">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingProteinDinner">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProteinDinner" aria-expanded="true" aria-controls="collapseProteinDinner">
                        タンパク質: 30g
                    </button>
                </h2>
                <div id="collapseProteinDinner" class="accordion-collapse collapse" aria-labelledby="headingProteinDinner" data-bs-parent="#accordionDinner">
                    <div class="accordion-body">
                        <ul>
                            <li>アミノ酸A: 15g</li>
                            <li>アミノ酸B: 10g</li>
                            <li>アミノ酸C: 5g</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






@endsection