
<?php

error_reporting(0);
ini_set('display_errors', '0');

date_default_timezone_set('Asia/Kolkata');

// Database configuration from environment variables
$servername = getenv('DB_HOST') ?: 'localhost';
$username   = getenv('DB_USERNAME');
$password   = getenv('DB_PASSWORD');
$db         = getenv('DB_DATABASE') ?: 'aaganwadi_db';

// Connect using MySQLi
$conn = mysqli_connect(
    $servername,
    $username,
    $password,
    $db
);

if (!$conn) {
    error_log("Database connection failed: " . mysqli_connect_error());
    die("Database connection failed. Please contact administrator.");
}

mysqli_set_charset($conn, 'utf8mb4');

// Existing query function
function execute_query($query)
{
    global $conn;

    $result = mysqli_query($conn, $query);

    return $result;
}
?>
