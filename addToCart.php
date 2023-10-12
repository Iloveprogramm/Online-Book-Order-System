<?php

function addToCart($bookId, $existingCartId = null, $setCookie = true) {

    include 'db_config.php';

    // Check if the database connection exists and is an object
    if (!$conn || !is_object($conn)) {
        return "Error: Unable to connect to the database.";
    }

   //Verify book ID
    if (!is_numeric($bookId) || $bookId <= 0) {
        return "Error: Invalid book ID.";
    }

    $cartId = $existingCartId ?? uniqid();

    if ($setCookie) {
        setcookie('cart_id', $cartId, time() + (86400 * 30), "/", "", false, true); // Added httponly parameter
    }

   // Use prepared statements and parameter binding to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO cart (cart_id, book_id, quantity) VALUES (?, ?, 1)
                            ON DUPLICATE KEY UPDATE quantity = quantity + 1");

    if ($stmt) {
        $stmt->bind_param("si", $cartId, $bookId);

        if ($stmt->execute()) {
            $stmt->close();  // After using prepared statements, the statement should be closed
            $conn->close();
            return "Book added to cart successfully";
        } else {
            $error = "Error: " . $stmt->error;
        }
    } else {
        $error = "Error: " . $conn->error;
    }

    $conn->close();
    return $error;
}

// Make sure it's a GET request and the book ID is set
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['book_id'])) {
    echo addToCart($_GET['book_id'], $_COOKIE['cart_id'] ?? null);
} else {
    echo "Error: Invalid request.";
}
