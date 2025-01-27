@extends('layouts.app')

@section('title', 'Create Post')

@section('content')

@include('sidebar.humburger')
<div class="row main-row">
    <!-- Header Section -->
    @include('sidebar.user-sidebar') 
    <div class="col-md-9 ms-sm-auto col-lg-10 user-history"> 
        <!-- main content -->
        <h1 class="text-center">History</h1>             
    </div>
</div>

  
@endsection