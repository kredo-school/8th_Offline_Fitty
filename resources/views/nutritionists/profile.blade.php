@extends('layouts.app')

@section('title', 'Profile Content')

@section('content')

    @include('sidebar.humburger')

    <style>
    .custom-back-button {
        position: absolute;
        top: 15px;  /* 上部に配置 */
        left: 20px; /* サイドバーより少し右に配置 */
        z-index: 10;
    }
    </style>


        <div class="row row-main">
            @include('sidebar.include-sidebar')
            <div class="col-md-9 ms-sm-auto col-lg-10 d-flex justify-content-center align-items-center" style="height: calc(100vh - 190px); position:relative;">
                <!-- main content -->
                @if(Auth::user()->role === "A")
                <button class="btn btn-outline-secondary custom-back-button" onclick="window.history.back()">&larr;</button>
                @endif

                <div class="profile-card profile-card-view" style="width: 60%;">
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
                            <span class="detail-label detail-label-view">Introduction</span>
                            <span class="detail-value detail-value-view">{!! nl2br(e($user->nutritionistsProfile->introduction)) !!}</span>
                        </div>
                    </div>

                    @if(Auth::user()->role !== 'U')
                    <div class="edit-button edit-button-view">
                        <a href="{{route('nutri.editProfile',$user->id)}}" class="edit-link edit-link-view">Edit Profile</a>
                    </div>
                    @endif

                </div>
            </div>
        </div>
h1oi
@endsection
