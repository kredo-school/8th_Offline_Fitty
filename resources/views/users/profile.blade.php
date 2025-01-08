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
                            <h2 class="profile-name profile-name-view">Emiko Imai</h2>
                            <p class="profile-email profile-email-view">alexarawles@gmail.com</p>
                        </div>
                    </div>
                    <div class="details details-view">
                        <div class="detail-item detail-item-view">
                            <span class="detail-label detail-label-view">Full Name</span>
                            <span class="detail-value detail-value-view">{{$user->name}}</span>
                        </div>
                        <div class="detail-item detail-item-view">
                            <span class="detail-label detail-label-view">Gender</span>
                            <span class="detail-value detail-value-view">{{$user->gender}}</span>
                        </div>
                        <div class="detail-item detail-item-view">
                            <span class="detail-label detail-label-view">Birth Day</span>
                            <span class="detail-value detail-value-view">     {{ \Carbon\Carbon::parse($user->birthday)->format('m-d-Y') }}</span>
                        </div>
                        <div class="detail-item detail-item-view">
                            <span class="detail-label detail-label-view">Activity Level</span>
                            <span class="detail-value detail-value-view">{{$user->activity_level}}</span>
                        </div>
                        {{-- <div class="detail-item detail-item-view">
                            <span class="detail-label detail-label-view">Description</span>
                            <span class="detail-value detail-value-view">Lorem ipsum dolor sit amet, consectetur adipiscing
                                elit.
                                Curabitur auctor nisi a erat tristique, nec gravida justo bibendum.</span>
                        </div> --}}
                    </div>
                    <div class="edit-button edit-button-view">
                        <a href="#" class="edit-link edit-link-view">Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
