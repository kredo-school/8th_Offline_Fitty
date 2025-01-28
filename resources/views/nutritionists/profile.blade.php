@extends('layouts.app')

@section('title', 'Profile Content')

@section('content')

    @include('sidebar.humburger')
    <div class="container user-dailylog">
        <div class="row">
            @include('sidebar.nutri-sidebar')
            <div class="col-md-9 ms-sm-auto col-lg-10 mt-4">
                <!-- main content -->

                <div class="profile-card profile-card-view">
                    <div class="profile-header profile-header-view">
                        @if($user->avatar)
                        <img src="{{ $user->avatar }}" alt="Profile Picture" class="profile-picture profile-picture-view">
                    @else
                        <img src="{{ asset('images/default-avatar.png') }}" alt="Default Profile Picture" class="profile-picture profile-picture-view">
                    @endif
                        <div class="info info-view">
                            <h2 class="profile-name profile-name-view">{{$user->name}}</h2>
                            <p class="profile-email profile-email-view">{{$user->email}}</p>
                        </div>
                    </div>
                    <div class="details details-view">
                        <div class="detail-item detail-item-view">
                            <span class="detail-label detail-label-view">Full Name</span>
                            <span class="detail-value detail-value-view">{{$user->nutritionistsProfile->first_name}} {{$user->nutritionistsProfile->last_name}}</span>
                        </div>
                        <div class="detail-item detail-item-view">
                            <span class="detail-label detail-label-view">Description</span>
                            <span class="detail-value detail-value-view">{{$user->nutritionistsProfile->memo}}</span>
                        </div>
                    </div>
                    <div class="edit-button edit-button-view">
                        <a href="{{route('nutri.editProfile',$user->id)}}" class="edit-link edit-link-view">Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
