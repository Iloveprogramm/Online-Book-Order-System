<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Single Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>

<div class="container mt-5">
    <h2>Edit Book Details</h2>
    <?php
        session_start();

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bookonlineorder";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $bookID = $_POST["bookID"];
            $title = $_POST["title"];
            $author = $_POST["author"];
            $price = $_POST["price"];
            $category = $_POST["category"];
            
            // Update query
            $sql = "UPDATE Books SET Title=?, Author=?, Price=?, Category=? WHERE BookID=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdsi", $title, $author, $price, $category, $bookID);
            
            if ($stmt->execute()) {
                $_SESSION['message'] = 'Book details updated successfully!';
                $_SESSION['message_type'] = 'success';
                header("Location: editBook.php");
                exit;
            } else {
                $_SESSION['message'] = 'Error updating book: ' . $stmt->error;
                $_SESSION['message_type'] = 'error';
                header("Location: editSingleBook.php?bookID=" . $bookID);
                exit;
            }

            $stmt->close();
        }

        if (isset($_GET["bookID"])) {
            $bookID = $_GET["bookID"];
            
            // Fetch book details
            $sql = "SELECT BookID, Title, Author, Price, Category FROM Books WHERE BookID=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $bookID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
            }
            $stmt->close();
        }

        $conn->close();
    ?>

    <form action="editSingleBook.php" method="POST">
        <input type="hidden" name="bookID" value="<?php echo $bookID; ?>">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo $row["Title"]; ?>">
        </div>
        <div class="mb-3">
            <label for="author" class="form-label">Author</label>
            <input type="text" class="form-control" id="author" name="author" value="<?php echo $row["Author"]; ?>">
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo $row["Price"]; ?>">
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <input type="text" class="form-control" id="category" name="category" value="<?php echo $row["Category"]; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update Book</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    <?php
        if (isset($_SESSION['message'])) {
            echo "Swal.fire({
                icon: '".$_SESSION['message_type']."',
                title: '".$_SESSION['message']."',
                showConfirmButton: false,
                timer: 1500
            });";

            // Clear the message so it's not shown again
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
        }
    ?>
</script>

<script>
document.querySelector('form').addEventListener('submit', function(e) {
    let title = document.getElementById('title').value.trim();
    let author = document.getElementById('author').value.trim();
    let price = parseFloat(document.getElementById('price').value.trim());
    
    if (title.length < 1 || title.length > 100) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'The book title must be between 1 and 100 characters in length!'
        });
        return;
    }
    
    if (author.length < 1 || author.length > 50) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'The author name must be between 1 and 50 characters in length!'
        });
        return;
    }

    if (isNaN(price) || price <= 0) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'The price must be positive!'
        });
        return;
    }
});
</script>
</body>
</html>
