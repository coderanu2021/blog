<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');     // Default WAMP username
define('DB_PASS', '');         // Default WAMP password is empty
define('DB_NAME', 'blog_db');  // Your database name

// Create database connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to utf8
mysqli_set_charset($conn, "utf8");

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?> 