<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight request
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(204); // No Content
    exit();
}

header("Content-Type: application/json");

error_reporting(E_ALL);
ini_set("display_errors", 1);

$conn = new mysqli("localhost", "root", "", "oluyemi_classic");

if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

if (!isset($data["email"]) || !isset($data["password"])) {
    echo json_encode(["error" => "Email and password are required"]);
    exit();
}

$email = $conn->real_escape_string($data["email"]);
$password = $data["password"];

$sql = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

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
