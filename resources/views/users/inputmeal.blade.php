@extends('layouts.app')

@section('title', 'Create Post')

@section('content')

</head>
<body>

<div class="form-container inputmeal">
            <div class="fixed-back-button">
                <button class="btn btn-outline-secondary custom-back-button" onclick="window.history.back()">&larr;</button>
            </div>

    <h2 class="text-center mb-4 text-success">Input meal</h2>
    <form id="mealForm" action="{{route('user.inputmeal.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Date Input -->
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="input_date" class="form-control" id="date" value="">
        </div>

        <!-- Meal Type Dropdown -->
        <div class="mb-3">
            <label for="mealType" class="form-label">Meal Type</label>
            <select class="form-select" id="mealType" name="meal_type">
                <option selected value="Breakfast">Breakfast</option>
                <option value="Lunch">Lunch</option>
                <option value="Dinner">Dinner</option>
                <option value="Other">Other</option>
            </select>
        </div>

       <!-- Comment Textarea -->
       <div class="mb-3">
            <label for="mealContent" class="form-label">Meal</label>
            <textarea class="form-control textarea-border" name="meal_content" id="mealContent" rows="3" placeholder="Write here"></textarea>
        </div>

        <!-- Comment Textarea -->
        <div class="mb-3">
            <label for="comment" class="form-label">Comment</label>
            <textarea class="form-control textarea-border" id="comment" rows="3" placeholder="Write here"></textarea>
        </div>

        <!-- Weight Input -->
        <div class="mb-3">
            <label for="weight" class="form-label">Weight (kg)</label>
            <input type="number" class="form-control" id="weight" name="weight" value="{{ old('weight', $lastWeight) }}" placeholder="Enter your weight" step="0.1">
        </div>

        <!-- Image Upload -->
        <div class="mb-3">
            <label for="mealImage" class="form-label">Upload Image</label>
            <input type="file" class="form-control" id="mealImage" name="image" accept="image/*">
        </div>

        <input type="hidden" name="nutritions" id="nutritions">

        <!-- Submit Button -->
        <button type="submit" type="button" id="submitBtn" class="btn btn-submit w-100">Submit</button>
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


    const mealContent = document.getElementById('mealContent').value;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

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