@extends('layouts.app')

@section('title', 'Profile Content')

@section('content')

    @include('sidebar.humburger')
    <div class="container user-dailylog">
        <div class="row">
            @include('sidebar.user-sidebar')
            <div class="col-md-9 ms-sm-auto col-lg-10 mt-4">
                <!-- main content -->
                <div class="profile-card profile-card-view">
                    <div class="profile-header profile-header-view">
                        <img src="https://via.placeholder.com/120" alt="Profile Picture"
                            class="profile-picture profile-picture-view">
                        <div class="info info-view">
                            <h2 class="profile-name profile-name-view">{{ $user->name }}</h2>
                            <p class="profile-email profile-email-view">{{ $user->email }}</p>
                        </div>
                    </div>
                    <div class="details details-view">

                        <div class="row">
                            <div class="detail-item detail-item-view col-6">
                                <span class="detail-label detail-label-view">Gender</span>
                                <span class="detail-value detail-value-view">{{ $user->gender }}</span>
                            </div>
                            <div class="detail-item detail-item-view col-6">
                                <span class="detail-label detail-label-view">Birthday</span>
                                <span
                                    class="detail-value detail-value-view">{{ \Carbon\Carbon::parse($user->birthday)->format('m-d-Y') }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="detail-item detail-item-view col-6">
                                <span class="detail-label detail-label-view">Height</span>
                                <span class="detail-value detail-value-view">{{ $user->height }}</span>
                            </div>
                            <div class="detail-item detail-item-view col-6">
                                <span class="detail-label detail-label-view">Acticity Level</span>
                                <span class="detail-value detail-value-view">{{ $user->activity_level }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="edit-button edit-button-view">
                        <a href="{{ route('user.editprofile', $user->id) }}" class="edit-link edit-link-view">Edit
                            Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection
