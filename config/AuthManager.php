<?php
// config/AuthManager.php

class AuthManager
{

    /**
     * Initializes the secure session. 
     * Must be called before any HTML is output.
     */
    public static function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            // Secure session settings to prevent hijacking
            ini_set('session.cookie_httponly', 1);
            ini_set('session.use_only_cookies', 1);
            ini_set('session.cookie_secure', 1); // Set to 1 if using HTTPS
            session_start();
        }
    }

    /**
     * Logs a user in by storing their credentials in the session.
     */
    public static function loginUser(int $userId, string $role): void
    {
        self::startSession();
        // Regenerate ID to prevent session fixation attacks
        session_regenerate_id(true);

        $_SESSION['user_id'] = $userId;
        $_SESSION['role'] = $role;
    }

    /**
     * Destroys the session and logs the user out.
     */
    public static function logout(): void
    {
        self::startSession();
        session_unset();
        session_destroy();
        header("Location: /login.php");
        exit();
    }

    /**
     * The core RBAC gatekeeper. Checks if the current user has permission.
     * If not, it redirects them to a safe page or shows an error.
     */
    public static function requireRole(array $allowedRoles): void
    {
        self::startSession();

        // 1. Check if they are logged in at all
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
            header("Location: /login.php");
            exit();
        }

        // 2. Check if their assigned role is in the allowed list
        if (!in_array($_SESSION['role'], $allowedRoles)) {
            // Unauthorized access attempt
            error_log("Unauthorized access attempt by User ID " . $_SESSION['user_id']);

            // Redirect to a default safe page (or show a 403 Forbidden page)
            header("Location: /unauthorized.php");
            exit();
        }
    }

    public static function getCurrentUserId(): ?int
    {
        self::startSession();
        return $_SESSION['user_id'] ?? null;
    }

    public static function getCurrentRole(): ?string
    {
        self::startSession();
        return $_SESSION['role'] ?? null;
    }
}
