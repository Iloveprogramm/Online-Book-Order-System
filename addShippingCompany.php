<?php
session_start();

$servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bookonlineorder";
// Create a database connection
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


if (isset($_POST["CompanyName"])) {
    $company_name = urldecode($_POST["CompanyName"]);
    $cost_per_kilo = urldecode($_POST["CostPerKilo"]);
    $phone_number = urldecode($_POST["PhoneNumber"]);
    $email_address = urldecode($_POST["EmailAddress"]);
    $average_shipping_time = urldecode($_POST["AverageShippingTime"]);
    $date_added = date("Y-m-d");
    
    $sql = "INSERT INTO shipping_companies (company_name, date_added, cost_per_Kilo, phone_number, email_address, average_shipping_time) VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $company_name, $date_added, $cost_per_kilo, $phone_number, $email_address, $average_shipping_time);
    
    if ($stmt->execute()) {
        echo json_encode(array("status" => "success", "message" => "company added successfully."));
    } else {
        echo json_encode(array("status" => "error", "message" => "Error adding shipping company: " . $stmt->error));
    }
    
    $stmt->close();
} else {
    echo json_encode(array("status" => "error", "message" => "Invalid shipping company data."));
}

$conn->close();
?>