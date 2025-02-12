@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

@include('sidebar.humburger')

<div class="row row-main">
    @include('sidebar.include-sidebar')

    <div class="col-md-9 ms-sm-auto col-lg-10">
        <!-- 中央寄せと高さ調整 -->
        <div class="d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 190px);">        <!-- main content -->
            <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="profile-card profile-card-edit">

                    <div class="profile-header profile-header-edit text-center">
                        <!-- Avatar -->
                        <div class="avatar-wrapper">
                            @if ($user->avatar)
                                <img src="{{ $user->avatar }}" alt="Profile Picture"
                                    class="profile-picture rounded-circle mb-3"
                                    style="width: 120px; height: 120px; object-fit: cover;">
                            @else
                                <img src="{{ asset('images/default-avatar.png') }}" alt="Default Profile Picture"
                                    class="profile-picture rounded-circle mb-3"
                                    style="width: 120px; height: 120px; object-fit: cover;">
                            @endif
                            <input type="file" name="avatar" id="avatar" class="mt-2"
                                style="max-width: 300px; margin: 0 auto;">
                                @error('avatar')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Name -->
                        <div class="form-group mt-4">
                            <label for="name" class="form-label fw-bold">User Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                            class="form-control text-center" style="max-width: 300px; margin: 0 auto;"
                            placeholder="Enter your name">
                            @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                        </div>

                        <!-- Email -->
                        <div class="form-group mt-4">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                            class="form-control text-center" style="max-width: 300px; margin: 0 auto;"
                            placeholder="Enter your email">
                            @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                        </div>
                    </div>

                    <div class="details details-edit">
                        <div class="row">
                            {{-- First Name --}}
                            <div class="detail-item detail-item-edit col-6">
                                <span class="detail-label detail-label-edit">First Name</span>
                                <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->profile->first_name) }}"
                                    class="form-control">
                                    @error('first_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Last Name --}}
                            <div class="detail-item detail-item-edit col-6">
                                <span class="detail-label detail-label-edit">Last Name</span>
                                <input type="text" name="last_name" id="last_name" value="{{ old('last_name',$user->profile->last_name) }}"
                                    class="form-control">
                                    @error('last_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            {{-- Gender --}}
                            <div class="detail-item detail-item-edit col-6">
                                <span class="detail-label detail-label-edit">Gender</span>
                                <select name="gender" class="form-select form-select-edit">
                                    <option value="male" {{ old('gender', $user->profile->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $user->profile->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="non-binary" {{ old('gender', $user->profile->gender) == 'non-binary' ? 'selected' : '' }}>Non-binary</option>
                                    <option value="prefer_not_to_say" {{ old('gender', $user->profile->gender) == 'prefer_not_to_say' ? 'selected' : '' }}>Prefer-not-to-say</option>
                                    <option value="other" {{ old('gender', $user->profile->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            </div>

                            {{-- Birthday --}}
                            <div class="detail-item detail-item-edit col-6">
                                <span class="detail-label detail-label-edit">Birthday</span>
                                <input type="date" name="birthday" value="{{ old('birthday', $user->profile->birthday) }}"
                                class="detail-input detail-input-edit">
                                @error('birthday')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            </div>
                        </div>

                        <div class="row">
                            {{-- Height --}}
                            <div class="detail-item detail-item-edit col-6">
                                <span class="detail-label detail-label-edit">Height(cm)</span>
                                <input type="number" name="height" value="{{ old('height',$user->profile->height) }}"
                                    class="detail-input detail-input-edit">
                                    @error('height')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Activity Level --}}
                            <div class="detail-item detail-item-edit col-6">
                                <span class="detail-label detail-label-edit">Activity Level</span>
                                <select name="activity_level" class="form-select form-select-edit">
                                    <option value="1" title="Low activity" {{ $user->profile->activity_level == 1 ? 'selected' : '' }}>1 - Low Activity</option>
                                    <option value="2" title="Moderate activity" {{ $user->profile->activity_level == 2 ? 'selected' : '' }}>2 - Moderate Activity</option>
                                    <option value="3" title="High activity" {{ $user->profile->activity_level == 3 ? 'selected' : '' }}>3 - High Activity</option>
                                </select>
                                @error('activity_level')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            </div>
                        </div>

                        <div class="row">
                            {{-- Health Conditions --}}
                            <div class="detail-item detail-item-edit col-6">
                                <span class="detail-label detail-label-edit">Health Conditions</span>
                                @php
                                    $healthConditions = json_decode($user->profile->health_conditions ?? '[]', true);
                                    $healthOptions = [
                                        'none' => 'None',
                                        'pregnant' => 'Pregnant',
                                        'breastfeeding' => 'Breastfeeding',
                                        'chronic_disease' => 'Chronic Disease',
                                        'mental_health' => 'Mental Health Issues',
                                        'other' => 'Other (please specify in comments)'
                                    ];
                                @endphp
                                <div>
                                    @foreach ($healthOptions as $key => $label)
                                        <div class="form-check mb-2">
                                            <input type="checkbox" name="health_conditions[]" id="health_condition_{{ $key }}" value="{{ $key }}"
                                                class="form-check-input" {{ is_array($healthConditions) && in_array($key, $healthConditions) ? 'checked' : '' }}>
                                            <label for="health_condition_{{ $key }}" class="form-check-label">{{ $label }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Dietary Preferences --}}
                            <div class="detail-item detail-item-edit col-6">
                                <span class="detail-label detail-label-edit">Dietary Preferences</span>
                                @php
                                    $dietaryPreferences = json_decode($user->profile->dietary_preferences ?? '[]', true);
                                    $dietaryOptions = [
                                        'no_restrictions' => 'No Dietary Restrictions',
                                        'lactose_free' => 'Lactose-Free',
                                        'nut_free' => 'Nut-Free',
                                        'dairy_free' => 'Dairy-Free',
                                        'soy_free' => 'Soy-Free',
                                        'gluten_free' => 'Gluten-Free',
                                        'vegetarian' => 'Vegetarian',
                                        'vegan' => 'Vegan',
                                        'pescatarian' => 'Pescatarian',
                                        'low_carb' => 'Low Carb',
                                        'keto' => 'Ketogenic',
                                        'paleo' => 'Paleo',
                                        'intermittent_fasting' => 'Intermittent Fasting',
                                        'organic' => 'Organic Only',
                                        'locavore' => 'Locavore',
                                        'flexitarian' => 'Flexitarian',
                                        'other' => 'Other'
                                    ];
                                @endphp
                                <div id="dietary_preferences">
                                    @foreach ($dietaryOptions as $key => $label)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="dietary_preference_{{ $key }}" name="dietary_preferences[]"
                                                value="{{ $key }}" {{ is_array($dietaryPreferences) && in_array($key, $dietaryPreferences) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="dietary_preference_{{ $key }}">{{ $label }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Food Allergies --}}
                            <div class="detail-item detail-item-edit col-6">
                                <span class="detail-label detail-label-edit">Food Allergies</span>
                                <input type="text" name="food_allergies" id="food_allergies" value="{{ old('food_allergies',$user->profile->food_allergies) }}"
                                    class="form-control">
                            </div>

                            {{-- Goals --}}
                            <div class="detail-item detail-item-edit col-6">
                                <span class="detail-label detail-label-edit">Goals</span>
                                <input type="text" name="goals" id="goals" value="{{ old('goals',$user->profile->goals) }}"
                                    class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="edit-button edit-button-edit">
                        <button type="submit" class="save-button save-button-edit">Save Changes</button>
                    </div>

                    <div class="edit-button edit-button-edit mt-2 text-end">
                        <a href="#" class="" data-bs-toggle="modal" data-bs-target="#passwordModal">Change Password</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-success" id="passwordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.change_password', $user->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="currentPassword" name="current_password" required>
                        @error('current_password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="newPassword" name="new_password" required>
                        @error('new_password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="new_password_confirmation" required>
                        @error('new_password_confirmation')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    </div>
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

@if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var passwordModal = new bootstrap.Modal(document.getElementById('passwordModal'));
            passwordModal.show();
        });
    </script>
@endif

@endsection
