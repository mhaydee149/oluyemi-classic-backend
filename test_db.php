<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "oluyemi_classic"; // Make sure this matches your database name

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "✅ Database connected successfully!";
?>
