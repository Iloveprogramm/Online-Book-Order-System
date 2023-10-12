<?php

function addToCart($bookId, $existingCartId = null, $setCookie = true) {

    include 'db_config.php';
    
    // If there is already a shopping cart ID, use it, otherwise generate a unique ID as the shopping cart ID
    $cartId = $existingCartId ?? uniqid(); 

    // If $setCookie is true, store the cart ID in a cookie for future requests
    if ($setCookie) {
        setcookie('cart_id', $cartId, time() + (86400 * 30), "/"); 
    }

    // Prepare SQL statement. 
    //If the book is already in the shopping cart, add one to the quantity, otherwise add the book to the shopping cart
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

// Check whether a GET request has been received, if so, call the addToCart function
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
    echo addToCart($_GET['book_id'], $_COOKIE['cart_id'] ?? null);
}