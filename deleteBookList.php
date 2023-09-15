<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Books - BookQuartet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

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
            color: var(--secondary-color);
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
            transition: transform 0.3s;
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
    </style>
</head>

<body>

<!-- Navigation -->
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

<div class="container mt-5">
    <h2>Delete Books</h2>
    <div class="row gy-4">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bookonlineorder";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT BookID, Title, Author, Price, ImageURL, Category FROM Books";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="col-md-4">';
                echo '<div class="card h-100">';
                echo '<div class="book-image-wrapper">';
                echo '<img src="' . $row["ImageURL"] . '" class="card-img" alt="Book Cover">';
                echo '</div>';
                echo '<div class="card-body d-flex flex-column">';
                echo '<h5 class="card-title">“' . $row["Title"] . ' (' . $row["Category"] . ')”</h5>';
                echo '<p class="card-text mt-auto mb-2">By: ' . $row["Author"] . '</p>';
                echo '<form action="deleteProcess.php" method="POST">';
                echo '<input type="hidden" name="bookIdToDelete" value="' . $row["BookID"] . '">';
                echo '<button type="submit" class="btn btn-danger mt-auto">Delete</button>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "No books available to delete.";
        }

        $conn->close();
        ?>
    </div>
</div>

<!-- Footer -->
<footer class="footer py-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <p class="text-center mb-0">&copy; 2023 BookQuartet. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>

<!-- Optional: Include Bootstrap 5 and Font Awesome Icons JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script>
</body>
</html>
