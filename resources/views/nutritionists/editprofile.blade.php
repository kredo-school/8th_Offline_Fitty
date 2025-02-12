@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

    @include('sidebar.humburger')

        <div class="row">
            @include('sidebar.nutri-sidebar')
            <div class="col-md-9 ms-sm-auto col-lg-10 d-flex justify-content-center align-items-center" style="height: calc(100vh - 190px);">
                <!-- main content -->

                <body>
                    <form action="{{ route('nutri.updateProfile', $user->id) }}" method="POST" enctype="multipart/form-data" style="width: 60%;">
                        @csrf
                        @method('PATCH')

                        <div class="profile-card profile-card-edit" style="width: 100%;">
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
                                    <input type="file" name="avatar" id="avatar" class=" mt-2"
                                        style="max-width: 300px; margin: 0 auto;">
                                </div>

                                <!-- Name -->
                                <div class="form-group mt-4">
                                    <label for="name" class="form-label fw-bold">User Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name',$user->name) }}"
                                        class="form-control text-center" style="max-width: 300px; margin: 0 auto;"
                                        placeholder="Enter your name">
                                </div>

                                <!-- Email -->
                                <div class="form-group mt-4">
                                    <label for="email" class="form-label fw-bold">Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email',$user->email) }}"
                                        class="form-control text-center" style="max-width: 300px; margin: 0 auto;"
                                        placeholder="Enter your email">
                                </div>
                            </div>
                            <div class="details details-edit">
                                <div class="detail-item detail-item-edit">

                                    <div class="row">
                                        <div class="col-6">
                                            <span class="detail-label detail-label-edit">First Name</span>

                                            <input type="text" name="first_name"
                                                value="{{ old('first_name',$user->nutritionistsProfile->first_name) }}"
                                                class="detail-input detail-input-edit">
                                        </div>

                                        <div class="col-6">
                                            <span class="detail-label detail-label-edit">Last Name</span>

                                            <input type="text" name="last_name"
                                                value="{{ old('last_name',$user->nutritionistsProfile->last_name) }}"
                                                class="detail-input detail-input-edit">
                                        </div>
                                    </div>
                                </div>
                                <div class="detail-item detail-item-edit">
                                    <span class="detail-label detail-label-edit">Introduction</span>
                                    <textarea name="introduction" class="detail-textarea detail-textarea-edit">{{ $user->nutritionistsProfile->introduction }}</textarea>
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
                </body>
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
