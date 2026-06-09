<?php
// views/therapist_dashboard.php
require_once '../config/AuthManager.php';

// Strict single-role requirement
AuthManager::requireRole(['Therapist']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Therapist Portal</title>
</head>

<body>
    <h1>Therapist Portal</h1>
    <p>View your upcoming sessions and patient mood trends here.</p>
</body>

</html>