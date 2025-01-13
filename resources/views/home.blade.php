@extends('layouts.app')

@section('content')
<div class="container" style="padding-top: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="">
                <div class="">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="text-center" style="padding: 30px; border: 2px solid #007bff; border-radius: 15px; background: #f0f8ff;">
                        <h2 style="font-weight: bold; color: #007bff;">{{ __('You are logged in!') }}</h2>
                        <p style="margin-top: 10px; color: #495057; font-size: 1.1rem;">Welcome back! Access your tools and resources now.</p>
                    </div>
                    
                    {{-- {{ __('You are logged in!') }} --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
