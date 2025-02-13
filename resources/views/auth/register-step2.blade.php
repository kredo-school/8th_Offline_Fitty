@extends('layouts.app')

@section('content')
<div class="register-page mt-5" >

    <div class="container d-flex justify-content-center w-50">
        <form method="POST" action="{{ route('register.step2.submit') }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        @if(session('step1.profile_image_path'))
    <div class="mb-4">
        <p>Uploaded Profile Image:</p>
        <img src="{{ asset('storage/' . session('step1.profile_image_path')) }}" alt="Profile Image" style="max-width: 150px; max-height: 150px;">
    </div>
@endif


        <!-- Section 2: Health Information -->
        <div class="form-section">
            <div class="form-row ">
                <h2>1. Basic Information</h2>
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


        <!-- Section 2: Health Information -->
            <div class="form-section">
                <div class="form-row ">
                    <h2>2. Health Information</h2>
                    {{-- Date of Birth --}}
                    <div class="form-group mb-2">
                        <label for="dob">Date of Birth (D/M/Y)</label>
                        <input type="date" id="dob" name="dob" class="form-control" value="{{ old('dob') }}">
                        @error('dob')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Gender --}}
                    <div class="form-group mb-2">
                        <label for="gender">Sex</label>
                        <select id="gender" name="gender" class="form-control">
                            <option value="" {{ old('gender') == '' ? 'selected' : '' }}>--Please choose an option--</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('gender')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

                </div>
                <div class="form-row">
                    {{-- Height --}}
                    <div class="form-group mb-2">
                        <label for="height">Height(cm)</label>
                        <input type="number" id="height" name="height" step="1" min="120" max="220" class="form-control" value="{{ old('height', 160) }}">
                        @error('height')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    {{-- Exercise Frequency --}}
                    <div class="form-group mb-4 mt-4">
                        <label for="activity_level">Exercise Frequency</label>
                        <p class="text-muted">Select your level based on the description:</p>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Level</th>
                                    <th>Frequency</th>
                                    <th>Details</th>
                                    <th>Choose</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Level 1</td>
                                    <td>Less than once per week</td>
                                    <td>You rarely engage in physical activities. Examples include occasional walks or light stretching. This level is suitable if you're just starting or have a sedentary lifestyle.</td>
                                    <td>
                                        <input type="radio" name="activity_level" value="Level_1"{{ old('activity_level') == 'Level_1' ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Level 2</td>
                                    <td>2-3 times per week</td>
                                    <td>You exercise moderately on a weekly basis. Activities might include jogging, casual sports, or gym sessions. This level is ideal for maintaining general fitness.</td>
                                    <td>
                                        <input type="radio" name="activity_level" value="Level_2"{{ old('activity_level') == 'Level_2' ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Level 3</td>
                                    <td>4+ times per week</td>
                                    <td>You are highly active and exercise consistently. This may include structured workout plans, intensive sports, or frequent gym visits. This level reflects a well-established fitness routine.</td>
                                    <td>
                                        <input type="radio" name="activity_level" value="Level_3"{{ old('activity_level') == 'Level_3' ? 'checked' : '' }}>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @error('activity_level')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Current Health Conditions --}}
                    <div class="form-group mb-2">
                    <label for="health_conditions">Current Health Conditions (if any)</label>

                        <div>
                            <label><input type="checkbox" name="health_conditions[]" value="none" {{ in_array('none', old('health_conditions', [])) ? 'checked' : '' }}> None
                            </label><br>
                            <label><input type="checkbox" name="health_conditions[]" value="pregnant" {{ in_array('pregnant', old('health_conditions', [])) ? 'checked' : '' }}> Pregnant</label><br>
                            <label><input type="checkbox" name="health_conditions[]" value="breastfeeding" {{ in_array('breastfeeding', old('health_conditions', [])) ? 'checked' : '' }}> Breastfeeding</label><br>
                            <label><input type="checkbox" name="health_conditions[]" value="chronic_disease" {{ in_array('chronic_disease', old('health_conditions', [])) ? 'checked' : '' }}> Chronic Disease</label><br>
                            <label><input type="checkbox" name="health_conditions[]" value="mental_health" {{ in_array('mental_health', old('health_conditions', [])) ? 'checked' : '' }}> Mental Health Issues</label><br>
                            <label><input type="checkbox" name="health_conditions[]" value="other" {{ in_array('other', old('health_conditions', [])) ? 'checked' : '' }}> Other </label>
                        </div>
                    </div>
                </div>

        <!-- Section 3: Lifestyle -->
            <div class="form-section">
                <h2>3. Lifestyle</h2>
                {{-- Dietary Preferences --}}
                <div class="form-group mb-4 mt-4">
                    <label for="dietary_preferences">Dietary Preferences</label>
                    <div id="dietary_preferences" class="" style="height: auto;">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="no_restrictions" name="dietary_preferences[]" value="no_restrictions" {{ in_array('no_restrictions', old('dietary_preferences', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="no_restrictions">No Dietary Restrictions</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="lactose_free" name="dietary_preferences[]" value="lactose_free" {{ in_array('lactose_free', old('dietary_preferences', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="lactose_free">Lactose-Free</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="nut_free" name="dietary_preferences[]" value="nut_free" {{ in_array('nut_free', old('dietary_preferences', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="nut_free">Nut-Free</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="dairy_free" name="dietary_preferences[]" value="dairy_free" {{ in_array('dairy_free', old('dietary_preferences', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="dairy_free">Dairy-Free</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="soy_free" name="dietary_preferences[]" value="soy_free" {{ in_array('soy_free', old('dietary_preferences', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="soy_free">Soy-Free</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gluten_free" name="dietary_preferences[]" value="gluten_free" {{ in_array('gluten_free', old('dietary_preferences', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="gluten_free">Gluten-Free</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="vegetarian" name="dietary_preferences[]" value="vegetarian" {{ in_array('vegetarian', old('dietary_preferences', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="vegetarian">Vegetarian</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="vegan" name="dietary_preferences[]" value="vegan" {{ in_array('vegan', old('dietary_preferences', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="vegan">Vegan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="pescatarian" name="dietary_preferences[]" value="pescatarian" {{ in_array('pescatarian', old('dietary_preferences', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pescatarian">Pescatarian</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="low_carb" name="dietary_preferences[]" value="low_carb" {{ in_array('low_carb', old('dietary_preferences', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="low_carb">Low Carb</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="keto" name="dietary_preferences[]" value="keto" {{ in_array('keto', old('dietary_preferences', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="keto">Ketogenic</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="paleo" name="dietary_preferences[]" value="paleo" {{ in_array('paleo', old('dietary_preferences', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="paleo">Paleo</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="intermittent_fasting" name="dietary_preferences[]" value="intermittent_fasting" {{ in_array('intermittent_fasting', old('dietary_preferences', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="intermittent_fasting">Intermittent Fasting</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="organic" name="dietary_preferences[]" value="organic" {{ in_array('organic', old('dietary_preferences', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="organic">Organic Only</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="locavore" name="dietary_preferences[]" value="locavore" {{ in_array('locavore', old('dietary_preferences', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="locavore">Locavore</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="flexitarian" name="dietary_preferences[]" value="flexitarian" {{ in_array('flexitarian', old('dietary_preferences', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexitarian">Flexitarian</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="other" name="dietary_preferences[]" value="other" {{ in_array('other', old('dietary_preferences', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="other">Other</label>
                        </div>
                    </div>
                </div>


                {{-- Food Allergies --}}
                <div class="form-group mb-2">
                    <label for="food_allergies">Food Allergies (if any)</label>
                    <textarea id="food_allergies" name="food_allergies" class="form-control">{{ old('food_allergies') }}</textarea>
                </div>
            </div>

        <!-- Section 4: Goals -->
            <div class="form-section">
                <h2>4. Goals</h2>
                {{-- Goals --}}
                <div class="form-group mb-2">
                    <label for="goals">
                        What is your primary goal for using this service?
                        <br>
                        <small class="text-muted">
                            (e.g., Maintain health, manage weight, improve nutrition, enhance athletic performance, or prepare for a specific event)
                        </small>
                    </label>
                    <textarea id="goals" name="goals" class="form-control" placeholder="Describe your goal here...">{{ old('goals') }}</textarea>
                </div>

            </div>

            <button type="submit" class="btn-submit my-5">
                REGISTER
            </button>
        </form>
    </div>

</div>
@endsection
