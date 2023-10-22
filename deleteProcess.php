<?php
include 'db_config.php';

// Delete single book
if (isset($_POST['bookIdToDelete'])) {
    $bookId = $_POST['bookIdToDelete'];

    $sql = "DELETE FROM Books WHERE BookID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $bookId);

    try {
        if ($stmt->execute()) {
            $_SESSION['message'] = "Book deleted successfully!";
            $_SESSION['msg_type'] = "success";
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1451) { // 1451 is the error code for foreign key constraint fails
            $_SESSION['message'] = "The book cannot be deleted because the shopping cart has already been added. The shopping cart needs to be emptied before it can be。";
        } else {
            $_SESSION['message'] = "Error deleting book: " . $e->getMessage();
        }
        $_SESSION['msg_type'] = "error";
    }

    $stmt->close();
}

// Delete multiple books
if (isset($_POST['booksToDelete'])) {
    $bookIds = $_POST['booksToDelete'];
    $placeHolders = implode(',', array_fill(0, count($bookIds), '?'));
    $types = str_repeat('i', count($bookIds));

    $sql = "DELETE FROM Books WHERE BookID IN ($placeHolders)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$bookIds);

    try {
        if ($stmt->execute()) {
            $_SESSION['message'] = count($bookIds) . " books deleted successfully!";
            $_SESSION['msg_type'] = "success";
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1451) { 
            $_SESSION['message'] = "Some books cannot be deleted because the shopping cart has been added. You need to empty the cart before you can.";
        } else {
            $_SESSION['message'] = "Error deleting books: " . $e->getMessage();
        }
        $_SESSION['msg_type'] = "error";
    }

    $stmt->close();
}

$conn->close();

header("Location: deleteBookList.php");
exit();
?>
