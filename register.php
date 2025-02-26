<?php
include 'db.php';

// Enable CORS for API requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

// Handle preflight request for CORS
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(204);
    exit();
}

// Read JSON input from frontend
$data = json_decode(file_get_contents("php://input"), true);

// Validate input fields
if (!isset($data["name"], $data["email"], $data["password"])) {
    echo json_encode(["error" => "Invalid request. Please provide name, email, and password."]);
    exit();
}

$name = trim($data["name"]);
$email = trim($data["email"]);
$password = trim($data["password"]);

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["error" => "Invalid email format."]);
    exit();
}

// Check if email already exists
$checkEmail = $conn->prepare("SELECT id FROM users WHERE email = ?");
$checkEmail->bind_param("s", $email);
$checkEmail->execute();
$checkEmail->store_result();

if ($checkEmail->num_rows > 0) {
    $checkEmail->close();
    echo json_encode(["error" => "Email already registered."]);
    exit();
}
$checkEmail->close();

// Hash password for security
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Insert user into database
$sql = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$sql->bind_param("sss", $name, $email, $hashedPassword);

if ($sql->execute()) {
    echo json_encode(["success" => true, "message" => "Registration successful"]);
} else {
    echo json_encode(["error" => "Registration failed."]);
}

$sql->close();
$conn->close();
?>
