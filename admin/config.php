<?php
// Database connection configuration
// Use environment variables for Docker, fallback to defaults for local XAMPP
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: 'root';
$db_password = getenv('DB_PASSWORD') ?: '';
$db_name = getenv('DB_NAME') ?: 'portfolio';

// Database connection
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

// Database connection check
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
