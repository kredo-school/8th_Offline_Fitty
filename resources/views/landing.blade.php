@extends('layouts.landing')

@section('title', 'Create Post')

@section('content')

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            margin-top: 0;
            /* 不要であれば削除可能 */
        }

        @media (max-width: 768px) {
    .hero {
        flex-direction: column; /* 縦並びに変更 */
        padding: 40px 5%; /* 余白を減らす */
        margin-top: 4rem; /* 余白を減らす */
    }

    .hero .text-section {
        max-width: 100%; /* 横幅を広げてバランスを取る */
        text-align: center; /* スマホでは中央揃え */
    }

    .hero h1 {
        font-size: 2rem; /* 見出しを小さくする */
        margin-bottom: 20px;
    }

    .hero p {
        font-size: 1.2rem; /* 説明文を小さく */
        margin-bottom: 30px;
    }

    .hero .btn {
        font-size: 1rem; /* ボタンも少し小さく */
        padding: 8px 16px;
    }

    .hero .image-section img {
        margin-top: 10px;
        max-width: 70%; /* 画像の大きさを抑える */
    }

    .navbar {
        padding: 10px 5%; /* ナビバーの余白を減らす */
    }

    .navbar .navbar-brand {
        font-size: 30px !important; /* ブランド名を小さく */
    }

    .navbar .nav-link {
        font-size: 1rem; /* ナビゲーションリンクのフォントサイズを縮小 */
        margin: 0 10px;
    }

    footer {
        font-size: 1rem; /* フッターのフォントサイズも調整 */
        padding: 10px 5%;
    }
}

    </style>

    <!-- Navbar -->
    <nav class="navbar">
        <a class="navbar-brand" href="#">FITTY</a>
        <div>
            <a class="nav-link login" href="{{ route('login') }}">Login</a>
            <a class="nav-link" href="{{ route('about') }}">About Us</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <div class="text-section">
            <h1>"DIETING, MADE SIMPLER."</h1>
            <p>
                Discover the easiest way to achieve your health goals with personalized sustainable habits designed just for
                beginners.
                Start your journey today and unlock a healthier, happier version of yourself with <span>Fitty</span>.
            </p>
            <a href="{{ route('register.step1') }}" class="btn">Start Now</a>
        </div>
        <div class="image-section">
            <img src="{{ asset('images/fitty_logo.png') }}" alt="Fitty Logo">
        </div>
    </div>

    <!-- Footer -->
    <footer>
        send us a message <span>@ichikawa-tech</span>
    </footer>

@endsection
