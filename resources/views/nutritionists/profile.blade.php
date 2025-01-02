@extends('layouts.app')
@section('title', 'Home')
@section('content')

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profile Content</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #F5F5E5;
            }

            .profile {
                background-color: white;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                max-width: 600px;
                margin: auto;
                margin-top: 50px;
            }

            .profile img {
                width: 100px;
                height: 100px;
                border-radius: 50%;
                display: block;
                margin: 0 auto;
            }

            .profile h2 {
                text-align: center;
                font-size: 22px;
                margin-top: 10px;
            }

            .profile p {
                text-align: center;
                color: gray;
                margin: 5px 0;
            }

            .profile .details {
                margin-top: 20px;
                font-size: 1.2rem
            }

            .profile .details div {
                margin-bottom: 10px;
            }

            .profile .details span {
                font-weight: bold;
            }
        </style>
    </head>

    <body>
        <!-- プロファイルセクション -->
        <div class="profile">
            <img src="https://via.placeholder.com/100" alt="Profile Picture">
            <h2>Alexa Rawles</h2>
            <p>alexarawles@gmail.com</p>
            <div class="details">
                <div><span>Full Name:</span> Emiko Imai</div>
                <div><span>Gender:</span> Female</div>
                <div><span>Description:</span> <br>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur auctor
                    nisi a erat tristique, nec gravida justo bibendum.</div>
            </div>
        </div>
    </body>

    </html>

@endsection
