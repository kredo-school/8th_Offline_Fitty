@extends('layouts.landing')

@section('title', 'Conctact')

@section('content')


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

             <!-- 戻るボタン -->
             <div class="back-button-container">
                <button class="back-button" onclick="window.history.back();">←Back</button>
            </div>


    </body>

    <style>
        .back-button-container {
            margin-top: 20px;
            text-align: center;
        }
        .back-button {
            background-color: #FFA965;
            color: white;
            font-weight: bold;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        .back-button:hover {
            background-color: #fc8529;
        }
    </style>
 @endsection
