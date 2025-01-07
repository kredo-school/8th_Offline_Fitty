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
    </style>

<body class="bg-green-100">
    {{-- <header class="text-center py-5 bg-green-300">
        <h1 class="text-3xl font-bold">Fitty</h1>
    </header> --}}
    <main>
        <section class="team-section">
            <h2 class="team-title">Meet the Team</h2>
            <p class="team-description">Meet our team of professionals to serve you</p>
            <div class="button-container">
                <button class="button-orange">About us</button>
                <button class="button-green">Contact Us</button>
            </div>
            <div class="team-grid">
                <div class="team-card">
                    <img src="{{ asset('images/asumi.jpg') }}" alt="Asumi Matsushita" class="team-image">
                    <h3 class="team-name">Asumi Matsushita</h3>
                    <p class="team-role">UI Designer</p>
                </div>
                <div class="team-card">
                    <img src="{{ asset('images/ryohei.jpg') }}" alt="Ryohei Ohishi" class="team-image">
                    <h3 class="team-name">Ryohei Ohishi</h3>
                    <p class="team-role">Short-pants-boy</p>
                </div>
                <div class="team-card">
                    <img src="{{ asset('images/emiko.jpg') }}" alt="Emiko Imai" class="team-image">
                    <h3 class="team-name">Emiko Imai</h3>
                    <p class="team-role">Executive Director</p>
                </div>
                <div class="team-card">
                    <img src="{{ asset('images/atsuki.jpg') }}" alt="Atsuki Ohmori" class="team-image">
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
    </main>

@endsection
