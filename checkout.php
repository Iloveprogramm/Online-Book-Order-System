<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //conect to database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bookonlineorder";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the shopping cart item data in the POST request
    $cartItemsJson = isset($_POST['cartItems']) ? $_POST['cartItems'] : '';

    // Decode shopping cart item data in JSON format
    $cartItems = json_decode($cartItemsJson, true);
    if (!$cartItems) {
        $cartItems = [];
    }

    // Get the total amount in the POST request
    $totalAmount = isset($_POST['totalAmount']) ? $_POST['totalAmount'] : 0;

    // Use the current timestamp as the order number
    $orderNumber = time();

    $itemsJson = json_encode($cartItems);

    //insert data into orders
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