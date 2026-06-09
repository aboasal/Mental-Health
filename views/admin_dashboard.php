<?php
// views/admin_dashboard.php
require_once 'config/AuthManager.php';

AuthManager::requireRole(['Super Admin', 'Clinic Manager']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Operations - Wellness Portal</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>

    <nav class="navbar">
        <h2 style="margin: 0; color: #333;">Admin Operations</h2>
        <a href="/logout" style="text-decoration: none; color: #d9534f; font-weight: bold;">Logout</a>
    </nav>

    <div class="container">
        <h1>System Safety & Performance</h1>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">

            <div class="card" style="background-color: #fff3f3; border: 1px solid #d9534f;">
                <h3 style="color: #d9534f;">⚠️ Active Crisis Alerts</h3>
                <ul style="list-style-type: none; padding: 0;">
                    <li style="padding: 10px; background: white; margin-bottom: 10px; border-radius: 4px;">
                        <strong>Trigger Word:</strong> "hopeless" <br>
                        <strong>Source:</strong> Community Forum <br>
                        <strong>Time:</strong> 5 mins ago <br>
                        <a href="#" style="color: #d9534f; font-weight: bold;">Review Audit Log</a>
                    </li>
                </ul>
            </div>

            <div class="card">
                <h3>Platform Health</h3>
                <p><strong>Active Sessions:</strong> 14</p>
                <p><strong>Therapists Online:</strong> 8</p>
                <p><strong>Database Status:</strong> Connected</p>
                <button style="background-color: #333;">View Full Analytics</button>
            </div>

        </div>
    </div>

</body>

</html>