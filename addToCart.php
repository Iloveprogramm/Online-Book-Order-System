<?php

function addToCart($bookId, $existingCartId = null, $setCookie = true) {
    // 连接到数据库
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "bookonlineorder";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 检查连接
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $cartId = $existingCartId ?? uniqid(); // 获取 cart_id，如果不存在，则创建一个新的

    if ($setCookie) {
        setcookie('cart_id', $cartId, time() + (86400 * 30), "/"); 
    }

    $sql = "INSERT INTO cart (cart_id, book_id, quantity) VALUES ('$cartId', $bookId, 1)
            ON DUPLICATE KEY UPDATE quantity = quantity + 1"; // 如果已存在，增加数量

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        return "Book added to cart successfully";
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
        $conn->close();
        return $error;
    }
}

// 调用函数
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
    echo addToCart($_GET['book_id'], $_COOKIE['cart_id'] ?? null);
}
