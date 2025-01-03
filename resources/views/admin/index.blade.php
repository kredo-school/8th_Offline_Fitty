{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Index</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Shrikhand&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined&display=swap" rel="stylesheet">

    <!-- 外部CSSを読み込む -->
    <link rel="stylesheet" href="{{ asset('css/admin/index.css') }}">
     --}}
{{-- </head> --}}

@extends('layouts.admin')

@section('title', 'Admin index')

@push('styles')
    <link href="{{ asset('css/admin/index.css') }}" rel="stylesheet">
@endpush

@section('content')


    <body class="bg-light d-flex justify-content-center align-items-center vh-100">
        <div class="container text-center">
            <h1 class="title">Admin Index</h1>
            <div class="row gx-0 gy-2 justify-content-center align-items-center">
                <div class="col-md-5 col-sm-6 d-flex justify-content-end">
                    <a href="{{ route('admin.users.index') }}" class="card">
                        <span class="material-symbols-outlined">person</span>
                        <span>Users</span>
                    </a>
                </div>
                <div class="col-md-5 col-sm-6 d-flex justify-content-start">
                    <a href="{{ route('admin.nutritionists.index') }}" class="card">
                        <span class="material-symbols-outlined">spa</span>
                        <span>Nutritionists</span>
                    </a>
                </div>
                <div class="col-md-5 col-sm-6 d-flex justify-content-end">
                    <a href="{{ route('admin.categories.index') }}" class="card">
                        <span class="material-symbols-outlined">category</span>
                        <span>Categories</span>
                    </a>
                </div>
                <div class="col-md-5 col-sm-6 d-flex justify-content-start">
                    <a href="{{ route('admin.inquiries.index') }}" class="card orange">
                        <span class="material-symbols-outlined">mail</span>
                        <span>Inquiries</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    {{-- </html> --}}
@endsection
