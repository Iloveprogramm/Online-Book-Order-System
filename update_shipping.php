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

if (isset($_SESSION['username'])) {
    $user_id = $_SESSION['username'];
} else {
    echo "User not logged in.";
    exit();
}

if (isset($_GET["shipping_address"])) {
    $shipping_Address = $_GET["shipping_address"];
    
    $sql = "UPDATE usertable SET shipping_address = ? WHERE user_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $shipping_Address, $user_id);
    
    if ($stmt->execute()) {
        // Update successful
        echo json_encode(array("status" => "success", "message" => "Shipping address updated successfully."));
    } else {
        // Error handling
        echo json_encode(array("status" => "error", "message" => "Error updating shipping address: " . $stmt->error));
    }
    
    $stmt->close();
} else {
    // Handle missing or invalid shipping address
    echo json_encode(array("status" => "error", "message" => "Invalid shipping address data."));
}

$conn->close();
?>