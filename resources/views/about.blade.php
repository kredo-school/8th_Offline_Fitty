<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Fitty</title>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=done_outline" />

    <style>
        body {
            font-family: 'Lora', serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }
    </style>
</head>

<body>
    <!-- About Section -->
    <div class="about-page">
        <!-- About Header -->
        <div class="about-header-section">
            ~ WHO WE ARE ~
        </div>

        <div class="about-content-wrapper">
            <!-- Left Section -->
            <div class="about-description">
                <h2>At Ichikawa-tech, <br>We believe <br>Simplicity drives Solutions.</h2>
                <div class="features-list">
                    <div class="feature-item">
                        <i class="material-symbols-outlined">
                            done_outline
                        </i>
                        <span>Simple, Refined Design</span>
                    </div>
                    <div class="feature-item">
                        <i class="material-symbols-outlined">
                            done_outline
                        </i>
                        <span>Your Partner for New Beginnings</span>
                    </div>
                    <div class="feature-item">
                        <i class="material-symbols-outlined">
                            done_outline
                        </i>
                        <span>Solutions That Drive Society Forward</span>
                    </div>
                    <div class="feature-item">
                        <i class="material-symbols-outlined">
                            done_outline
                        </i>
                        <span>Smarter Ways to Solve Problems</span>
                    </div>
                </div>
                <a href="#" class="team-button">OUR TEAM</a>
            </div>

            <!-- Right Section -->
            <div class="about-image-section">
                <img src="{{ asset('images/team_photo.jpg') }}" alt="Our Team">
            </div>
        </div>
    </div>
</body>

</html>
