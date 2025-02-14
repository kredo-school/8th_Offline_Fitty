@extends('layouts.app')

@section('title', 'show advice')

@section('content')

    <style>
        #app {
            min-height: auto !important;
        }

        @media (max-width: 768px) { /* スマホ画面 */
            .combined-section {
                display: flex;
                flex-direction: column; /* 縦方向に並べる */
            }

            .combined-section > div {
                margin-bottom: 20px; /* 要素間の間隔 */
            }

            .chart-container { /* チャートのサイズ調整 */
                max-width: 100%; /* 親要素に合わせて最大幅を設定 */
                overflow-x: auto; /* 横スクロールが必要な場合に表示 */
            }

            .custom-right-section{
                width: 95%;

            }
        }

        @media (min-width: 769px) { /* PC・タブレット画面 */
            .combined-section {
                display: flex;
                flex-direction: row; /* 横方向に並べる */
                align-items: flex-start; /* 上に揃える */
            }

            .combined-section > div {
                width: 50%; /* 各要素の幅を50%にする */
                margin-right: 20px; /* 要素間の間隔 */
            }

            .combined-section > div:last-child {
                margin-right: 0; /* 右側のマージンをなくす */
            }
        }

    </style>

@include('sidebar.humburger')
    <div class="container">


        <div class="row">
            @include('sidebar.include-sidebar')

            <div class="col-md-9 ms-sm-auto col-lg-10">
                <div class="combined-section">
                {{-- Right Section start--}}
                 <div class="custom-right-section">
                    <h4 class="text-center p-1">Advice</h4>
                        <!-- Overall Rating -->
                        <div class="mb-3">
                            <label class="form-label ">Overall Rating</label>
                            <div id="overall" class="d-flex justify-content-start gap-4 mt-0">
                                <span
                                    class="material-symbols-outlined nutri-material-symbols-outlined @if ($advice->overall == 5) selected @endif"
                                    data-value="5" style="font-size: 50px !important;">sentiment_excited</span>
                                <span
                                    class="material-symbols-outlined nutri-material-symbols-outlined @if ($advice->overall == 4) selected @endif"
                                    data-value="4" style="font-size: 50px !important;">sentiment_satisfied</span>
                                <span
                                    class="material-symbols-outlined nutri-material-symbols-outlined @if ($advice->overall == 3) selected @endif"
                                    data-value="3" style="font-size: 50px !important;">sentiment_content</span>
                                <span
                                    class="material-symbols-outlined nutri-material-symbols-outlined @if ($advice->overall == 2) selected @endif"
                                    data-value="2" style="font-size: 50px !important;">sentiment_neutral</span>
                                <span
                                    class="material-symbols-outlined nutri-material-symbols-outlined @if ($advice->overall == 1) selected @endif"
                                    data-value="1" style="font-size: 50px !important;">sentiment_sad</span>
                            </div>
                            {{-- <p class="border p-2">{{ $advice->overall ?? 'No rating available' }}</p> --}}

                            {{-- <div id="overall" class="d-flex justify-content-start gap-4" >
                                <input type="hidden" name="overall" id="overall-input" value="{{ $advice->overall }}">
                            </div> --}}
                            @error('overall')
                                <p class="text-danger small">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Comment --}}
                        <div class="mb-3">
                            <label for="message" class="form-label">Comment</label>
                            <textarea class="form-control" id="message" name="message" rows="10" style="padding: 12px;">{{ old('message', $advice->message) }}</textarea>
                            @error('message')
                                <p class="text-danger small">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Back Button --}}
                        <a href="{{ route('user.advice.index', ['id' => $user_profile->user_id]) }}" class="btn btn-secondary">
                            ← Back to Advice List
                        </a>

                        <!-- User ID -->
                        <input type="hidden" name="user_id" value="{{ $user_profile->user_id }}">
                </div>
                {{-- Right Section end --}}

                {{-- Left Section start--}}
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

                <!-- Radar Chart Placeholder -->
                <div class="card m-2">
                    <div class="card-body">
                        @include('nutritionists.charts.lineGraph', [
                            'dates' => $weightData['dates'],
                            'weights' => $weightData['weights'],
                            'message' => $weightData['message']
                        ])
                    </div>
                </div>


                {{-- Left Section end --}}

            </div>
            </div>
        </div>
    </div>
@endsection
