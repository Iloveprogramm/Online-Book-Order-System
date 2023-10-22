<?php
ob_start();
session_start();

// Check if running in a command line interface (CLI) environment to disable redirection and layout when testing
if (php_sapi_name() === 'cli') {
    define('IS_TESTING', true);
} else {
    define('IS_TESTING', false);
}

function getDatabaseConnection() {
    include 'db_config.php';
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    return $conn;
}

function addEditHistory($conn, $bookID, $oldValue, $newValue) {
    $sql = "INSERT INTO book_edit_history (book_id, old_value, new_value) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $bookID, $oldValue, $newValue);
    $stmt->execute();
}

function editBook($conn, $bookData) {
    $bookID = $bookData["bookID"];
    $title = $bookData["title"];
    $author = $bookData["author"];
    $price = $bookData["price"];
    $category = $bookData["category"];
        
    // Prepare the SQL statement to update book details
    $sql = "UPDATE Books SET Title=?, Author=?, Price=?, Category=? WHERE BookID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdsi", $title, $author, $price, $category, $bookID);

    // Fetch old book data before updating
    $oldBookData = getBookDetails($conn, $bookID);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = 'Book details updated successfully!';
        $_SESSION['message_type'] = 'success';

        // Add edit history after book is successfully updated
        $newValue = json_encode([
            'Title' => $title,
            'Author' => $author,
            'Price' => $price,
            'Category' => $category
        ]);
        $oldValue = json_encode($oldBookData);
        addEditHistory($conn, $bookID, $oldValue, $newValue);

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

// Get details about a specific book
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