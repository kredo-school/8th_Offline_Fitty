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
                    @method('PATCH')

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
                        <div class="edit-button edit-button-edit mt-2 text-end">
                            <a href="#" class="" data-bs-toggle="modal" data-bs-target="#passwordModal">Change
                                Password</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
                            <input type="password" class="form-control" id="currentPassword" name="current_password"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="newPassword" name="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirm_password"
                                required>
                        </div>
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
