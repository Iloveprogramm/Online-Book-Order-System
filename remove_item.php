<?php
include 'db_config.php';

$bookId = $_GET['book_id'] ?? null;
$cartId = $_COOKIE['cart_id'] ?? null;

$response = array("status" => "failure");

if ($bookId && $cartId) 
{
     // Deleting the book from the cart based on both book and cart IDs
    $sql = "DELETE FROM cart WHERE book_id = $bookId AND cart_id = '$cartId'";
    if($conn->query($sql)){
        $response["status"] = "success";
    }
}

// Sending the response back as JSON
echo json_encode($response);

$conn->close();
?>
