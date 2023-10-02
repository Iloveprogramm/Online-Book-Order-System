<?php
// 连接到数据库
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookonlineorder";
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$bookId = $_GET['book_id'];
$cartId = $_COOKIE['cart_id'] ?? uniqid(); // 获取 cart_id，如果不存在，则创建一个新的

setcookie('cart_id', $cartId, time() + (86400 * 30), "/"); // 保存 cart_id 为一个 cookie

$sql = "INSERT INTO cart (cart_id, book_id, quantity) VALUES ('$cartId', $bookId, 1)
        ON DUPLICATE KEY UPDATE quantity = quantity + 1"; // 如果已存在，增加数量

if ($conn->query($sql) === TRUE) {
    echo "Book added to cart successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
