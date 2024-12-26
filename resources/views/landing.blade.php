<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitty - Dieting Made Simpler</title>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
            padding: 15px 10%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
        }
        .navbar .navbar-brand {
            font-size: 3rem;
            font-weight: bold;
            color: #ff7f50;
            text-decoration: none;
            font-style: italic; /* イタリック体を適用 */
        }
        .navbar .nav-link {
            color: #555;
            font-size: 1.2rem;
            margin: 0 15px;
            text-decoration: none;
        }

        .navbar .nav-link:hover {
            color: #ff7f50;
        }
        .hero {
            flex: 1;
            display: flex;
            align-items: center; /* 縦方向の中央配置 */
            justify-content: space-between;
            padding: 60px 10%;
            margin: 0 auto;
            max-width: 1200px;
        }
        .hero .text-section {
            max-width: 70%;
        }
        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 30px;
        }
        .hero p {
            font-size: 1.5rem;
            color: #555;
            margin-bottom: 40px;
        }
        .hero p span {
            color: #ff7f50;
            font-weight: bold;
        }
        .hero .btn {
            background-color: #28a745;
            color: #fff;
            font-size: 1.2rem;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }
        .hero .btn:hover {
            background-color: #218838;
        }
        .hero .image-section {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .hero .image-section img {
            max-width: 80%;
            height: auto;
        }
        footer {
            padding: 20px 10%;
            text-align: center;
            font-size: 1.2rem;
            color: #555;
        }
        footer span{
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a class="navbar-brand" href="#">FITTY</a>
        <div>
            <a class="nav-link login" href="#">Login</a>
            <a class="nav-link" href="#">About Us</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <div class="text-section">
            <h1>"DIETING, MADE SIMPLER."</h1>
            <p>
                Discover the easiest way to achieve your health goals with personalized sustainable habits designed just for beginners.
                Start your journey today and unlock a healthier, happier version of yourself with <span>Fitty</span>.
            </p>
            <a href="#" class="btn">Start Now</a>
        </div>
        <div class="image-section">
            <img src="{{ asset('images/logo.png') }}" alt="Fitty Logo">
        </div>
    </div>

    <!-- Footer -->
    <footer>
        send us a message <span>@ichikawa-tech</span>
    </footer>

    <!-- Bootstrap JS -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
