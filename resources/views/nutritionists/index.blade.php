@extends('layouts.app')

@section('title', 'Home')

@section('content')
@include('sidebar.humburger')

    <div class="row w-100">
    @include('sidebar.include-sidebar')
        <div class="col-md-9 ms-sm-auto col-lg-10">
        <div class="container w-75">

            <h3 class=" nutri-h2 mt-5">Send Feedback to</h3>
            <div class="row g-4 mb-5">
                @forelse ($user_profiles as $user_profile)
                    <div class="col-12 col-sm-6 col-md-3 col-lg-3 d-flex justify-content-center">
                        <div class="card nutri-card">
                            <!-- ユーザーのアバター画像表示 -->
                            @if ($user_profile->user->avatar)
                                <img src="{{ $user_profile->user->avatar }}" class="nutri-card-img-top" alt="Avatar">
                            @else
                                <span class="material-symbols-outlined nutri-material-symbols-outlined">
                                    account_circle
                                </span>
                            @endif
                            <div class="card-body">
                                <!-- ユーザー名 -->
                                <h5 class="nutri-card-title">{{ $user_profile->first_name }} {{ $user_profile->last_name }}</h5>

                                <!-- Send Advice Button with Form for Submission -->
                                <form action="{{ route('nutri.sendAdvice', $user_profile->user_id) }}" method="GET">
                                    @csrf
                                    <button type="submit" class="nutri-btn">Send Advice</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div><h5>No tasks yet</h5></div>
                @endforelse
            </div>
            @if ($user_profiles->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $user_profiles->links('nutritionists.pagination') }}
    </div>
@endif
        </div>
    </div>
</div>



@endsection
