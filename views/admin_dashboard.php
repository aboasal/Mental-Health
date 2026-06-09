<?php
// views/admin_dashboard.php
require_once '../config/AuthManager.php';

// Only Super Admins and Clinic Managers can pass this line.
// Anyone else is instantly redirected away.
AuthManager::requireRole(['Super Admin', 'Clinic Manager']);

// If the script continues, it means they are authorized.
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Clinic Admin Dashboard</title>
</head>

<body>
    <h1>Welcome to the Clinic Manager Dashboard</h1>
</body>

</html>