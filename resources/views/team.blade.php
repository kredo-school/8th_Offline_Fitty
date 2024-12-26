<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitty Team</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            height: 100%;
            display: flex;
            flex-direction: column;
        }



        .team-section {
            min-height: 100vh;
            /* 画面全体の高さ */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #d1ecd1;
            padding: 20px;
            box-sizing: border-box;
        }

        .team-title {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .team-description {
            font-size: 1.6rem;
            color: #666;
            margin-bottom: 40px;
            text-align: center;
        }

        .button-container {
            display: flex;
            gap: 15px;
            margin-bottom: 75px;
        }

        .button-orange,
        .button-green {
            padding: 10px 20px;
            font-size: 1.3rem;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            color: white;
        }

        .button-orange {
            background-color: #FFA500;
        }

        .button-orange:hover {
            background-color: #FF8C00;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .button-green {
            background-color: #32CD32;
        }

        .button-green:hover {
            background-color: #228B22;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            width: 100%;
            max-width: 1200px;
            box-sizing: border-box;
        }

        .team-card {
            background-color: white;
            border-radius: 10px;
            text-align: center;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .team-image {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .team-name {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
        }

        .team-role {
            font-size: 1.1rem;
            color: #666;
        }

        /* レスポンシブ対応 */
        @media (max-width: 768px) {
            .team-title {
                font-size: 2rem;
            }

            .team-description {
                font-size: 1rem;
            }

            .button-container {
                flex-direction: column;
                gap: 10px;
            }

            .team-card {
                padding: 15px;
            }

            .team-image {
                width: 60px;
                height: 60px;
            }
        }
    </style>
</head>

<body class="bg-green-100">
    {{-- <header class="text-center py-5 bg-green-300">
        <h1 class="text-3xl font-bold">Fitty</h1>
    </header> --}}
    <main>
        <section class="team-section">
            <h2 class="team-title">Meet the Team</h2>
            <p class="team-description">Meet our team of professionals to serve you</p>
            <div class="button-container">
                <button class="button-orange">About us</button>
                <button class="button-green">Contact Us</button>
            </div>
            <div class="team-grid">
                <div class="team-card">
                    <img src="{{ asset('images/asumi.jpg') }}" alt="Asumi Matsushita" class="team-image">
                    <h3 class="team-name">Asumi Matsushita</h3>
                    <p class="team-role">UI Designer</p>
                </div>
                <div class="team-card">
                    <img src="{{ asset('images/ryohei.jpg') }}" alt="Ryohei Ohishi" class="team-image">
                    <h3 class="team-name">Ryohei Ohishi</h3>
                    <p class="team-role">Short-pants-boy</p>
                </div>
                <div class="team-card">
                    <img src="{{ asset('images/emiko.jpg') }}" alt="Emiko Imai" class="team-image">
                    <h3 class="team-name">Emiko Imai</h3>
                    <p class="team-role">Executive Director</p>
                </div>
                <div class="team-card">
                    <img src="{{ asset('images/atsuki.jpg') }}" alt="Atsuki Ohmori" class="team-image">
                    <h3 class="team-name">Atsuki Ohmori</h3>
                    <p class="team-role">Japanese Himo-Neet</p>
                </div>
                <div class="team-card">
                    <img src="{{ asset('images/naomichi.jpg') }}" alt="Naomichi Satake" class="team-image">
                    <h3 class="team-name">Naomichi Satake</h3>
                    <p class="team-role">Italian Classic Singer</p>
                </div>
            </div>
        </section>
    </main>
</body>

</html>
