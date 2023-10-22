<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<style>
    /* Custom Styles */
    :root {
        --primary-color: #000;
        --secondary-color: #FFF;
        --font: "Montserrat", sans-serif;
    }

    body {
        font-family: var(--font);
        background-color: var(--secondary-color);
        color: var(--primary-color);
        margin: 0;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    .navbar {
        background-color: var(--primary-color);
    }

    .navbar .nav-link, .navbar .navbar-brand {
        padding: 0.5rem 1rem;
        color: var(--secondary-color);
        transition: color 0.3s;
    }

    .navbar .nav-link:hover, .navbar .navbar-brand:hover {
        color: #aaa;
    }

    .hero-section {
        background: var(--primary-color);
        color: var(--secondary-color);
        text-align: center;
        padding: 50px 0;
    }

    .card {
        border: none;
        transition: transform 0.3s, box-shadow 0.3s;
        background: #f7f7f7;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .btn-outline-primary {
        border-color: var(--primary-color);
        color: var(--primary-color);
    }

    .btn-outline-primary:hover {
        background-color: var(--primary-color);
        color: var(--secondary-color);
    }

    .footer {
        background: var(--primary-color);
        color: var(--secondary-color);
        margin-top: auto;  /* Makes sure footer sticks to bottom */
    }

    .book-image-wrapper {
        height: 250px;
        overflow: hidden;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .btn-danger {
        background-color: #ff3b30;
        border-color: #ff3b30;
        color: #FFF;
    }

    .btn-danger:hover {
        background-color: #d92b21;
        border-color: #d92b21;
        color: #FFF;
    }

    /* Table styles */
    table {
        border-collapse: separate;
        border-spacing: 0 15px;
    }

    table th, table td {
        padding: 10px 20px;
        background: var(--secondary-color);
        border-radius: 4px;
    }

    table th {
        background: var(--primary-color);
        color: var(--secondary-color);
    }

    a {
        transition: color 0.3s;
    }
</style>

<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">BookQuartet</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                <a class="nav-link" href="bookManagement.html">
<i class="fas fa-arrow-left"></i> Back to Book Management
</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<a href="viewEditHistory.php" class="btn btn-secondary">View Edit History</a>

<div class="container mt-5">
    <h2>Edit Books</h2>

    <?php
    session_start();
    
    // Display any messages set in the session
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        $messageType = $_SESSION['message_type'];

        echo "<script>
            Swal.fire({
                icon: '$messageType',
                title: '$message',
                showConfirmButton: true
            });
        </script>";

        // Clear the message so it's not shown again
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    }

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bookonlineorder";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch all books
    $sql = "SELECT BookID, Title, Author, Price, Category FROM Books";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table class='table'>";
        echo "<thead><tr><th>Title</th><th>Author</th><th>Price</th><th>Category</th><th>Action</th></tr></thead>";
        echo "<tbody>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["Title"] . "</td>";
            echo "<td>" . $row["Author"] . "</td>";
            echo "<td>" . $row["Price"] . "</td>";
            echo "<td>" . $row["Category"] . "</td>";
            echo "<td><a href='editSingleBook.php?bookID=" . $row["BookID"] . "' class='btn btn-primary'>Edit</a></td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>No books found in the database.</p>";
    }

    $conn->close();
    ?>

</div>

<!-- Footer -->
<footer class="footer py-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                &copy; 2023 BookQuartet. All rights reserved.
            </div>
        </div>
    </div>
</footer>

</body>
</html>
