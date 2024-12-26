<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f9f9f0;
        }
        .sidemenu {
            width: 240px;
            background-color: #d8efd1;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px 10px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        .sidemenu h1 {
            font-size: 24px;
            color: #f68b1e;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
        }
        .sidemenu h1 img {
            height: 40px;
            margin-right: 10px;
        }
        .menu-item {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            font-size: 16px;
            color: #333;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 10px;
            transition: background-color 0.3s;
        }
        .menu-item:hover {
            background-color: #a4d4a2;
            color: #000;
        }
        .menu-item.active {
            background-color: #54b76a;
            color: white;
            font-weight: bold;
        }
        .menu-item .material-icons {
            margin-right: 10px;
            font-size: 20px;
        }
        .menu-footer {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
        }
        .menu-footer p {
            font-size: 14px;
            color: #666;
        }
        .main-content {
            margin-left: 260px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div id="app">

        @if(auth()->check())
    
    
            <!-- サイドメニュー -->
            <div class="sidemenu">
                <h1>
                    <img src="{{ asset('images/logo.png') }}" alt="Fitty Logo"> FITTY
                </h1>
                <a href="#" class="menu-item">
                    <span class="material-icons">assignment</span> Record
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
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
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

    <!-- Footer -->
    <footer style="text-align: center; margin-top: 20px; padding: 10px 0; background-color: #0a8f2c; color: white; border-radius: 8px;">
        <p style="margin: 0;">Terms of Use | Privacy Policy | Help</p>
        <p style="margin: 0;">© 2024 Ichikawa-tech. All rights reserved.</p>
    </footer>

</body>
</html>
