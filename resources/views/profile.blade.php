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
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #F5F5F5;
        }
        .container {
            display: flex;
            height: 100vh;
        }
        .sidebar {
            background-color: #E6F4EA;
            width: 300px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .sidebar .menu {
            list-style: none;
            padding: 0;
        }
        .sidebar .menu li {
            margin: 15px 0;
            font-size: 1.2rem;
            color: #333;
            display: flex;
            align-items: center;
        }
        .sidebar .menu li i {
            margin-right: 10px;
        }
        .sidebar .menu li.active {
            background-color: #00A550;
            color: white;
            padding: 10px;
            border-radius: 8px;
        }
        .content {
            flex: 1;
            padding: 20px;
            background-color: #FFFFFF;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 1.5rem;
        }
        .profile-card {
            background-color: #F5F5F5;
            border-radius: 10px;
            padding: 20px;
            max-width: 600px;
            margin: auto;
        }
        .profile-card h2 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group textarea {
            resize: none;
        }
        .form-footer {
            display: flex;
            justify-content: center;
        }
        .form-footer button {
            background-color: #00A550;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-footer button:hover {
            background-color: #007A3A;
        }
    </style>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <ul class="menu">
                <li><i class="fas fa-folder"></i> Record</li>
                <li><i class="fas fa-user"></i> Profile</li>
                <li><i class="fas fa-bell"></i> Notification</li>
                <li class="active"><i class="fas fa-history"></i> History</li>
                <li><i class="fas fa-cog"></i> Settings</li>
                <li><i class="fas fa-question-circle"></i> FAQ</li>
                <li><i class="fas fa-sign-out-alt"></i> Logout</li>
            </ul>
        </aside>
        <main class="content">
            <div class="header">
                <h1>User Profile</h1>
                <div>
                    <label for="role">Admin</label>
                    <select id="role">
                        <option>In charge</option>
                        <option>Not in charge</option>
                    </select>
                    <button>Assign</button>
                </div>
            </div>
            <div class="profile-card">
                <h2>Emiko Imai</h2>
                <p>alexarawles@gmail.com</p>
                <form>
                    <div class="form-group">
                        <label for="first-name">First Name</label>
                        <input type="text" id="first-name" value="Emiko">
                    </div>
                    <div class="form-group">
                        <label for="last-name">Last Name</label>
                        <input type="text" id="last-name" value="Imai">
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <input type="text" id="gender" value="Female">
                    </div>
                    <div class="form-group">
                        <label for="dob">Data of Birth</label>
                        <input type="text" id="dob" value="Age">
                    </div>
                    <div class="form-group">
                        <label for="height">Height(cm)</label>
                        <input type="number" id="height" value="169">
                    </div>
                    <div class="form-group">
                        <label for="exercise">Exercise frequency</label>
                        <input type="number" id="exercise" value="3">
                    </div>
                    <div class="form-group">
                        <label for="health">Current health conditions (if any)</label>
                        <textarea id="health" rows="4">{Add conditions here}</textarea>
                    </div>
                    <div class="form-footer">
                        <button type="submit">Edit</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>


@endsection
