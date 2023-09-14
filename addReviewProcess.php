<?php
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
$stmt = $conn->prepare("INSERT INTO Reviews (BookID, ReviewerName, Rating, ReviewText) VALUES (?, ?, ?, ?)");
$stmt->bind_param("issi", $bookID, $reviewerName, $rating, $reviewText);

// Grab the POST data from the review form submission
$bookID = $_POST['bookID']; // TODO: Need to get book ID from title instead of using ID
$reviewerName = $_POST['reviewerName'];
$rating = $_POST['rating'];
$reviewText = $_POST['reviewText'];

$stmt->close();
$conn->close();
?>
