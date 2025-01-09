@extends('layouts.app')
@section('title', 'Send Advice')
@section('content')

<div class="custom-left-section">
    <!-- Back Button -->
    <div class="fixed-back-button">
        <button class="btn btn-outline-secondary custom-back-button" onclick="window.history.back()">&larr;</button>
    </div>

    <!-- User Information -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <!-- アイコン部分 -->
                @if ($user->avatar)
                    <img src="{{ $user->avatar }}" class="user-photo" alt="Avatar">
                @else
                    <span class="material-symbols-outlined user-photo">account_circle</span>
                @endif

                <!-- ユーザー情報部分 -->
                <div class="user-info ms-4">
                    <p><strong>Name:</strong> {{$user->name}}</p>
                    <p><strong>Age:</strong> {{$user->age}}</p>
                    <p><strong>Gender:</strong> {{$user->gender}}</p>
                    <p><strong>Height(cm):</strong> {{$user->height}}</p>
                    <p><strong>Exercise Frequency:</strong> {{$user->activity_level}}</p>
                    <p><strong>Dietary Preferences:</strong> {{$user->dietary_preferences}}</p>
                    <p><strong>Food Allergies:</strong> {{$user->allergies}}</p>
                    <p><strong>Goals:</strong> {{$user->goal}}</p>
                    <p><strong>Memo:</strong> {{$user->memo}}</p>
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

    <!-- Blank Cards -->
    <div class="custom-blank-card"></div>
    <div class="custom-blank-card"></div>
    <div class="custom-blank-card"></div>
</div>

<div class="custom-right-section">
    <h4 class="text-center mb-4">Send Advice</h4>
    <form action="{{route('nutri.store')}}" method="post">
    @csrf

    <!-- Overall Rating -->
    <div class="mb-3">
        <label for="overall" class="form-label">Overall Rating</label>
        <div id="overall" class="d-flex justify-content-start gap-4">
            <span class="material-symbols-outlined @if(old('overall') == 5) selected @endif" data-value="5">sentiment_excited</span>
            <span class="material-symbols-outlined @if(old('overall') == 4) selected @endif" data-value="4">sentiment_satisfied</span>
            <span class="material-symbols-outlined @if(old('overall') == 3) selected @endif" data-value="3">sentiment_content</span>
            <span class="material-symbols-outlined @if(old('overall') == 2) selected @endif" data-value="2">sentiment_neutral</span>
            <span class="material-symbols-outlined @if(old('overall') == 1) selected @endif" data-value="1">sentiment_sad</span>
        </div>
        <input type="hidden" name="overall" id="overall-input" value="{{ old('overall') }}">
        @error('overall')
            <p class="text-danger small">{{ $message }}</p>
        @enderror
    </div>

    <!-- Comment -->
    <div class="mb-3">
        <label for="message" class="form-label">Comment</label>
        <textarea class="form-control" id="message" name="message" rows="20" style="padding: 12px;">{{ old('message') }}</textarea>
        @error('message')
            <p class="text-danger small">{{ $message }}</p>
        @enderror
    </div>

    <!-- User ID -->
    <input type="hidden" name="user_id" value="{{ $user->id }}">

    <!-- Buttons -->
    <div class="d-flex justify-content-between">
        <button type="submit" class="btn send-btn">Send Advice</button>
        <a href="{{route('nutri.history', $user->id)}}" class="btn see-previous-btn">Previous Advice</a>

    </div>
</form>



</div>

<script>
     const overallContainer = document.getElementById('overall');
    const overallInput = document.getElementById('overall-input');

    overallContainer.addEventListener('click', (event) => {
        if (event.target.classList.contains('material-symbols-outlined')) {
            const value = event.target.getAttribute('data-value');
            overallInput.value = value;

            // 選択された状態のスタイルを付与
            Array.from(overallContainer.children).forEach(icon => icon.classList.remove('selected'));
            event.target.classList.add('selected');
        }
    });
</script>


<style>
    /* 選択されたアイコンのスタイル */
    .selected {
        color: #FFA965;
        font-weight: bold;
    }

    .material-symbols-outlined {
        cursor: pointer;
        transition: color 0.2s;
    }

    .material-symbols-outlined:hover {
        color: #4DAF4A;
    }
</style>

@endsection
