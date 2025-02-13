
@extends('layouts.app')

@section('content')
<div class="container regist
er-page d-flex flex-column align-items-center justify-content-center" style="gap: 40px;">

    <div class="form-box p-5 shadow-lg rounded bg-white" style="width: 500px; ">
        <h3 class="mb-4">1. Basic Information</h3>
        <form method="POST" action="{{ route('register.step1.submit') }}" enctype="multipart/form-data">
            @csrf
            <!-- Avatar -->
            <div class="mb-3">
                <label for="avatar" class="form-label">Upload Avatar(Your picture)</label>
                <input type="file" id="avatar" name="avatar" class="form-control">
                @error('avatar')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- User Name -->
            <div class="mb-3">
                <label for="name" class="form-label">User Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control">
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control">
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control">
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                @error('password_confirmation')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn  w-100 mt-3" style="background-color: #28a745; color:#FFF;">Next Step</button>
        </form>
    </div>
</div>
@endsection
