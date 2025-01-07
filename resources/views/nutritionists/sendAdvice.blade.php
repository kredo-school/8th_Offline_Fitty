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

    <!-- Blank Card -->
    <div class="custom-blank-card"></div>
    <div class="custom-blank-card"></div>
    <div class="custom-blank-card"></div>

</div>

<div class="custom-right-section">
    <h4 class="text-center mb-4">Send Advice</h4>
    <form>
    <div class="mb-3">
    <label for="rating" class="form-label">Overall Rating</label>
    <div id="rating" class="d-flex justify-content-start gap-4"> <!-- 左寄せ、アイコン間に余白を設定 -->
        <!-- 使用するアイコン -->
        <span class="material-symbols-outlined">sentiment_excited</span>
        <span class="material-symbols-outlined">sentiment_satisfied</span>
        <span class="material-symbols-outlined">sentiment_content</span>
        <span class="material-symbols-outlined">sentiment_neutral</span>
        <span class="material-symbols-outlined">sentiment_sad</span>
    </div>
</div>

        <div class="mb-3">
            <label for="comment" class="form-label">Comment</label>
            <textarea class="form-control" id="comment" rows="20" style="padding: 12px;"></textarea>
        </div>
        <div class="d-flex justify-content-between">
        <button type="button" class="btn see-previous-btn">See Previous Advice</button>
        <button type="submit" class="btn send-btn">Send</button>
        </div>
    </form>
</div>

@endsection

