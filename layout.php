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

    <form action="editSingleBook.php" method="POST">
    <input type="hidden" name="bookID" value="<?php echo $row['BookID']; ?>">
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
    <select class="form-control" id="category" name="category" required>
        <option value="" disabled>Select a Category</option>
        <option value="Novel" <?php echo ($row["Category"] == "Novel" ? "selected" : ""); ?>>Novel</option>
        <option value="Education" <?php echo ($row["Category"] == "Education" ? "selected" : ""); ?>>Education</option>
        <option value="Programming" <?php echo ($row["Category"] == "Programming" ? "selected" : ""); ?>>Programming</option>
        <option value="Cartoon" <?php echo ($row["Category"] == "Cartoon" ? "selected" : ""); ?>>Cartoon</option>
        <option value="History" <?php echo ($row["Category"] == "History" ? "selected" : ""); ?>>History</option>
    </select>
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
    
    //add data valiadataion(book title)
    if (title.length < 1 || title.length > 100) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'The book title must be between 1 and 100 characters in length!'
        });
        return;
    }

    //add data valiadataion(author name)
    if (author.length < 1 || author.length > 50) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'The author name must be between 1 and 50 characters in length!'
        });
        return;
    }

    //add data valiadataion(price)
    if (isNaN(price) || price <= 0) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'The price must be positive!'
        });
        return;
    }
    //add data valiadataion(book tile cannot all be number)
    if (/^\d+$/.test(title)) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'The book title cannot be all numbers!'
        });
        return;
    }

    if (/^\d+$/.test(author)) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'The author name cannot be all numbers!'
        });
        return;
    }
});
</script>
</body>
</html>