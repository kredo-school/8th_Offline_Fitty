@extends('layouts.app')
@section('title', 'Send Advice')
@section('content')
    <div class="container send-container">
        <div class="custom-left-section">
            <!-- Back Button -->
            <div class="fixed-back-button">
                <button class="btn btn-outline-secondary custom-back-button" onclick="window.history.back()">&larr;</button>
            </div>

            <!-- User Information -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="user-photo-container">
                            @if ($user_profile->profile_image)
                                <img src="{{ $user_profile->profile_image }}" class="user-photo" alt="Avatar">
                            @else
                                <span class="material-symbols-outlined nutri-material-symbols-outlined-user-photo"
                                    style="font-size:80px;">account_circle</span>
                            @endif
                        </div>
                        <div class="user-info-custom ms-4">
                            <table class="table table-borderless custom-table-text-color">
                                <tr>
                                    <td><strong>Name:</strong></td>
                                    <td class="text-start custom-data">{{$user_profile->first_name}} {{$user_profile->last_name}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Birthday:</strong></td>
                                    <td class="text-start custom-data">
                                        {{$user_profile->birthday}}
                                        ({{ \Carbon\Carbon::parse($user_profile->birthday)->age }})
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Gender:</strong></td>
                                    <td class="text-start custom-data">{{ $user_profile->gender }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Height(cm):</strong></td>
                                    <td class="text-start custom-data">{{ $user_profile->height }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Exercise Frequency:</strong></td>
                                    <td class="text-start custom-data">{{ $user_profile->activity_level }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Current Health Conditions:</strong></td>
                                    <td class="text-start custom-data">{!! implode('<br>', json_decode($user_profile->health_conditions)) !!}</td>
                                </tr>
                                <tr>
                                    <td><strong>Dietary Preferences:</strong></td>
                                    <td class="text-start custom-data">{!! implode('<br>', json_decode($user_profile->dietary_preferences)) !!}</td>
                                </tr>
                                <tr>
                                    <td><strong>Food Allergies:</strong></td>
                                    <td class="text-start custom-data">{{ $user_profile->food_allergies }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Goals:</strong></td>
                                    <td class="text-start custom-data">{{ $user_profile->goal }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <strong>Memo</strong>
                                        <span class="material-symbols-outlined memo-icon" data-bs-toggle="modal" data-bs-target="#memoModal">
                                            edit
                                        </span>
                                        @include('nutritionists.modals.memo')
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="memo-container"
                                        style="border: {{ empty($user_profile->nutritionist_memo) ? 'none' : '1px solid #202F55' }};">
                                        {!! nl2br(e($user_profile->nutritionist_memo)) !!}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Radar Chart Placeholder -->

            <div class="card m-2">
                <div class="card-body">
                    @include('nutritionists.charts.radarchartSendAdvice', [
                        'satisfactionRates' => $satisfactionRates,
                        'user' => $user_profile,
                        'message' => $message ?? 'No data available.'
                    ])
                </div>
            </div>


            @foreach ($categoryData as $category => $data)
            <div class="card m-2">
                <div class="card-body">
                    <h5>{{ $category }} Subcategories</h5>
                    <div class="text-center">
                        @if (!empty($data['subCategoryRates']))
                            <canvas id="subcategoryChart_{{ $category }}" width="200" height="200"></canvas>
                        @else
                            <p class="text-danger">{{ $data['message'] ?? 'No data available.' }}</p>
                        @endif
                    </div>
                </div>
            </div>

            @if (!empty($data['subCategoryRates']))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const ctx = document.getElementById('subcategoryChart_{{ $category }}').getContext('2d');
                    const subCategoryRates = @json($data['subCategoryRates']);

                    const labels = Object.keys(subCategoryRates);
                    const values = Object.values(subCategoryRates);
                    const adjustedValues = values.map(v => Math.min(v, 160)); // 150%以上を150でカット

                    new Chart(ctx, {
                        type: 'radar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: '{{ $category }} Subcategories (%)',
                                data: adjustedValues,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                r: {
                                    suggestedMin: 0,
                                    suggestedMax: 160,
                                    ticks: {
                                        stepSize: 20, // 20%刻みに変更
                                        backdropColor: 'rgba(255, 255, 255, 0.8)',
                                        color: 'rgba(0, 0, 0, 0.8)',
                                        font: {
                                            size: 12
                                        }
                                    },
                                    grid: {
                                        color: function (context) {
                                            return context.tick.value === 100 ? 'orange' : 'rgba(0, 0, 0, 0.1)'; // 100%の線をオレンジに
                                        },
                                        lineWidth: function (context) {
                                            return context.tick.value === 100 ? 2 : 1; // 100%の線を太く
                                        }
                                    },
                                    pointLabels: {
                                        font: {
                                            size: 14,
                                            weight: 'bold'
                                        },
                                        color: 'rgba(0, 0, 0, 0.8)'
                                    }
                                }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        beforeBody: function (tooltipItems) {
                                            let originalValue = values[tooltipItems[0].dataIndex];
                                            return originalValue > 160 ? '⚠ Over 160%! Actual: ' + originalValue + '%' : '';
                                        }
                                    }
                                }
                            }
                        }
                    });
                });
            </script>

            @endif
        @endforeach


        </div>

        <div class="custom-right-section" style="overflow-y: auto;">
            <h4 class="text-center p-1">{{ $advice->created_at->format('Y/m/d') }}  Advice</h4>
            <div class="history-right">
                <label for="overall" class="form-label mb-0">Overall Rating</label>
                <div id="overall" class="d-flex justify-content-start gap-4 mt-0">
                    <span
                        class="material-symbols-outlined nutri-material-symbols-outlined @if ($advice->overall == 5) selected @endif"
                        data-value="5">sentiment_excited</span>
                    <span
                        class="material-symbols-outlined nutri-material-symbols-outlined @if ($advice->overall == 4) selected @endif"
                        data-value="4">sentiment_satisfied</span>
                    <span
                        class="material-symbols-outlined nutri-material-symbols-outlined @if ($advice->overall == 3) selected @endif"
                        data-value="3">sentiment_content</span>
                    <span
                        class="material-symbols-outlined nutri-material-symbols-outlined @if ($advice->overall == 2) selected @endif"
                        data-value="2">sentiment_neutral</span>
                    <span
                        class="material-symbols-outlined nutri-material-symbols-outlined @if ($advice->overall == 1) selected @endif"
                        data-value="1">sentiment_sad</span>
                </div>



                <!-- Comment Display -->
                <div class="mb-3">
                    <label for="advice-message" class="form-label">Advice</label>
                    <div id="advice-message" class="custom-textarea">
                       <p>{{ $advice->message }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
