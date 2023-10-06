<?php

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "bookonlineorder";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve book ID from POST request
if(isset($_POST['bookIdToDelete'])) {
    $bookId = $_POST['bookIdToDelete'];

    // Delete the book from the database
    $sql = "DELETE FROM Books WHERE BookID = ?";
    
    // Prepare statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $bookId);  // 'i' indicates that we're binding an integer
    
    if($stmt->execute()) {
        if (PHP_SAPI !== 'cli') {
            echo "Book deleted successfully!";
        }
    } else {
        if (PHP_SAPI !== 'cli') {
            echo "Error deleting book: " . $stmt->error;
        }
    }

    $stmt->close();
}

$conn->close();

// Redirect back to deleteBookList.php page
if (PHP_SAPI !== 'cli' && !defined('PHPUNIT_COMPOSER_INSTALL')) {
    header("Location: deleteBookList.php");
    exit();
}

?>
