<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookonlineorder";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => "Connection failed: " . $conn->connect_error]));
}

// Prepare statement to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO Books (Title, Author, Price, ImageURL, Category) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $bookTitle, $bookAuthor, $bookPrice, $bookImgUrl, $bookCategory);

// Grab the POST data from the form submission
$bookTitle = $_POST['bookTitle'];
$bookAuthor = $_POST['bookAuthor'];
$bookPrice = $_POST['bookPrice'];
$bookImgUrl = $_POST['bookImgUrl'];
$bookCategory = $_POST['bookCategory'];

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Book added successfully!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
