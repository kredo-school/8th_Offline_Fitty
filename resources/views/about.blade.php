<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Fitty</title>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }
        .about-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: #008000; /* 緑色 */
            color: #ffffff;
            min-height: 100vh; /* 画面全体の高さをカバー */
            padding: 20px 10%;
        }
        .about-header {
            width: 100%;
            text-align: center;
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 60px;
        }
        .about-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            width: 100%;
        }
        .about-text {
            max-width: 70%;
            flex: 1;
        }
        .about-text h2 {
            font-size: 2rem;
            margin-bottom: 30px;
            line-height: 1.8;
        }
        .about-text h2 span{
            color: orange;
        }
        .about-text .features {
            display: grid;
            grid-template-columns: 1fr 1fr; /* 2列 */
            gap: 20px;
            font-size: 1.5rem;
            margin-top: 20px;
        }

        .about-text span .simplicity{
            color:orange;
        }
        .feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .feature-item i {
            font-size: 3rem;
            margin-right: 1rem;
        }
        .our-team-btn {
            display: inline-block;
            margin-top: 60px;
            padding: 10px 20px;
            background-color: #e0ffe0;
            color: #008000;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1.2rem;
        }
        .about-image {
            max-width: 25%;
            flex: 1;
        }
        .about-image img {
            max-width: 100%;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <!-- About Section -->
    <div class="about-section">
        <!-- About Header -->
        <div class="about-header">
            ~ WHO WE ARE ~
        </div>

        <div class="about-content">
            <!-- Left Section -->
            <div class="about-text">
                <h2>At <span>Ichikawa-tech</span>, We believe <span class="simplicity">Simplicity</span> drives Solutions.</h2>
                <div class="features">
                    <div class="feature-item">
                        <i>✔</i>
                        <span>Simple, Refined Design</span>
                    </div>
                    <div class="feature-item">
                        <i>✔</i>
                        <span>Your Partner for New Beginnings</span>
                    </div>
                    <div class="feature-item">
                        <i>✔</i>
                        <span>Solutions That Drive Society Forward</span>
                    </div>
                    <div class="feature-item">
                        <i>✔</i>
                        <span>Smarter Ways to Solve Problems</span>
                    </div>
                </div>
                <a href="#" class="our-team-btn">OUR TEAM</a>
            </div>

            <!-- Right Section -->
            <div class="about-image">
                <img src="{{ asset('images/team_photo.jpg') }}" alt="Our Team">
            </div>
        </div>
    </div>
</body>
</html>
