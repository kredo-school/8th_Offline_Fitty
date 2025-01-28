@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

    @include('sidebar.humburger')

        <div class="row">
            @include('sidebar.nutri-sidebar')
            <div class="col-md-9 ms-sm-auto col-lg-10 mt-4">
                <!-- main content -->

                <body>
                    <form action="{{ route('nutri.updateProfile', $user->id) }}" method="POST" enctype="multipart/form-data">
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
                                    <input type="file" name="avatar" id="avatar" class=" mt-2"
                                        style="max-width: 300px; margin: 0 auto;">
                                </div>

                                <!-- Name -->
                                <div class="form-group mt-4">
                                    <label for="name" class="form-label fw-bold">User Name</label>
                                    <input type="text" name="name" id="name" value="{{ $user->name }}"
                                        class="form-control text-center" style="max-width: 300px; margin: 0 auto;"
                                        placeholder="Enter your name">
                                </div>

                                <!-- Email -->
                                <div class="form-group mt-4">
                                    <label for="email" class="form-label fw-bold">Email</label>
                                    <input type="email" name="email" id="email" value="{{ $user->email }}"
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
                                                value="{{ $user->nutritionistsProfile->first_name }}"
                                                class="detail-input detail-input-edit">
                                        </div>

                                        <div class="col-6">
                                            <span class="detail-label detail-label-edit">Last Name</span>

                                            <input type="text" name="last_name"
                                                value="{{ $user->nutritionistsProfile->last_name }}"
                                                class="detail-input detail-input-edit">
                                        </div>
                                    </div>
                                </div>
                                <div class="detail-item detail-item-edit">
                                    <span class="detail-label detail-label-edit">Description</span>
                                    <textarea name="memo" class="detail-textarea detail-textarea-edit">{{ $user->nutritionistsProfile->memo }}</textarea>
                                </div>
                            </div>
                            <div class="edit-button edit-button-edit">
                                <button type="submit" class="save-button save-button-edit">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </body>
            </div>
        </div>
  




@endsection
