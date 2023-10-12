<?php
$servername = "127.0.0.1";
$username = "testuser";
$password = "TestPass123!"; 
$dbname = "bookonlineorder";
$conn = new mysqli($servername, $username, $password, $dbname);

$bookId = $_POST['book_id'] ?? null;
$quantity = $_POST['quantity'] ?? null;
$cartId = $_COOKIE['cart_id'] ?? null;

$response = array("status" => "failure");

if ($bookId && $quantity && $cartId) {
     // Preparing and executing the SQL statement to update the cart
    $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE book_id = ? AND cart_id = ?");
    $stmt->bind_param("iis", $quantity, $bookId, $cartId);
    if ($stmt->execute()) {
        $response["status"] = "success";
    }
    $stmt->close();
}

echo json_encode($response);

$conn->close();
?>
