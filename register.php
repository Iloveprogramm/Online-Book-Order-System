<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookonlineorder";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_POST["username"];
$raw_password = $_POST["password"];

// Check if the password is at least 3 characters long
if (strlen($raw_password) < 3) {
    echo json_encode([
        "status" => "error",
        "message" => "Password must be at least 3 characters long."
    ]);
    exit;
}

$password = password_hash($raw_password, PASSWORD_DEFAULT);

// Prepare an SQL statement for inserting a new user into the UserTable
$stmt = $conn->prepare("INSERT INTO UserTable (user_id, password) VALUES (?, ?)");
// Bind the username and password variables to the SQL statement
$stmt->bind_param("ss", $user_id, $password);

if ($stmt->execute() === TRUE) {
    echo json_encode([
        "status" => "success",
        "message" => "Registration successful."
    ]);
    exit;
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Error: " . $stmt->error
    ]);
    exit;
}

$stmt->close();
$conn->close();
?>
