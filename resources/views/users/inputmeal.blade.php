@extends('layouts.app')

@section('title', 'Create Post')

@section('content')

</head>
<body>

<div class="form-container inputmeal">
    <h2 class="text-center mb-4 text-success">Input meal</h2>
    <form action="{{route('user.inputmeal.store')}}" method="POST" enctype="multipart/form-data">
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
                <option selected>Breakfast</option>
                <option value="1">Lunch</option>
                <option value="2">Dinner</option>
                <option value="3">Other</option>
            </select>
        </div>

       <!-- Comment Textarea -->
       <div class="mb-3">
            <label for="comment" class="form-label">Meal</label>
            <textarea class="form-control textarea-border" name="meal_content" id="comment" rows="3" placeholder="Write here"></textarea>
        </div>

        <!-- Comment Textarea -->
        <div class="mb-3">
            <label for="comment" class="form-label">Comment</label>
            <textarea class="form-control textarea-border" id="comment" rows="3" placeholder="Write here"></textarea>
        </div>

        <!-- Image Upload -->
        <div class="mb-3">
            <label for="mealImage" class="form-label">Upload Image</label>
            <input type="file" class="form-control" id="mealImage" name="image" accept="image/*">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-submit w-100">Submit</button>
    </form>
</div>


@endsection