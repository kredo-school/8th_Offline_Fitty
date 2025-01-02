@extends('layouts.app')

@section('title', 'Profile Content')

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
            background-color: #F5F5F5;
        }

        .profile-card {
            background-color: white;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: auto;
            margin-top: 50px;
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .profile-header img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-header .info {
            font-size: 18px;
        }

        .profile-header .info h2 {
            margin: 0;
            font-size: 24px;
        }

        .profile-header .info p {
            margin: 5px 0;
            color: gray;
        }

        .details {
            margin-top: 30px;
            padding: 20px;
        }

        .details div {
            margin-bottom: 20px;
            font-size: 18px;
        }

        .details span {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .edit-button {
            text-align: center;
            margin-top: 20px;
        }

        .edit-button a {
            text-decoration: none;
            background-color: #FFA965;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 18px;
            display: inline-block;
        }

        .edit-button a:hover {
            background-color: #ff8a30;
        }
    </style>
</head>
<body>
    <div class="profile-card">
        <div class="profile-header">
            <img src="https://via.placeholder.com/120" alt="Profile Picture">
            <div class="info">
                <h2>Emiko Imai</h2>
                <p>alexarawles@gmail.com</p>
            </div>
        </div>
        <div class="details">
            <div>
                <span>Full Name</span>
                Emiko Imai
            </div>

            <div>
                <span>Description</span>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur auctor nisi a erat tristique, nec
                gravida justo bibendum.
            </div>
        </div>
        <div class="edit-button">
            <a href="#">Edit Profile</a>
        </div>
    </div>
</body>
</html>

@endsection
