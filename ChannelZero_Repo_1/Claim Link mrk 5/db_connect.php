<?php
// Database configuration
$servername = "localhost";
$username = "root";       // Default for XAMPP/WAMP - change in production!
$password = "";           // Empty for XAMPP/WAMP - change in production!
$dbname = "channel_zero"; // Matches your database name

// Error reporting (only for development)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create connection with improved settings
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection with more detailed error handling
if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    die("Connection failed. Please try again later. Error code: DB_CONN_001");
}

// Set charset to utf8mb4 to fully support UTF-8 including emojis
$conn->set_charset("utf8mb4");

// Set timezone if your application needs it
$conn->query("SET time_zone = '+02:00'"); // Adjust for your timezone (SAST is +2:00)
?>