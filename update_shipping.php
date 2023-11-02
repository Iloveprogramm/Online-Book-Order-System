<?php
session_start();

$servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bookonlineorder";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['username'])) {
    $user_id = $_SESSION['username'];
} else {
    echo json_encode(array("status" => "error", "message" => "User not logged in."));
    exit();
}


if (isset($_POST["shipping_address"])) {
    $shipping_Address = explode(", ", urldecode($_POST["shipping_address"]));
    $country = $shipping_Address[0];
    $city = $shipping_Address[1];
    $postcode = $shipping_Address[2];
    $street_address = $shipping_Address[3];
    
    $sql = "INSERT INTO shipment (user_id, country, city, postcode, street_address) VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $user_id, $country, $city, $postcode, $street_address);
    
    if ($stmt->execute()) {
        echo json_encode(array("status" => "success", "message" => "Shipping address updated successfully."));
    } else {
        echo json_encode(array("status" => "error", "message" => "Error updating shipping address: " . $stmt->error));
    }
    
    $stmt->close();
} else {
    echo json_encode(array("status" => "error", "message" => "Invalid shipping address data."));
}

$conn->close();
?>
