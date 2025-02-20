<div class="user-dailylog">
    <!-- Header Section -->
    <div class="user-dailylog-header">
        <h1>Meal Log</h1>
    </div>

    @php
        $meal_names = [
            'Breakfast' => '🍳 Breakfast',
            'Lunch' => '🥗 Lunch',
            'Dinner' => '🍲 Dinner',
            'Other' => '🍽️ Other'
        ];

        // dailylogs を日付ごとにグループ化
        $groupedLogs = $dailylogs->groupBy(function ($log) {
            return \Carbon\Carbon::parse($log->input_date)->format('Y-m-d');
        });
    @endphp

    <div class="accordion" id="dailylogAccordion">
        @foreach ($groupedLogs as $date => $logs)
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-target="collapseDate{{ $date }}" aria-expanded="false">
                        <span class="fw-bold">{{ \Carbon\Carbon::parse($date)->format('D M d') }}</span>
                        <span class="admin-categories-toggle-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="8 10 12 14 16 10" class="icon-chevron-down"></polyline>
                                <polyline points="8 14 12 10 16 14" class="icon-chevron-up" style="display: none;"></polyline>
                            </svg>
                        </span>
                    </button>
                </h2>
                <div id="collapseDate{{ $date }}" class="accordion-collapse">
                    <div class="accordion-body">
                        @foreach ($logs as $dailylog)
                            @php
                                $mealType = $dailylog->meal_type;
                                $mealId = $dailylog->id;
                                $nutritions = json_decode($dailylog->nutritions, true);
                            @endphp
                            @if (isset($meal_names[$mealType]))
                                <div class="meal-card">
                                    <div class="meal-title">
                                            {{ $meal_names[$mealType] }}                                           
                                    </div>
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
                                                    data-bs-toggle="collapse"
                                                    data-target="#collapse{{ $mealType }}{{ $category->id }}{{ $mealId }}"
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
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
              const accordionButtons = document.querySelectorAll('.accordion-button');

accordionButtons.forEach(button => {
    button.addEventListener('click', function (event) {
        event.preventDefault(); // Bootstrap のデフォルト動作を無効化

        // Bootstrap の `data-target` を取得
        const targetId = this.getAttribute('data-target'); 
        if (!targetId) {
            console.error("data-target is missing on:", this);
            return;
        }

        // `#` を削除して `id` を取得
        const target = document.getElementById(targetId.replace("#", ""));
        if (!target) {
            console.error("Target not found:", targetId);
            return;
        }

        // 現在のターゲットの開閉処理
        const isOpen = target.classList.contains('show');
        if (isOpen) {
            target.classList.remove('show');
            target.style.maxHeight = "0px";
            this.setAttribute('aria-expanded', 'false');
        } else {
            target.classList.add('show');
            target.style.maxHeight = target.scrollHeight + "px"; // 高さを調整
            this.setAttribute('aria-expanded', 'true');
        }
    });
});
});
</script>

<style>
            .accordion-collapse {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
            display: none; /* display を none にしないと開閉しない可能性あり */
        }

        .accordion-collapse.open {
            display: block;
            max-height: 1000px; /* 必要に応じて調整 */
            transition: max-height 0.3s ease-in;
        }
        
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.5) !important;
        }

        .accordion-body {
            max-height: 1000px;  /* 最大高さを設定 */
            overflow-y: auto;   /* 必要に応じて縦スクロールを有効化 */
            padding: 10px;
            border: 1px solid #ddd;
            background: #f9f9f9;
        }
</style>