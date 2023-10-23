<?php

function addBookToDatabase($data)
{
    include 'db_config.php';

    $stmt = $conn->prepare("INSERT INTO Books (Title, Author, Price, ImageURL, Category, Description) VALUES (?, ?, ?, ?, ?, ?)");

    // Bind parameters to prepared statements
    $stmt->bind_param("ssssss", $bookTitle, $bookAuthor, $bookPrice, $bookImgUrl, $bookCategory, $bookDescription);

    //Extract book information from the passed data array
    $bookTitle = $data['bookTitle'];
    $bookAuthor = $data['bookAuthor'];
    $bookPrice = $data['bookPrice'];
    $bookImgUrl = $data['bookImgUrl'];
    $bookCategory = $data['bookCategory'];
    $bookDescription = $data['bookDescription'];  

    // If the prepared statement is executed successfully
    //close the statement and connection and return a successful JSON response.
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return json_encode(['status' => 'success', 'message' => 'Book added successfully!']);
    } else {
        return json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]);
    }
}

// Check whether the POST request was received
if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
    header('Content-Type: application/json');
    echo addBookToDatabase($_POST);
}
?>
