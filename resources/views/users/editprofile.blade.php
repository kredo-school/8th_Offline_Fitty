@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Profile</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <style>
            body {
                margin: 0;
                font-family: Arial, sans-serif;
                background-color: #F7FCF1;
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
                padding: 30px;
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
            }

            .profile-photo img {
                width: 150px;
                height: 150px;
                border-radius: 50%;
                object-fit: cover;

            }

            .profile-photo input[type="file"] {
                display: block;
                margin: 50px auto;

            }

            .info-group {
                display: flex;
                justify-content: space-between;
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
                margin-bottom: 5px;
            }

            .info-group input,
            .info-group textarea {
                width: 100%;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }

            .info-group textarea {
                resize: none;
            }

            .info-group.full {
                flex-direction: column;
                align-items: flex-start;
            }

            .info-group.full textarea {
                width: 95%;
            }

            .save-button {
                text-align: center;
                margin-top: 30px;
            }

            .save-button button {
                background-color: #FFA965;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
            }

            .save-button button:hover {
                background-color: #f77d20;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <form class="profile-card">
                <div class="profile-photo">
                    <img src="" alt="Profile Photo">
                    <input type="file" accept="image/*" class="form-control">
                </div>
                <div class="info-group">
                    <div class="info-item">
                        <label for="first-name">First Name</label>
                        <input type="text" id="first-name" name="first-name" value="Emiko">
                    </div>
                    <div class="info-item">
                        <label for="last-name">Last Name</label>
                        <input type="text" id="last-name" name="last-name" value="Imai">
                    </div>
                </div>
                <div class="info-group">
                    <div class="info-item">
                        <label for="gender">Gender</label>
                        <input type="text" id="gender" name="gender" value="Female">
                    </div>
                    <div class="info-item">
                        <label for="dob">Date of Birth</label>
                        <input type="text" id="dob" name="dob" value="Age">
                    </div>
                </div>
                <div class="info-group">
                    <div class="info-item">
                        <label for="height">Height (cm)</label>
                        <input type="number" id="height" name="height" value="169">
                    </div>
                    <div class="info-item">
                        <label for="exercise">Exercise Frequency</label>
                        <input type="number" id="exercise" name="exercise" value="3">
                    </div>
                </div>
                <div class="info-group full">
                    <label for="health">Current Health Conditions</label>
                    <textarea id="health" name="health" rows="4" placeholder="Add conditions here"></textarea>
                </div>
                <div class="save-button">
                    <button type="submit">Save</button>
                </div>
            </form>
        </div>
    </body>

    </html>

@endsection
