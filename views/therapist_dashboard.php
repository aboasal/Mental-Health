<?php
// views/therapist_dashboard.php
require_once 'config/AuthManager.php';

// Strict RBAC Gatekeeper
AuthManager::requireRole(['Therapist']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provider Portal - Wellness Portal</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>

    <nav class="navbar">
        <h2 style="margin: 0; color: var(--primary-color);">Provider Portal</h2>
        <div>
            <span style="margin-right: 15px;">Welcome, Dr. <?php echo htmlspecialchars(AuthManager::getCurrentUserId()); /* Placeholder for name */ ?></span>
            <a href="/logout" style="text-decoration: none; color: #d9534f; font-weight: bold;">Logout</a>
        </div>
    </nav>

    <div class="container">
        <h1>Clinical Overview</h1>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-top: 20px;">

            <div class="card">
                <h3>Today's Schedule</h3>
                <table style="width: 100%; text-align: left; border-collapse: collapse;">
                    <tr style="border-bottom: 1px solid #eee;">
                        <th style="padding: 10px 0;">Time</th>
                        <th>Patient</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0;">2:00 PM</td>
                        <td>ResilientOak402</td>
                        <td style="color: #f0ad4e;">Checked-In</td>
                        <td><button style="padding: 5px 10px; width: auto;">Start Session</button></td>
                    </tr>
                </table>
            </div>

            <div class="card" style="border-left: 4px solid #d9534f;">
                <h3 style="color: #d9534f;">Mood Alerts</h3>
                <p><strong>CalmRiver119:</strong> Logged a mood score of 2/10 today.</p>
                <button style="background-color: #d9534f; padding: 8px;">Review Journal</button>
            </div>

        </div>
    </div>

</body>

</html>