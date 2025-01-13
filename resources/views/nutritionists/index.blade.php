@extends('layouts.app')

@section('title', 'Home')

@section('content')
@include('sidebar.humburger')

<div class="container w-75">
    <div class="row">
        @include('sidebar.nutri-sidebar')
        <div class="col-md-9 ms-sm-auto col-lg-10">

            <h3 class=" nutri-h2">Send Feedback to</h3>
            <div class="row g-4 mb-5">
                @forelse ($users as $user)
                    <div class="col-12 col-sm-6 col-md-3 col-lg-3 d-flex justify-content-center">
                        <div class="card nutri-card">
                            <!-- ユーザーのアバター画像表示 -->
                            @if ($user->avatar)
                                <img src="{{ $user->avatar }}" class="nutri-card-img-top" alt="Avatar">
                            @else
                                <span class="material-symbols-outlined nutri-material-symbols-outlined">
                                account_circle
                            </span>
                            @endif
                            <div class="card-body">
                                <!-- ユーザー名 -->
                                <h5 class="nutri-card-title">{{ $user->name }}</h5>

                                <!-- Send Advice Button with Form for Submission -->
                                <form action="{{ route('nutri.sendAdvice', $user->id) }}" method="GET">
                                    @csrf
                                    <button type="submit" class="nutri-btn">Send Advice</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div>No Task</div>
                @endforelse
            </div>
        </div>
    </div>
</div>



@endsection
