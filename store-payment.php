<?php
    function storePaymentData($paymentMethod, $cardNumber, $expiry, $cvc, $itemsHTML, $totalAmount) {
        if(!preg_match("/^(0[1-9]|1[0-2])\/([0-9]{2})$/", $expiry)) {
            return "Invalid expiry format. Please use MM/YY.";
        }

        if(strlen($cvc) !== 3 || !ctype_digit($cvc)) {
            return "Invalid CVC. It must be a 3-digit number.";
        }

        $orderNumber = time() . rand(1000, 9999);  // Generates a numeric order number

        $servername = "127.0.0.1";
$username = "testuser";
$password = "TestPass123!"; 
$dbname = "bookonlineorder";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            return "Connection failed: " . $conn->connect_error;
        }

        $sqlOrder = "INSERT INTO Orders (orderNumber, items, totalAmount) VALUES (?, ?, ?)";
        $stmtOrder = $conn->prepare($sqlOrder);
        $stmtOrder->bind_param("ssd", $orderNumber, $itemsHTML, $totalAmount);

        if ($stmtOrder->execute()) {
            $orderID = $conn->insert_id;

            $sqlPayment = "INSERT INTO payment_details (order_id, card_number, expiry, cvc) VALUES (?, ?, ?, ?)";
            $stmtPayment = $conn->prepare($sqlPayment);
            $stmtPayment->bind_param("isss", $orderID, $cardNumber, $expiry, $cvc);

            if ($stmtPayment->execute()) {
                $stmtPayment->close();
                return "Order and payment details stored successfully!";
            } else {
                return "Error in storing payment details: " . $stmtPayment->error;
            }
        } else {
            return "Error in storing order: " . $stmtOrder->error;
        }
    }

    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $itemsHTML = $_POST["cartItemsHTML"];
        $totalAmount = $_POST["totalAmount"];
        echo storePaymentData($_POST["payment-method"], $_POST["card_number"], $_POST["expiry"], $_POST["cvc"], $itemsHTML, $totalAmount);
    }
?>
