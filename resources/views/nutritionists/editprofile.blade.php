@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
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
            margin-left: 175px;
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

        .details input, .details textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .edit-button {
            text-align: center;
            margin-top: 20px;
        }

        .edit-button button {
            text-decoration: none;
            background-color: #FFA965;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 18px;
            border: none;
            cursor: pointer;
        }

        .edit-button button:hover {
            background-color: #ff8a30;
        }
    </style>
</head>
<body>
    <form action="/profile/update" method="POST">
        @csrf
        <div class="profile-card">
            <div class="profile-header">
                <img src="https://via.placeholder.com/120" alt="Profile Picture">
                <div class="info">
                    <label class="h2 form-label">Emiko Imai</label>
                    <input type="email" name="email" value="alexarawles@gmail.com" class="form-control">
                </div>
            </div>
            <div class="details">
                <div>
                    <span>Full Name</span>
                    <input type="text" name="full_name" value="Emiko Imai">
                </div>
                <div>
                    <span>Description</span>
                    <textarea name="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur auctor nisi a erat tristique, nec gravida justo bibendum.</textarea>
                </div>
            </div>
            <div class="edit-button">
                <button type="submit">Save Changes</button>
            </div>
        </div>
    </form>
</body>
</html>

@endsection
