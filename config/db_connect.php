<?php
// config/db_connect.php

class Database
{
    // This holds the single instance of the database connection
    private static ?PDO $connection = null;

    /**
     * Returns the active PDO connection, or creates one if it doesn't exist.
     */
    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            // In a real production environment, these should be loaded from a secure .env file
            $host = 'localhost';
            $dbName = 'wellness_portal';
            $username = 'root';
            $password = '';

            try {
                $dsn = "mysql:host={$host};dbname={$dbName};charset=utf8mb4";

                // Secure PDO options
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw exceptions on errors
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Return arrays, not both arrays and objects
                    PDO::ATTR_EMULATE_PREPARES   => false,                  // Use real prepared statements to prevent SQL injection
                ];

                self::$connection = new PDO($dsn, $username, $password, $options);
            } catch (PDOException $e) {
                // Log the error securely so users don't see database credentials on a crash
                error_log("Database Connection Failed: " . $e->getMessage());
                die("A critical system error occurred. Please try again later.");
            }
        }

        return self::$connection;
    }
}
