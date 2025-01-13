@extends('layouts.landing')

@section('title', 'About Us')

@section('content')

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            height: 100%;
            display: flex;
            flex-direction: column;
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
