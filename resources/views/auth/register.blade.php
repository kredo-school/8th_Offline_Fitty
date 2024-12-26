@extends('layouts.app')

@section('content')
<div style="background-color: #f9f9f0; font-family: Arial, sans-serif; padding: 20px;">

    <div class="container" style="max-width: 800px; margin: 20px auto;">
        <!-- Section 1: Basic Information -->
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf
            <div style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-bottom: 20px;">
                <div style="text-align: center; margin-bottom: 20px;">
                    {{-- Image --}}
                    <div style="margin-top: 10px;">
                        <label for="profile_image" style="font-size: 16px; font-weight: bold;">Upload Image</label>
                        <input type="file" id="profile_image" name="profile_image" style="display: block; margin: 10px auto;">
                    </div>
                </div>

                <h2 style="font-size: 20px; font-weight: bold; margin-bottom: 20px;">1. Basic Information</h2>

                <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                    {{-- First Name --}}
                    <div style="flex: 1; margin-right: 10px;">
                        <label for="first_name" style="font-size: 14px; font-weight: bold;">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="form-control">
                    </div>
                    {{-- Last Name --}}
                    <div style="flex: 1; margin-left: 10px;">
                        <label for="last_name" style="font-size: 14px; font-weight: bold;">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="form-control">
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                    {{-- Email Address --}}
                    <div style="flex: 1; margin-right: 10px;">
                        <label for="email" style="font-size: 14px; font-weight: bold;">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="example@domain.com" class="form-control">
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                    {{-- Password --}}
                    <div style="flex: 1; margin-right: 10px;">
                        <label for="password" style="font-size: 14px; font-weight: bold;">Password</label>
                        <input type="password" id="password" name="password" class="form-control">
                    </div>
                    {{-- Confirm Password --}}
                    <div style="flex: 1; margin-left: 10px;">
                        <label for="password_confirmation" style="font-size: 14px; font-weight: bold;">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" class="form-control">
                    </div>
                </div>
            </div>

            <!-- Section 2: Health Information -->
            <div style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-bottom: 20px;">
                <h2 style="font-size: 20px; font-weight: bold; margin-bottom: 20px;">2. Health Information</h2>

                <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                    {{-- Date of Birth --}}
                    <div style="flex: 1; margin-right: 10px;">
                        <label for="dob" style="font-size: 14px; font-weight: bold;">Date of Birth(D/M/Y)</label>
                        <input type="date" id="dob" name="dob" class="form-control">
                    </div>
                    {{-- Gender --}}
                    <div style="flex: 1; margin-left: 10px;">
                        <label for="gender" style="font-size: 14px; font-weight: bold;">Gender</label>
                        <input type="text" id="gender" name="gender" class="form-control">
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                    {{-- Height --}}
                    <div style="flex: 1; margin-right: 10px;">
                        <label for="height" style="font-size: 14px; font-weight: bold;">Height</label>
                        <input type="number" id="height" name="height" class="form-control">
                    </div>
                    {{-- Exercise Frequency --}}
                    <div style="flex: 1; margin-left: 10px;">
                        <label for="exercise_frequency" style="font-size: 14px; font-weight: bold;">Exercise Frequency</label>
                        <input type="text" id="exercise_frequency" name="exercise_frequency" class="form-control">
                    </div>
                </div>

                {{-- Currenct Health Conditions --}}
                <label for="health_conditions" style="font-size: 14px; font-weight: bold;">Current Health Conditions(if any)</label>
                <textarea id="health_conditions" name="health_conditions" class="form-control"></textarea>
            </div>

            <!-- Section 3: Lifestyle -->
            <div style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-bottom: 20px;">
                <h2 style="font-size: 20px; font-weight: bold; margin-bottom: 20px;">3. Lifestyle</h2>
                {{-- Dietary Preferences --}}
                <label for="dietary_preferences" style="font-size: 14px; font-weight: bold;">Dietary Preferences(e.g., Vegetarian, Vegan)</label>
                <input type="text" id="dietary_preferences" name="dietary_preferences" class="form-control">
                {{-- Food Allergies --}}
                <label for="food_allergies" style="font-size: 14px; font-weight: bold;">Food Allergies(if any)</label>
                <textarea id="food_allergies" name="food_allergies" class="form-control"></textarea>
            </div>

            <!-- Section 4: Goals -->
            <div style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-bottom: 20px;">
                <h2 style="font-size: 20px; font-weight: bold; margin-bottom: 20px;">4. Goals</h2>
                <label for="goals" style="font-size: 14px; font-weight: bold;">What is your primary goal for using this service?</label>
                <textarea id="goals" name="goals" placeholder="e.g., Weight loss, Muscle gain" class="form-control"></textarea>
            </div>

            <button type="submit" style="background-color: #0a8f2c; color: white; padding: 10px 20px; font-size: 16px; font-weight: bold; border: none; border-radius: 5px; cursor: pointer; display: block; margin: 0 auto;">
                REGISTER
            </button>
        </form>
    </div>

</div>
@endsection
