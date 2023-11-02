<?php
session_start();

header('Content-Type: application/json'); 

$servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bookonlineorder";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Connection failed: " . $conn->connect_error]);
    exit;
}

if (!isset($_SESSION['username'])) {
    echo json_encode(["success" => false, "error" => "Not logged in"]);
    exit;
}

if (empty($_POST['newPassword'])) {
    echo json_encode(["success" => false, "error" => "Password should not be empty"]);
    exit;
}

$newPassword = $_POST['newPassword'];
$user_id = $_SESSION['username'];

// HASH-NEWPASSWORD
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

// UPDATE NEWPASSWORD
$query = "UPDATE UserTable SET password = ? WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ss', $hashedPassword, $user_id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => true]);
        session_regenerate_id(true); // UPDATE SESSIONID
    } else {
        echo json_encode(["success" => false, "error" => "No changes made. Password might be the same as the old one."]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
