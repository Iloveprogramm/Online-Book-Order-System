<?php
require 'PHPMailer-master/src/PHPMailer.php';  // 请根据实际路径修改
require 'PHPMailer-master/src/SMTP.php';  // 请根据实际路径修改

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$paymentMethod = $_POST["payment-method"];
$cardNumber = $_POST["card_number"];
$expiry = $_POST["expiry"];
$cvc = $_POST["cvc"];
$email = isset($_POST["customerEmail"]) ? $_POST["customerEmail"] : null;

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
    $itemsHTML = isset($_POST["cartItemsHTML"]) ? $_POST["cartItemsHTML"] : null;
    $totalAmount = isset($_POST["totalAmount"]) ? $_POST["totalAmount"] : null;

    if (is_null($itemsHTML) || is_null($totalAmount)) {
        echo json_encode(['status' => 'error', 'message' => 'Essential data is missing. Please check your input and try again.']);
        exit;  
    }    

    $orderNumber = time() . rand(1000, 9999); 

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bookonlineorder";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]);
        exit;
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
            if($email && isset($_POST['notifyByEmail']) && $_POST['notifyByEmail'] === 'on') {
                $mail = new PHPMailer();

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'chenjunzhengjim@gmail.com';
                $mail->Password = 'dozw ccpk imie bmsu';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('chenjunzhengjim@gmail.com', 'Mailer'); 
                $mail->addAddress($email); 

                $mail->isHTML(true);
                $mail->Subject = 'Order Confirmation';
                // Fetch cart items and total amount from POST request
    $cartItemsHTML = isset($_POST['cartItemsHTML']) ? $_POST['cartItemsHTML'] : '';
    $totalAmount = isset($_POST['totalAmount']) ? $_POST['totalAmount'] : '0.00';

    // Construct mail body with cart items and total amount
    $mail->Body = '<h2>Order Confirmation</h2>'
                . '<p>Thank you for your order. Your order details are as follows:</p>'
                . '<h3>Order Number: ' . $orderNumber . '</h3>'
                . $cartItemsHTML
                . '<p><strong>Total Amount:</strong> $' . htmlspecialchars($totalAmount) . '</p>'
                . '<p>We will process your order soon. Thank you for shopping with us!</p>';


                if(!$mail->send()) {
                    echo json_encode(['status' => 'error', 'message' => 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo]);
                    exit;
                }
            }

            echo json_encode(['status' => 'success', 'orderNumber' => $orderNumber]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error in storing payment details: ' . $stmtPayment->error]);
        }
        
        $stmtPayment->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error in storing order: ' . $stmtOrder->error]);
    }

    $stmtOrder->close();
    $conn->close();
}
?>
