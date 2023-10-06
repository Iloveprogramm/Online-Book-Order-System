<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bookonlineorder";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $cartItemsJson = isset($_POST['cartItems']) ? $_POST['cartItems'] : '';
    $cartItems = json_decode($cartItemsJson, true);
    if (!$cartItems) {
        $cartItems = [];
    }

    $totalAmount = isset($_POST['totalAmount']) ? $_POST['totalAmount'] : 0;

    $orderNumber = time();

    $itemsJson = json_encode($cartItems);

    $sql = "INSERT INTO Orders (orderNumber, items, totalAmount, orderDate) 
            VALUES ('$orderNumber', '$itemsJson', '$totalAmount', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "Order placed successfully. Your order number is: " . $orderNumber;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
