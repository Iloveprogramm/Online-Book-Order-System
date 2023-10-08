<?php
$servername = "127.0.0.1";
$username = "testuser";
$password = "TestPass123!"; // 使用新的密码
$dbname = "bookonlineorder";
$conn = new mysqli($servername, $username, $password, $dbname);

$bookId = $_GET['book_id'] ?? null;
$cartId = $_COOKIE['cart_id'] ?? null;

$response = array("status" => "failure");

if ($bookId && $cartId) {
    $sql = "DELETE FROM cart WHERE book_id = $bookId AND cart_id = '$cartId'";
    if($conn->query($sql)){
        $response["status"] = "success";
    }
}

echo json_encode($response);

$conn->close();
?>
