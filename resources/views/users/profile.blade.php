@extends('layouts.app')

@section('title', 'Profile')

@section('content')

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Profile</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <style>
            body {
                background-color: #F7FCF1 !important;
                /* 背景色 */
                font-family: 'lora', sans-serif !important;
            }

            .container {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }

            .profile-card {
                background-color: #FFFFFF;
                border-radius: 10px;
                padding: 50px;
                width: 800px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                margin-left: 50px;
            }

            .profile-card h2 {
                text-align: center;
                margin-bottom: 20px;
            }

            .profile-photo {
                text-align: center;
                margin-bottom: 20px;
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 20px;
                font-size: 1.3rem;
            }

            .profile-photo img {
                width: 120px;
                height: 120px;
                border-radius: 50%;
                object-fit: cover;
            }

            .profile-photo p {
                font-size: 1.1rem;
                color: #333;
            }

            .info-group {
                display: flex;
                justify-content: space-between;
                margin-left: 70px;
                margin-bottom: 15px;
            }

            .info-group .info-item {
                flex: 1;
                margin: 0 20px;
            }

            .info-group label {
                font-weight: bold;
                color: #333;
                display: block;
                font-size: 1.3rem;
                margin-bottom: 5px;
            }

            .info-group .value {
                color: #555;
                font-size: 1.3rem;
            }

            .info-group.full {
                flex-direction: column;
                align-items: flex-start;
                margin-left: 70px;
            }

            .info-group.full .value {
                margin-top: 5px;
                text-align: left;
            }

            .edit-button {
                text-align: left;
                margin-left: 70px;
                font-size: 1.15rem;
                margin-top: 70px;
            }

            .edit-button button {
                background-color: #00A550;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
            }

            .edit-button button:hover {
                background-color: #007A3A;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="profile-card">
                <div class="profile-photo">
                    <img src="images/fitty_logo.png" alt="Profile Photo">
                    <p>alexarawles@gmail.com</p>
                </div>
                <div class="info-group">
                    <div class="info-item">
                        <label>First Name</label>
                        <div class="value">Emiko</div>
                    </div>
                    <div class="info-item">
                        <label>Last Name</label>
                        <div class="value">Imai</div>
                    </div>
                </div>
                <div class="info-group">
                    <div class="info-item">
                        <label>Gender</label>
                        <div class="value">Female</div>
                    </div>
                    <div class="info-item">
                        <label>Date of Birth</label>
                        <div class="value">Age</div>
                    </div>
                </div>
                <div class="info-group">
                    <div class="info-item">
                        <label>Height (cm)</label>
                        <div class="value">169</div>
                    </div>
                    <div class="info-item">
                        <label>Exercise Frequency</label>
                        <div class="value">3</div>
                    </div>
                </div>
                <div class="info-group full">
                    <label>Current Health Conditions</label>
                    <div class="value">{Add conditions here}</div>
                </div>
                <div class="edit-button">
                    <button>Edit</button>
                </div>
            </div>
        </div>
    </body>

    </html>

    @
