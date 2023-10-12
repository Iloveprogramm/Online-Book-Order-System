<?php

function addToCart($bookId, $existingCartId = null, $setCookie = true) {

    include 'db_config.php';
    
    $cartId = $existingCartId ?? uniqid(); 

    if ($setCookie) {
        setcookie('cart_id', $cartId, time() + (86400 * 30), "/"); 
    }

    $sql = "INSERT INTO cart (cart_id, book_id, quantity) VALUES ('$cartId', $bookId, 1)
            ON DUPLICATE KEY UPDATE quantity = quantity + 1"; 

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        return "Book added to cart successfully";
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
        $conn->close();
        return $error;
    }
}


if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
    echo addToCart($_GET['book_id'], $_COOKIE['cart_id'] ?? null);
}