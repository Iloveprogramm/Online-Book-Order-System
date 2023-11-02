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

// Check if the book_id is provided in the URL
if (isset($_GET["book_id"])) {
    $book_id = $_GET["book_id"];
} else {
    echo "Book ID not provided.";
    exit();
}

// Get the current date
$date_added = date("Y-m-d");

// Get the user id
if (isset($_SESSION['username'])) {
    $user_username = $_SESSION['username'];
} else {
    echo "User not logged in.";
    exit();
}

// Fetch the user's ID from the usertable based on the user_id
$sql = "SELECT ID FROM usertable WHERE user_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "Error preparing statement: " . $conn->error;
    exit();
}

$stmt->bind_param("s", $user_username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($user_id);
    $stmt->fetch();

    // Check if the same book is already wishlisted by the same user
    $check_sql = "SELECT * FROM Wishlist WHERE user_id = ? AND book_id = ?";
    $check_stmt = $conn->prepare($check_sql);

    if (!$check_stmt) {
        echo "Error preparing check statement: " . $conn->error;
        exit();
    }

    $check_stmt->bind_param("ii", $user_id, $book_id);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows == 0) {
        $insert_sql = "INSERT INTO Wishlist (user_id, book_id, date_added) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
    
        if (!$stmt) {
            echo "Error preparing insert statement: " . $conn->error;
            exit();
        }
    
        $stmt->bind_param("iis", $user_id, $book_id, $date_added);
        if ($stmt->execute()) {
            $response = array("status" => "success", "message" => "Book added to your wishlist successfully.");
        } else {
            $response = array("status" => "error", "message" => "Error adding book to your wishlist: " . $conn->error);
        }
    } else {
        $response = array("status" => "info", "message" => "This book is already in your wishlist.");
    }
    
    echo json_encode($response);
}

$stmt->close();
$conn->close();
?>