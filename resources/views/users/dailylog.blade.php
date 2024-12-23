@extends('layouts.app')

@section('title', 'Create Post')

@section('content')
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }

        .meal-container {
            margin: 30px auto;
            max-width: 1200px;
        }

        .meal-card {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
        }

        .meal-title {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 10px;
        }

        .accordion-button {
            font-weight: bold;
            color: #555;
        }
                /* アコーディオンボタンの色変更 */
                .accordion-button {
            background-color: #91CF98; /* 緑色 */
            color: #ffffff; /* 白色 */
            font-weight: bold;
        }

        .accordion-button:not(.collapsed) {
            background-color: #91CF98; /* 展開時の背景色 */
            color: #ffffff; /* 展開時のテキスト色 */
        }

        .accordion-button:focus {
            box-shadow: none; /* フォーカス時の枠線を無効に */
        }

        .accordion-body {
            background-color: #f8f9fa;
        }
    </style>

<div class="container meal-container">
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