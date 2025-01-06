
@extends('layouts.app')

@section('content')
<div class="register-page">

    <div class="container  d-flex justify-content-center">
        <!-- Section 1: Basic Information -->
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-section">
                <div class="image-upload">
                    {{-- Image --}}
                    <div>
                        <label for="profile_image">Upload Image</label>
                        <input type="file" id="profile_image" name="profile_image">
                    </div>
                </div>

                <h2>1. Basic Information</h2>

                <div class="form-row ">
                    {{-- First Name --}}
                    <div class="form-group mb-2">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="form-control">
                    </div>
                    {{-- Last Name --}}
                    <div class="form-group mb-2">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    {{-- Email Address --}}
                    <div class="form-group mb-2">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="example@domain.com" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    {{-- Password --}}
                    <div class="form-group mb-2">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control">
                    </div>
                    {{-- Confirm Password --}}
                    <div class="form-group mb-2">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                    </div>
                    <button type="submit" class="btn-submit mt-3">
                        Next Step
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

