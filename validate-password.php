<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo 'Not logged in';
    exit;
}

$servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bookonlineorder";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$oldPassword = $_POST['oldPassword'];
$user_id = $_SESSION['username']; 

$query = "SELECT password FROM UserTable WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // CHECK PASSWORD
    $row = $result->fetch_assoc();
    if (password_verify($oldPassword, $row['password'])) {
        echo 'success';
    } else {
        echo 'fail';
    }
} else {
    echo 'No such user';
}

$stmt->close();
$conn->close();
?>