@extends('layouts.app')

@section('title', 'show advice')

@section('content')
    <div class="container">
        <div class="custom-right-section">
            <h4 class="text-center p-4">Send Advice</h4>
            <form action="#" method="post" class="w-75">
                @csrf

                <!-- Overall Rating -->
                <div class="">
                    <label for="overall" class="form-label">Overall Rating</label>
                    <div id="overall" class="d-flex justify-content-start gap-4">
                        <span
                            class="material-symbols-outlined nutri-material-symbols-outlined @if (old('overall') == 5) selected @endif"
                            data-value="5">sentiment_excited</span>
                    </div>
                    <input type="hidden" name="overall" id="overall-input" value="{{ old('overall') }}">
                    @error('overall')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Comment -->
                <div class="mb-3">
                    <h1 class="">asdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjklasdfghjkl</h1>
                </div>

                <!-- User ID -->
                <input type="hidden" name="user_id" value="{{ $user->id }}">

                <!-- Buttons -->
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn send-btn">Send Advice</button>
                    <a href="#" class="btn see-previous-btn">Previous Advice</a>

                </div>
            </form>

        </div>
    </div>
@endsection