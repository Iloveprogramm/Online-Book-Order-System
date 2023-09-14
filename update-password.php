<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookonlineorder";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['username'])) {
    echo 'Not logged in';
    exit;
}

if (empty($_POST['newPassword'])) {
    echo 'Password should not be empty';
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
        echo 'success';
        session_regenerate_id(true);  // UPDATE SESSIONID
    } else {
        echo 'fail';
    }
} else {
    echo 'Error: ' . $stmt->error;
}

$stmt->close();
$conn->close();
?>