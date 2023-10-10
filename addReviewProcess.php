<?php

include("dbConnection.php");

function addReviewToDatabase($data)
{
    $conn = getConnection();

    if ($conn->connect_error) {
        return json_encode(['status' => 'error', 'message' => "Connection failed: " . $conn->connect_error]);
    }

    $stmt = $conn->prepare("INSERT INTO Reviews (BookID, ReviewerName, Rating, ReviewText) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $bookID, $reviewerName, $rating, $reviewText);

    $bookID = $data['bookID'];
    $reviewerName = $data['reviewerName'];
    $rating = $data['rating'];
    $reviewText = $data['reviewText'];

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return json_encode(['status' => 'success', 'message' => 'Review added successfully!']);
    } else {
        return json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]);
    }
}

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    echo addReviewToDatabase($_POST);
}
?>
