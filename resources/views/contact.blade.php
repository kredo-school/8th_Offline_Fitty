<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Information</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">


    <body class="contact-page">
        <div>
            <h1 class="contact-title">Contact Information</h1>
            <div class="contact-item">
                <h1 class="material-symbols-outlined">
                    call
                </h1>
                <p>+1012 3456 789</p>
            </div>
            <div class="contact-item">
                <h1 class="material-symbols-outlined">
                    mail
                </h1>
                <p>demo@gmail.com</p>
            </div>
            <div class="contact-item">
                <h1 class="material-symbols-outlined">
                    location_on
                </h1>
                <p>3-18-12 Midoricho, Yamagata-shi, Yamagata-ken, Japan</p>
            </div>
        </div>
    </body>
</html>
