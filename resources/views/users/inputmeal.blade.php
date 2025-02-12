@extends('layouts.app')

@section('title', 'Create Post')

@section('content')

<div class="form-container inputmeal">
    <div class="fixed-back-button">
        <button class="btn btn-outline-secondary custom-back-button" onclick="window.history.back()">&larr;</button>
    </div>

    <h2 class="text-center mb-4 text-success">Input meal</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="mealForm" action="{{ route('user.inputmeal.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Date Input -->
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="input_date" class="form-control @error('input_date')  @enderror" id="date" value="{{ old('input_date') }}">
            @error('input_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Meal Type Dropdown -->
        <div class="mb-3">
            <label for="mealType" class="form-label">Meal Type</label>
            <select class="form-select @error('meal_type') is-invalid @enderror" id="mealType" name="meal_type">
                <option value="Breakfast" {{ old('meal_type') == 'Breakfast' ? 'selected' : '' }}>Breakfast</option>
                <option value="Lunch" {{ old('meal_type') == 'Lunch' ? 'selected' : '' }}>Lunch</option>
                <option value="Dinner" {{ old('meal_type') == 'Dinner' ? 'selected' : '' }}>Dinner</option>
                <option value="Other" {{ old('meal_type') == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('meal_type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Meal Content -->
        <div class="mb-3">
            <label for="mealContent" class="form-label">Meal</label>
            <textarea class="form-control textarea-border @error('meal_content') is-invalid @enderror" name="meal_content" id="mealContent" rows="3" placeholder="Write here">{{ old('meal_content') }}</textarea>
            @error('meal_content')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Comment -->
        <div class="mb-3">
            <label for="comment" class="form-label">Comment</label>
            <textarea class="form-control textarea-border @error('comment') is-invalid @enderror" name="comment" id="comment" rows="3" placeholder="Write here">{{ old('comment') }}</textarea>
            @error('comment')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Weight Input -->
        <div class="mb-3">
            <label for="weight" class="form-label">Weight (kg)</label>
            <input type="number" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight" value="{{ old('weight', $lastWeight) }}" placeholder="Enter your weight" step="0.1">
            @error('weight')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Image Upload -->
        <div class="mb-3">
            <label for="mealImage" class="form-label">Upload Image</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="mealImage" name="image" accept="image/*">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <input type="hidden" name="nutritions" id="nutritions">

        <!-- Submit Button -->
        <button type="submit" id="submitBtn" class="btn btn-submit w-100">Submit</button>
    </form>

    <!-- メッセージ表示用の要素 -->
    <div id="loadingMessage" style="display: none; font-size: 1.2em; color: #555;">
        Calculating and sending data...
    </div>

</div>

<script>
    document.getElementById('submitBtn').addEventListener('click', async function (event) {

    event.preventDefault(); // フォームのデフォルト送信動作を防止
    // メッセージを表示
    const loadingMessage = document.getElementById('loadingMessage');
    loadingMessage.style.display = 'block';

    // ボタンを無効化
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;

    const input_date = document.getElementById('date').value;
    const mealContent = document.getElementById('mealContent').value;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;


    if (!input_date.trim()) {
        alert('Please enter the date.');
        loadingMessage.style.display = 'none'; // メッセージを非表示
        submitBtn.disabled = false; // ボタンを有効化

        return;
    }

    if (!mealContent.trim()) {
        alert('Please enter the meal content.');
        loadingMessage.style.display = 'none'; // メッセージを非表示
        submitBtn.disabled = false; // ボタンを有効化

        return;
    }

    if (!csrfToken) {
        alert('CSRF token not found.');
        return;
    }

    try {
        const response = await fetch('/api/chatgpt', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({ meal_content: mealContent }),
        });

        const text = await response.text(); // テキストとしてレスポンスを取得
        console.log('Raw Response:', text);

        if (!response.ok) {
            alert('Failed to retrieve nutrition data. Status: ' + response.status);
            return;
        }

        let data;
        try {
            data = JSON.parse(text); // JSONとして解析
            console.log('Parsed Data:', data);
        } catch (err) {
            console.error('Error parsing JSON:', err);
            alert('Invalid response format.');
            return;
        }

        // JSONデータをhiddenフィールドに設定
        document.getElementById('nutritions').value = JSON.stringify(data);

        // フォームを送信
        document.getElementById('mealForm').submit();
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while fetching nutrition data.');
        return;
    } finally {
        // メッセージを非表示
        loadingMessage.style.display = 'none';

        // ボタンを有効化
        submitBtn.disabled = false;
    }
});


</script>
@endsection