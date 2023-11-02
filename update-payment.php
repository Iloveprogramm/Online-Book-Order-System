<?php
session_start();
header('Content-Type: application/json');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo json_encode(["success" => false, "error" => "User not logged in."]);
    exit;
}

// Database configuration
$servername = "localhost";
$dbUsername = "root";
$dbPassword = ""; 
$dbname = "bookonlineorder";

// Retrieve POST data
$user_id = $_SESSION['username']; 
$card_number = $_POST['card_number'] ?? '';
$expiry = $_POST['expiry'] ?? '';
$cvc = $_POST['cvc'] ?? '';

// Create database connection
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Connection failed: " . $conn->connect_error]);
    exit;
}

try {
    // Prepare the SQL statement
    $query = "UPDATE payment_details SET card_number=?, expiry=?, cvc=? WHERE user_id=?";
    $stmt = $conn->prepare($query);
    // Bind parameters to the prepared statement
    $stmt->bind_param("ssss", $card_number, $expiry, $cvc, $user_id);
    $stmt->execute();

    // Check if any rows were updated
    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => true]);
    } else {
        // If no rows were updated, it could be because the data is the same as what's already in the database
        // Or it could mean that the user does not exist
        echo json_encode(["success" => false, "error" => "No update occurred. Data may already be up to date or user/payment details may not exist."]);
    }
} catch (mysqli_sql_exception $e) {
    // If there's a MySQL error, return that as JSON
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
} finally {
    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}
?>