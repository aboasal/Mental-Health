<?php
// views/patient_dashboard.php
require_once 'config/AuthManager.php';

// Strict RBAC Gatekeeper
AuthManager::requireRole(['Patient']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard - Wellness Portal</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>

    <nav class="navbar">
        <h2 style="margin: 0; color: var(--primary-color);">Wellness Portal</h2>
        <a href="/logout" style="text-decoration: none; color: #d9534f; font-weight: bold;">Logout</a>
    </nav>

    <div class="container">
        <h1>Hello, Welcome to your safe space.</h1>

        <!-- Dashboard Grid Layout -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">

            <!-- Session Status Card -->
            <div class="card">
                <h3>Upcoming Sessions</h3>
                <p><strong>Next Appointment:</strong> Thursday at 3:00 PM</p>
                <p><strong>Therapist:</strong> Dr. Sarah Jenkins</p>
                <button style="width: auto; padding: 8px 16px;">Join Waiting Room</button>
            </div>

            <!-- Mood Tracker Card -->
            <div class="card">
                <h3>Daily Check-in</h3>
                <p>How are you feeling today?</p>
                <form action="/log-mood" method="POST">
                    <select name="mood_score">
                        <option value="10">10 - Excellent</option>
                        <option value="7">7 - Good</option>
                        <option value="5">5 - Okay</option>
                        <option value="3">3 - Struggling</option>
                        <option value="1">1 - In Crisis</option>
                    </select>
                    <button type="submit">Log Mood</button>
                </form>
            </div>

        </div>
    </div>

</body>

</html>