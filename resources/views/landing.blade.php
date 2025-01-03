<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitty - Dieting Made Simpler</title>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Shrikhand&display=swap" rel="stylesheet">
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
            <img src="{{ asset('images/fitty_logo.png') }}" alt="Fitty Logo">
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
