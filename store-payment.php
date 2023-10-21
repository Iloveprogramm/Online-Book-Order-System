<?php
$paymentMethod = $_POST["payment-method"];
$cardNumber = $_POST["card_number"];
$expiry = $_POST["expiry"];
$cvc = $_POST["cvc"];

// Validate expiry
if(!preg_match("/^(0[1-9]|1[0-2])\/([0-9]{2})$/", $expiry)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid expiry format. Please use MM/YY.']);
    exit;
}

// Validate cvc
if(strlen($cvc) !== 3 || !ctype_digit($cvc)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid CVC. It must be a 3-digit number.']);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve payment data from the form
    $itemsHTML = isset($_POST["cartItemsHTML"]) ? $_POST["cartItemsHTML"] : null;
    $totalAmount = isset($_POST["totalAmount"]) ? $_POST["totalAmount"] : null;

    if (is_null($itemsHTML) || is_null($totalAmount)) {
        echo json_encode(['status' => 'error', 'message' => 'Essential data is missing. Please check your input and try again.']);
        exit;  
    }    

    $orderNumber = time() . rand(1000, 9999);  // Generates a numeric order number

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bookonlineorder";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]);
        exit;
    }

    // Insert into Orders table first
    $sqlOrder = "INSERT INTO Orders (orderNumber, items, totalAmount) VALUES (?, ?, ?)";
    $stmtOrder = $conn->prepare($sqlOrder);
    $stmtOrder->bind_param("ssd", $orderNumber, $itemsHTML, $totalAmount);

    if ($stmtOrder->execute()) {
        $orderID = $conn->insert_id;  // Get the ID of the newly created order

        // Insert into payment_details table
        $sqlPayment = "INSERT INTO payment_details (order_id, card_number, expiry, cvc) VALUES (?, ?, ?, ?)";
        $stmtPayment = $conn->prepare($sqlPayment);
        $stmtPayment->bind_param("isss", $orderID, $cardNumber, $expiry, $cvc);

        if ($stmtPayment->execute()) {
            // Payment details were successfully stored
            echo json_encode(['status' => 'success', 'orderNumber' => $orderNumber]);
        } else {
            // Error occurred while storing payment details
            echo json_encode(['status' => 'error', 'message' => 'Error in storing payment details: ' . $stmtPayment->error]);
        }
        
        $stmtPayment->close();

    } else {
        // Error occurred while storing order
        echo json_encode(['status' => 'error', 'message' => 'Error in storing order: ' . $stmtOrder->error]);
    }

    // Close the database connection and the order statement
    $stmtOrder->close();
    $conn->close();
}
?>
