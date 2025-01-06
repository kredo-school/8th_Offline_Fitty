@extends('layouts.app')

@section('content')
<div class="register-page">

    <div class="container d-flex justify-content-center w-50">
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf
            
        <!-- Section 2: Health Information -->
            <div class="form-section">
                <h2>2. Health Information</h2>
                <div class="form-row">
                    {{-- Date of Birth --}}
                    <div class="form-group mb-2">
                        <label for="dob">Date of Birth (D/M/Y)</label>
                        <input type="date" id="dob" name="dob" class="form-control">
                    </div>
                    {{-- Gender --}}
                    <div class="form-group mb-2">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" class="form-control">
                            <option value="">--Please choose an option--</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="non_binary">Non-binary</option>
                            <option value="prefer_not_to_say">Prefer not to say</option>
                            <option value="prefer_not_to_say">Other</option>
                        </select>
                    </div>

                </div>
                <div class="form-row">
                    {{-- Height --}}
                    <div class="form-group mb-2">
                        <label for="height">Height(cm)</label>
                        <input type="number" id="height" name="height" step="1" min="120" max="220" value="160" class="form-control">
                    </div>
                    {{-- Exercise Frequency --}}
                    <div class="form-group mb-4 mt-4">
                        <label for="exercise_frequency">Exercise Frequency</label>
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
                                    <td><input type="radio" name="exercise_frequency" value="Level_1"></td>
                                </tr>
                                <tr>
                                    <td>Level 2</td>
                                    <td>2-3 times per week</td>
                                    <td>You exercise moderately on a weekly basis. Activities might include jogging, casual sports, or gym sessions. This level is ideal for maintaining general fitness.</td>
                                    <td><input type="radio" name="exercise_frequency" value="Level_2"></td>
                                </tr>
                                <tr>
                                    <td>Level 3</td>
                                    <td>4+ times per week</td>
                                    <td>You are highly active and exercise consistently. This may include structured workout plans, intensive sports, or frequent gym visits. This level reflects a well-established fitness routine.</td>
                                    <td><input type="radio" name="exercise_frequency" value="Level_3"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Current Health Conditions --}}
                    <div class="form-group mb-2">
                    <label for="health_conditions">Current Health Conditions (if any)</label>

                        <div>
                            <label><input type="checkbox" name="health_conditions[]" value="none"> None</label><br>
                            <label><input type="checkbox" name="health_conditions[]" value="pregnant"> Pregnant</label><br>
                            <label><input type="checkbox" name="health_conditions[]" value="breastfeeding"> Breastfeeding</label><br>
                            <label><input type="checkbox" name="health_conditions[]" value="chronic_disease"> Chronic Disease</label><br>
                            <label><input type="checkbox" name="health_conditions[]" value="mental_health"> Mental Health Issues</label><br>
                            <label><input type="checkbox" name="health_conditions[]" value="other"> Other (please specify in comments)</label>
                        </div>
                    </div>
                </div>

        <!-- Section 3: Lifestyle -->
            <div class="form-section">
                <h2>3. Lifestyle</h2>
                {{-- Dietary Preferences --}}
                <div class="form-group mb-4 mt-4">
                    <label for="dietary_preferences">Dietary Preferences</label>
                    <select name="dietary_preferences" id="dietary_preferences" class="form-control">
                        <option value="">--Please choose an option--</option>
                        
                        <!-- No restrictions -->
                        <option value="no_restrictions">No Dietary Restrictions</option>

                        <!-- Health and allergy related -->
                        <option value="lactose_free">Lactose-Free</option>
                        <option value="nut_free">Nut-Free</option>
                        <option value="dairy_free">Dairy-Free</option>
                        <option value="soy_free">Soy-Free</option>
                        <option value="gluten_free">Gluten-Free</option>

                        <!-- Diet and lifestyle -->
                        <option value="vegetarian">Vegetarian</option>
                        <option value="vegan">Vegan</option>
                        <option value="pescatarian">Pescatarian</option>
                        <option value="low_carb">Low Carb</option>
                        <option value="keto">Ketogenic</option>
                        <option value="paleo">Paleo</option>
                        <option value="intermittent_fasting">Intermittent Fasting</option>

                        <!-- Ethical and environmental choices -->
                        <option value="organic">Organic Only</option>
                        <option value="locavore">Locavore</option>
                        <option value="flexitarian">Flexitarian</option>

                        <!-- Other -->
                        <option value="other">Other</option>
                    </select>
                </div>


                {{-- Food Allergies --}}
                <div class="form-group mb-2">
                    <label for="food_allergies">Food Allergies (if any)</label>
                    <textarea id="food_allergies" name="food_allergies" class="form-control"></textarea>
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
                    <textarea id="goals" name="goals" class="form-control" placeholder="Describe your goal here..."></textarea>
                </div>

            </div>

            <button type="submit" class="btn-submit mt-3">
                REGISTER
            </button>
        </form>
    </div>

</div>
@endsection
