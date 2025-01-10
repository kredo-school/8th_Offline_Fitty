@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

    @include('sidebar.humburger')
    <div class="container user-dailylog">
        <div class="row">
            @include('sidebar.user-sidebar')
            <div class="col-md-9 ms-sm-auto col-lg-10 mt-4">
                <!-- main content -->
                <form action="{{ route('user.update', $user->id) }}" method="POST">
                    @csrf
                    <div class="profile-card profile-card-edit">
                        <div class="profile-header profile-header-edit">
                            {{-- 後ほど画像 --}}
                            <img src="{{ $user->avatar }}" alt="https://via.placeholder.com/120"
                                class="profile-picture profile-picture-edit">
                            <div class="info info-edit">

                                <input type="text" name="name" value="{{ $user->name }}"
                                    class="form-control form-control-edit">
                                <input type="email" name="email" value="{{ $user->email }}"
                                    class="form-control form-control-edit">
                            </div>
                        </div>


                        <div class="details details-edit">
                            <div class="row">
                                <div class="detail-item detail-item-edit col-6">
                                    <span class="detail-label detail-label-edit">Gender</span>
                                    <select name="gender" class="form-select form-select-edit">
                                        <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Female
                                        </option>

                                    </select>

                                </div>
                                <div class="detail-item detail-item-edit col-6">
                                    <span class="detail-label detail-label-edit">Birthday</span>
                                    <input type="date" name="birthday" value="{{ $user->birthday }}"
                                        class="detail-input detail-input-edit">
                                </div>
                            </div>

                            <div class="row">
                                <div class="detail-item detail-item-edit col-6">
                                    <span class="detail-label detail-label-edit">Height(cm)</span>
                                    <input type="number" name="height" value="{{ $user->height }}"
                                        class="detail-input detail-input-edit">
                                </div>
                                <div class="detail-item detail-item-edit col-6">
                                    <span class="detail-label detail-label-edit">Activity Level</span>
                                    <select name="activity_level" class="form-select form-select-edit">
                                        <option value="1" {{ $user->activity_level == 1 ? 'selected' : '' }}>1 - Low
                                            Activity</option>
                                        <option value="2" {{ $user->activity_level == 2 ? 'selected' : '' }}>2 -
                                            Moderate
                                            Activity</option>
                                        <option value="3" {{ $user->activity_level == 3 ? 'selected' : '' }}>3 - High
                                            Activity</option>
                                    </select>

                                </div>
                            </div>

                        </div>
                        <div class="edit-button edit-button-edit">
                            <button type="submit" class="save-button save-button-edit">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
