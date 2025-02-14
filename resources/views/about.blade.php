@extends('layouts.landing')

@section('title', 'About Us')

@section('content')

<style>
html, body {
    overflow-x: hidden;
    height: 100%;
}


.about-page {
    position: relative; /* 固定から相対位置に変更 */
    width: 100vw;
    min-height: 100vh; /* 最低限の高さを確保 */
    overflow-y: auto; /* 縦方向のスクロールを許可 */
}

@media (max-height: 600px) {
    /* 縦がつぶれたときにスクロールできるように */
    .about-page {
        overflow-y: auto !important;
    }
}


@media (max-width: 768px) {
    /* すべての要素のスタイルを完全にリセット */
    * {
        all: revert;  /* ブラウザのデフォルトスタイルに戻す */
    }

    /* body に最低限のデフォルト設定を適用 */
    body {
        background: rgb(32, 200, 24);
        color: black !important;
        font-family: Arial, sans-serif !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    /* すべてのレイアウト要素を非表示 */
    .about-page, .about-content-wrapper, .about-description, .features-list, .about-image-section {
        display: block !important;
        width: 100% !important;
        max-width: none !important;
        height: auto !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    /* 画像もリセット */
    img {
        max-width: 100% !important;
        height: auto !important;
        margin: 2px !important;
    }

    br{
        margin:0% !important;
    }

    h2 {
        font-size: 20px !important;
    }

    .material-symbols-outlined{
        font-size: 35px !important;
    }

    span {
        font-size: 20px;
    }

    .team-button{
        margin-top: 2px !important;
        font-size: 5px !important;
        text-align: center !important;

    }


}








</style>


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
                <a href="{{route('team')}}" class="team-button">OUR TEAM</a>
            </div>

            <!-- Right Section -->
            <div class="about-image-section">
                <img src="{{ asset('images/our_team.jpg') }}" alt="Our Team">
            </div>
        </div>
    </div>

    <style>
        .back-button-container {
            margin-top: 20px;
            margin-left: 20px;

        }
        .back-button {
            background-color: transparent;
            color: white;
            font-weight: bold;
            border: none;
            padding: 10px 10px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        .back-button:hover {
            background-color: #008000;
        }
    </style>
