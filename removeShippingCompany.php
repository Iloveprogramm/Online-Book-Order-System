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

// Check if the company id is provided in the URL
if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    echo "ID not provided.";
    exit();
}

// Check if the Shipping company is registerd in the database
$check_sql = "SELECT * FROM shipping_companies WHERE id = ?";
$check_stmt = $conn->prepare($check_sql);

if (!$check_stmt) {
    echo "Error preparing check statement: " . $conn->error;
    exit();
}

$check_stmt->bind_param("i", $id);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows != 0) 
{
    $delete_sql = "DELETE FROM shipping_companies WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);

    if (!$stmt) 
    {
        echo "Error preparing Delete statement: " . $conn->error;
        exit();
    }

    $stmt->bind_param("i", $id);
    if ($stmt->execute()) 
    {
        $response = array("status" => "success", "message" => "Company successfully Removed from the Database.");
    } 
        else 
    {
        $response = array("status" => "error", "message" => "Error Removing Company from the Database: " . $conn->error);
    }
} 
else 
{
    $response = array("status" => "info", "message" => "This compnay is not registerd in the database.");
}

echo json_encode($response);

$stmt->close();
$conn->close();
?>