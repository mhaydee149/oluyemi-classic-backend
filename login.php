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
if (!isset($data["email"]) || !isset($data["password"])) {
    echo json_encode(["error" => "Invalid request. Please provide email and password."]);
    exit();
}

$email = trim($data["email"]);
$password = $data["password"];

// Fetch user from database
$sql = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
$sql->bind_param("s", $email);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Verify password
    if (password_verify($password, $user["password"])) {
        echo json_encode([
            "success" => true,
            "message" => "Login successful",
            "user" => [
                "id" => $user["id"],
                "name" => $user["name"],
                "email" => $user["email"]
            ]
        ]);
    } else {
        echo json_encode(["error" => "Invalid email or password"]);
    }
} else {
    echo json_encode(["error" => "User not found"]);
}

$conn->close();
?>
