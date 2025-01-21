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
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Radar Chart</h5>
                    <div class="text-center">
                        <img src="https://via.placeholder.com/300x200" alt="Radar Chart" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <div class="custom-right-section">
            <h4 class="text-center p-1">Send Advice</h4>
            <form action="{{ route('nutri.store') }}" method="post" id="advice-form">
                @csrf
                <div class="">
                    <label for="overall" class="form-label mb-0">Overall Rating</label>
                    <div id="overall" class="d-flex justify-content-start gap-4 mt-0">
                        <span
                            class="material-symbols-outlined nutri-material-symbols-outlined @if (old('overall') == 5) selected @endif"
                            data-value="5">sentiment_excited</span>
                        <span
                            class="material-symbols-outlined nutri-material-symbols-outlined @if (old('overall') == 4) selected @endif"
                            data-value="4">sentiment_satisfied</span>
                        <span
                            class="material-symbols-outlined nutri-material-symbols-outlined @if (old('overall') == 3) selected @endif"
                            data-value="3">sentiment_content</span>
                        <span
                            class="material-symbols-outlined nutri-material-symbols-outlined @if (old('overall') == 2) selected @endif"
                            data-value="2">sentiment_neutral</span>
                        <span
                            class="material-symbols-outlined nutri-material-symbols-outlined @if (old('overall') == 1) selected @endif"
                            data-value="1">sentiment_sad</span>
                    </div>
                    <input type="hidden" name="overall" id="overall-input" value="{{ old('overall') }}">
                    @error('overall')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Comment -->
                <div class="mb-3">
                    <label for="message" class="form-label">Comment</label>
                    <textarea class="form-control" id="message" name="message" rows="20">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>

                <!-- User ID -->
                <input type="hidden" name="user_id" value="{{ $user_profile->id }}">

                <!-- Buttons -->
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn send-btn">Send Advice</button>
                    <a href="{{ route('nutri.history', $user_profile->id) }}" class="btn see-previous-btn">Previous Advice</a>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/memo.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const overallContainer = document.getElementById('overall');
            const overallInput = document.getElementById('overall-input');

            if (overallContainer && overallInput) {
                overallContainer.addEventListener('click', (event) => {
                    if (event.target.classList.contains('material-symbols-outlined')) {
                        const value = event.target.getAttribute('data-value');
                        overallInput.value = value;

                        Array.from(overallContainer.children).forEach(icon => icon.classList.remove('selected'));
                        event.target.classList.add('selected');
                    }
                });
            }
        });
    </script>

    <style>
        .selected {
            color: #FFA965;
            font-weight: bold;
        }

        .nutri-material-symbols-outlined {
            cursor: pointer;
            transition: color 0.2s;
        }

        .nutri-material-symbols-outlined:hover {
            color: #4DAF4A;
        }
    </style>
@endsection
