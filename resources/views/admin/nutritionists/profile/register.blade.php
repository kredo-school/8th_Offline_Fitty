@extends('layouts.app')

@section('content')
    @include('sidebar.humburger')

    <div class="row row-main w-100">
        @include('sidebar.admin-sidebar')

        <div class="col-md-9 ms-sm-auto col-lg-10">
            <!-- Main Content -->
            <div class="admin-nutri-profile">
                <div class="col-8">
                    <div class="container admin-nutri-profile-container">
                        <!-- Form Container with White Background -->
                        <div class="bg-white rounded-5 shadow-sm mx-4 my-5 p-4">
                            <h1 class="admin-nutri-profile-title text-start mb-4 mt-4">New Nutritionist</h1>
                            <form action="{{ route('admin.nutritionists.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <!-- Profile Photo -->
                                <div class="mb-4 d-flex align-items-center">
                                    <div class="col-4 text-center">
                                        @if (isset($user) && $user->profile_photo_path)
                                            <img src="{{ asset('storage/' . $user->profile_photo_path) }}" 
                                                 class="rounded-circle" alt="Profile Photo" width="150" height="150">
                                        @else
                                            <span class="material-icons-outlined d-block" style="font-size: 150px; color: #757575;">
                                                face
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-auto align-self-end ps-5">
                                        <input type="file" name="profile_image" class="form-control" accept="image/*">
                                        <small class="text-muted d-block mt-1">
                                            Acceptable formats: jpeg, jpg, png. <br> 
                                            Max file size: 1024KB.
                                        </small>
                                    </div>
                                </div>

                                <!-- Username -->
                                <div class="form-group mb-3">
                                    <label for="username" class="form-label">User Name</label>
                                    <input type="text" id="username" name="username" class="form-control" placeholder="sukiyaki tabetai" value="{{ old('username') }}" required>
                                </div>

                                <!-- First and Last Name -->
                                <div class="row">
                                    <div class="form-group col-md-6 mb-3">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input type="text" id="first_name" name="first_name" class="form-control" placeholder="sukiyaki" value="{{ old('first_name') }}" required>
                                    </div>
                                    <div class="form-group col-md-6 mb-3">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" id="last_name" name="last_name" class="form-control" placeholder="tabetai" value="{{ old('last_name') }}" required>
                                    </div>
                                </div>

                                <!-- Email Address -->
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="sukiyaki@gmail.com" value="{{ old('email') }}" required>
                                </div>

                                <!-- Password -->
                                <div class="form-group mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-group mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Re-enter your password" required>
                                </div>

                                <!-- Self Introduction -->
                                <div class="form-group mb-3">
                                    <label for="introduction" class="form-label">Self Introduction</label>
                                    <textarea id="introduction" name="introduction" class="form-control" rows="4">{{ old('introduction') }}</textarea>
                                </div>

                                <!-- Submit and Cancel Buttons -->
                                <div class="text-end">
                                    <div class="d-flex justify-content-end admin-nutri-profile-button-container mb-5">
                                        <a href="{{ route('admin.nutritionists.index') }}" class="btn admin-nutri-profile-cancel-btn me-2 admin-btn-equal">Cancel</a>
                                        <button type="submit" class="btn admin-nutri-profile-add-btn admin-btn-equal">Add</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
