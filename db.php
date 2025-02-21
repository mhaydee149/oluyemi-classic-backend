<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$user = "root";  
$pass = "";  
$dbname = "oluyemi_classic";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
} else {
    echo json_encode(["message" => "Database connected successfully!"]);
}
?>
