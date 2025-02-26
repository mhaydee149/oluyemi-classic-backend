<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection details
$host = "sql101.infinityfree.com"; // Replace with your InfinityFree DB host
$username = "if0_38372605"; // Replace with your DB username
$password = "BuxvCs7zxO"; // Replace with your DB password
$database = "if0_38372605_oluyemi_classic"; // Replace with your DB name

// Establish connection
$conn = new mysqli($host, $username, $password, $database);

// Check if connection was successful
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}
?>
