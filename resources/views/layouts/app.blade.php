<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Suwannaphum:wght@100;300;400;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Shrikhand&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />


    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>
<body>
    <div id="app">
        @if(auth()->check())
        <!-- サイドメニュー -->
        <div class="sidemenu">
            <a href="#" class="menu-item">
                <span class="material-icons mt-3">assignment</span> Record
            </a>
            <a href="#" class="menu-item">
                <span class="material-icons">person</span> Profile
            </a>
            <a href="#" class="menu-item">
                <span class="material-icons">history</span> History
            </a>
            <a href="#" class="menu-item active">
                <span class="material-icons">notifications</span> Notification
            </a>
            <a href="#" class="menu-item">
                <span class="material-icons">help_outline</span> Help
            </a>
            <a href="#" class="menu-item">
                <span class="material-icons">help</span> FAQ
            </a>
            <a href="#" class="menu-item">
                <span class="material-icons">logout</span> Logout
            </a>
        </div>
        @endif

        <!-- ナビバー -->
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/fitty_logo.png') }}" width=60px;  alt="logo">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto"></ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img src="https://via.placeholder.com/50" class="nav-user-icon" alt="Avatar">
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                </div>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- メインコンテンツ -->
        <main class="py-4 main-content">
            @yield('content')
        </main>
    </div>

    <!-- フッター -->
<footer class="footer" style="display: none;">
    <p class="footer-p-1">Terms of Use | Privacy Policy | Help</p>
    <p class="footer-p-2">© 2024 Kredo Tech. All rights reserved.</p>
</footer>

 <!-- JavaScript -->
 <script>
    document.addEventListener("DOMContentLoaded", function () {
        const footer = document.querySelector("footer");
        const body = document.body; // ページ全体のボディ
        const footerHeight = 60; // フッターの高さ (px)
        let isFooterVisible = false; // フッターの表示状態を追跡

        // フッターの高さ分、余白を確保
        body.style.paddingBottom = `${footerHeight}px`;

        window.addEventListener("scroll", function () {
            const scrollTop = window.scrollY; // 現在のスクロール位置
            const windowHeight = window.innerHeight; // ウィンドウの高さ
            const documentHeight = document.documentElement.scrollHeight; // ページ全体の高さ

            // スクロール位置が最下部に達したかをチェック
            if (scrollTop + windowHeight >= documentHeight - 10) {
                if (!isFooterVisible) { // フッターがまだ表示されていない場合のみ表示
                    footer.style.display = "block"; // フッターを表示
                    isFooterVisible = true;
                }
            } else {
                if (isFooterVisible) { // フッターが表示されている場合のみ非表示
                    footer.style.display = "none"; // フッターを非表示
                    isFooterVisible = false;
                }
            }
        });
    });
</script>



    
</body>
</html>
