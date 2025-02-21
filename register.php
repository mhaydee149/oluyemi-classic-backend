<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Allow frontend to communicate with backend
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$conn = new mysqli("localhost", "root", "", "oluyemi_classic");

if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

if (!$data) {
    die(json_encode(["error" => "Invalid JSON received"]));
}

if (!isset($data["name"]) || !isset($data["email"]) || !isset($data["password"])) {
    die(json_encode(["error" => "Missing required fields"]));
}

$name = $conn->real_escape_string($data["name"]);
$email = $conn->real_escape_string($data["email"]);
$password = password_hash($data["password"], PASSWORD_BCRYPT);

$sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
if ($conn->query($sql)) {
    echo json_encode(["success" => true, "message" => "Registration successful"]);
} else {
    echo json_encode(["error" => "SQL Error: " . $conn->error]);
}

$conn->close();
?>
