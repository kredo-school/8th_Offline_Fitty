@extends('layouts.app')

@section('title', 'Profile Content')

@section('content')

    @include('sidebar.humburger')
        <div class="row row-main">
            @include('sidebar.user-sidebar')
            <div class="col-md-9 ms-sm-auto col-lg-10  d-flex justify-content-center align-items-center" style="height: calc(100vh - 190px);">

                @if(Auth::user()->role === 'A')
                    <form action="{{route('admin.users.allocateNutritionist',$user->id)}}" method="post">
                        @csrf
                        @method('PATCH')
                        <label for="allocate" class="fw-bold">Nutritionist In Charge</label>
                        <br>

                        <select name="nutritionist_id" id="allocate" class="my-3 form-select-sm">

                            <option value="{{ $allocated->id}}">{{$allocated->first_name}} {{$allocated->last_name}}</option>
                            @foreach($nutritionists as $nutritionist)
                            <option value="{{ $nutritionist->user_id }}">{{$nutritionist->first_name}} {{$nutritionist->last_name}}</option>
                        @endforeach
                        </select>

                        <button class="btn btn-sm btn-success text-white">allocate</button>
                    </form>
                @endif

                <!-- main content -->
                <div class="profile-card profile-card-view" style="width: 60%;">
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
