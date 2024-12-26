<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Information</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html,
        body {
            margin: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: #F5F5F5;
        }

        .contact-container {
            background-color: #00A550;
            color: white;
            text-align: center;
            padding: 50px 20px;
            height: 100%;
        }

        .contact-container h1 {
            font-size: 3rem;
            margin-bottom: 30px;
        }

        .contact-item {
            margin: 50px 0;
            font-size: 1.2rem;
        }

        .contact-item h1 {
            font-size: 50px;
        }

        .contact-item p {
            font-size: 22px;
            font-weight: bold;
        }

        .decorative-circles {
            position: relative;
            margin-top: 50px;
            height: 150px;
        }

        .circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            position: absolute;
            opacity: 0.8;
        }

        .circle.black {
            background-color: black;
            bottom: 0;
            left: 10%;
        }

        .circle.white {
            background-color: white;
            bottom: 10px;
            left: 30%;
        }

        .circle.grey {
            background-color: grey;
            bottom: 20px;
            left: 50%;
        }

        .circle.light-grey {
            background-color: lightgrey;
            bottom: 40px;
            left: 70%;
        }

        .circle.dark-grey {
            background-color: #333;
            bottom: 60px;
            left: 20%;
        }

        .circle.green {
            background-color: #006600;
            bottom: 80px;
            left: 40%;
        }
    </style>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">


<body>
    <div class="contact-container">
        <h1>Contact Information</h1>
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
            <p> 3-18-12 Midoricho, Yamagata-shi, Yamagata-ken, Japan</p>
        </div>
    </div>

    <butto class="button-orange">About us</butto>
</body>

</html>
