@extends('layouts.app')

@section('title', 'Create Post')

@section('content')

@include('sidebar.humburger')
<div class="container user-history">
    <!-- Header Section -->
    <div class="user-history-header">
        <div class="row">
            @include('sidebar.user-sidebar') 
            <div class="col-md-9 ms-sm-auto col-lg-10"> 
            <!-- main content -->
             <h1 class="text-center">History</h1>
             
            </div>
        </div>
    </div>
</div>

  
@endsection