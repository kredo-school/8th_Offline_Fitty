@extends('layouts.app')

@section('title', 'Profile Content')

@section('content')

    @include('sidebar.humburger')
    <div class="row row-main">
        @include('sidebar.user-sidebar')

        <div class="col-md-9 ms-sm-auto col-lg-10 d-flex justify-content-center align-items-center" style="height: calc(100vh - 190px);">
            <!-- main content -->
            <div class="profile-card profile-card-view " style="width: 60%;">
                <div class="profile-header profile-header-view">
                    @if($user->avatar)
                        <img src="{{ $user->avatar }}" alt="Profile Picture" class="profile-picture profile-picture-view">
                    @else
                        <img src="{{ asset('images/default-avatar.png') }}" alt="Default Profile Picture" class="profile-picture profile-picture-view">
                    @endif
                    <div class="info info-view">
                        <h2 class="profile-name profile-name-view">{{ $user->name }}</h2>
                        <p class="profile-email profile-email-view">{{ $user->email }}</p>
                    </div>
                </div>

                <div class="details details-view">
                    <div class="row">
                        <div class="detail-item detail-item-view col-6">
                            <span class="detail-label detail-label-view">Gender</span>
                            <span class="detail-value detail-value-view">{{ $user->profile->gender }}</span>
                        </div>
                        <div class="detail-item detail-item-view col-6">
                            <span class="detail-label detail-label-view">Birthday</span>
                            <span class="detail-value detail-value-view">{{ \Carbon\Carbon::parse($user->profile->birthday)->format('m-d-Y') }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="detail-item detail-item-view col-6">
                            <span class="detail-label detail-label-view">Height</span>
                            <span class="detail-value detail-value-view">{{ $user->profile->height }}</span>
                        </div>
                        <div class="detail-item detail-item-view col-6">
                            <span class="detail-label detail-label-view">Activity Level</span>
                            <span class="detail-value detail-value-view">{{ $user->profile->activity_level }}</span>
                        </div>
                    </div>
                </div>
                <div class="edit-button edit-button-view">
                    <a href="{{ route('user.editprofile', $user->id) }}" class="edit-link edit-link-view">Edit Profile</a>
                </div>
            </div>
        </div>

    </div>

@endsection
