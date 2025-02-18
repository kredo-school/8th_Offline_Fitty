@extends('layouts.landing')

@section('title', 'team')

@section('content')

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        html, body {
    overflow: hidden;
    height: 100%;
}

/* スクロールを復活させる */
html, body {
    overflow: auto !important;  /* 🟢 スクロールを許可 */
    height: auto !important;   /* 🟢 高さ制限を解除 */
}

/* スクロールの挙動をスムーズにする（オプション） */
html {
    scroll-behavior: smooth !important;
}

    </style>

<!-- Navbar -->
@include('navbar.fitty-navbar')

<body class="bg-green-100">
    {{-- <header class="text-center py-5 bg-green-300">
        <h1 class="text-3xl font-bold">Fitty</h1>
    </header> --}}

        <section class="team-section">
            <h2 class="team-title">Meet the Team</h2>
            <p class="team-description">Meet our team of professionals to serve you</p>
            <div class="button-container">
                <a class="button-orange" href="{{route('about')}}">About us</a>
                <a class="button-green" href="{{route('contact')}}">Contact Us</a>
            </div>
            <div class="team-grid">
                <div class="team-card">
                    <img src="{{ asset('images/Asumi.jpg') }}" alt="Asumi Matsushita" class="team-image">
                    <h3 class="team-name">Asumi Matsushita</h3>
                    <p class="team-role">UI Designer</p>
                </div>
                <div class="team-card">
                    <img src="{{ asset('images/ooishi.jpg') }}" alt="Ryohei Ohishi" class="team-image">
                    <h3 class="team-name">Ryohei Oishi</h3>
                    <p class="team-role">Short-pants-boy</p>
                </div>
                <div class="team-card">
                    <img src="{{ asset('images/emiko.jpg') }}" alt="Emiko Imai" class="team-image">
                    <h3 class="team-name">Emiko Imai</h3>
                    <p class="team-role">Executive Director</p>
                </div>
                <div class="team-card">
                    <img src="{{ asset('images/Atsuki.jpg') }}" alt="Atsuki Ohmori" class="team-image">
                    <h3 class="team-name">Atsuki Ohmori</h3>
                    <p class="team-role">Japanese Himo-Neet</p>
                </div>
                <div class="team-card">
                    <img src="{{ asset('images/naomichi.jpg') }}" alt="Naomichi Satake" class="team-image">
                    <h3 class="team-name">Naomichi Satake</h3>
                    <p class="team-role">Italian Classic Singer</p>
                </div>
            </div>
        </section>


@endsection
