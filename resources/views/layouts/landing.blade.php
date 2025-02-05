<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitty - Dieting Made Simpler</title>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Shrikhand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />



    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <meta name="viewport" content="width=device-width, initial-scale=1">


</head>

<body>
    <main class="main-content">
        @yield('content')
    </main>


    <!-- Bootstrap JS -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
