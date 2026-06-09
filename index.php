<?php
// index.php

require_once 'config/db_connect.php';
require_once 'config/AuthManager.php';

// Always start the secure session so we know who is browsing
AuthManager::startSession();

// Parse the requested URL to figure out where they want to go
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// The Routing Switchboard
switch ($requestUri) {
    case '/':
    case '/login':
        // If they are already logged in, don't show the login page; send them to their dashboard
        if (AuthManager::getCurrentUserId()) {
            routeUserToDashboard(AuthManager::getCurrentRole());
        } else {
            require 'views/login.php'; // You will build this HTML file later
        }
        break;

    case '/dashboard/admin':
        require 'views/admin_dashboard.php';
        break;

    case '/dashboard/therapist':
        require 'views/therapist_dashboard.php';
        break;

    case '/dashboard/patient':
        require 'views/patient_dashboard.php';
        break;

    case '/logout':
        AuthManager::logout();
        break;

    default:
        // If the URL doesn't match anything above, show a 404 error
        http_response_code(404);
        echo "<h1>404 - Page Not Found</h1>";
        break;
}

/**
 * A helper function to automatically route users to the correct dashboard based on their RBAC role.
 */
function routeUserToDashboard(?string $role): void
{
    switch ($role) {
        case 'Super Admin':
        case 'Clinic Manager':
            header("Location: /dashboard/admin");
            exit();
        case 'Therapist':
            header("Location: /dashboard/therapist");
            exit();
        case 'Patient':
            header("Location: /dashboard/patient");
            exit();
        default:
            header("Location: /login");
            exit();
    }
}
