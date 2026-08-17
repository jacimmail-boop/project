<?php
/**
 * config.php
 * Database connection settings for the EWU Lost & Found Portal.
 * Adjust these values to match your local XAMPP / MySQL setup.
 */

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');          // default XAMPP MySQL password is empty
define('DB_NAME', 'ewu_lost_found');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

// Start the session on every page that includes this file
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
