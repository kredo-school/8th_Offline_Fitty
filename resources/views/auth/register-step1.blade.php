@extends('layouts.app')

@section('content')
<div class="container register-page d-flex align-items-center justify-content-center bg-light">
    <div class="form-box p-5 shadow-lg rounded bg-white" style="width: 500px; margin-top: 100px;">
        <h3 class="mb-4">1. Basic Information</h3>
        <form method="POST" action="{{ route('register.step1.submit') }}" enctype="multipart/form-data">
            @csrf
            <!-- Profile Image -->
            <div class="mb-3">
                <label for="profile_image" class="form-label">Upload Profile Image</label>
                <input type="file" id="profile_image" name="profile_image" class="form-control">
                @error('profile_image')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- First Name -->
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" class="form-control">
                @error('first_name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Last Name -->
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" class="form-control">
                @error('last_name')
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
            <button type="submit" class="btn btn-primary w-100 mt-3">Next Step</button>
        </form>
    </div>
</div>
@endsection
