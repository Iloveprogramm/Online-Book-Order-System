<?php
// clear_cart.php
header('Content-Type: application/json');

$servername = "localhost";
$username = "id21490898_uts";
$password = "Zcj030366*";
$dbname = "id21490898_onlinebookorder";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$cartId = $_COOKIE['cart_id'] ?? null;

if ($cartId) {
    $stmt = $conn->prepare("DELETE FROM cart WHERE cart_id = ?");
    $stmt->bind_param('s', $cartId);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No cart ID found']);
}
?>
