<?php
ob_start();
session_start();


if (php_sapi_name() === 'cli') {
    define('IS_TESTING', true);
} else {
    define('IS_TESTING', false);
}

function getDatabaseConnection() {
    include 'db_config.php';
}

function editBook($conn, $bookData) {
    $bookID = $bookData["bookID"];
    $title = $bookData["title"];
    $author = $bookData["author"];
    $price = $bookData["price"];
    $category = $bookData["category"];
        
    $sql = "UPDATE Books SET Title=?, Author=?, Price=?, Category=? WHERE BookID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdsi", $title, $author, $price, $category, $bookID);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = 'Book details updated successfully!';
        $_SESSION['message_type'] = 'success';
        if (!IS_TESTING) {
            header("Location: editBook.php");
            exit;
        }
    } else {
        $_SESSION['message'] = 'Error updating book: ' . $stmt->error;
        $_SESSION['message_type'] = 'error';
        if (!IS_TESTING) {
            header("Location: editSingleBook.php?bookID=" . $bookID);
            exit;
        }
    }
}

function getBookDetails($conn, $bookID) {
    $sql = "SELECT BookID, Title, Author, Price, Category FROM Books WHERE BookID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    
    return [];
}

$conn = getDatabaseConnection();

if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    editBook($conn, $_POST);
}

$row = [];  
if (isset($_GET["bookID"])) {
    $row = getBookDetails($conn, $_GET["bookID"]);
}

$conn->close();

if (!IS_TESTING) {
    include 'layout.php';
}
?>