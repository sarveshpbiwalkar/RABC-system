<?php
// Database configuration
$host = 'localhost'; // Change if your database is hosted elsewhere
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password
$dbname = 'rbac_db'; // Replace with your database name

// Create a connection
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Optional: Set the character set to UTF-8
mysqli_set_charset($conn, 'utf8');

// Optional: Enable error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
?>