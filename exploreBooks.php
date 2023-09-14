<!DOCTYPE html>
<html lang="en">
<?php
session_start();
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elite Online Bookstore</title>
    <!-- Bootstrap 5 CSS, Icons, and Montserrat Font -->
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
            margin-top: auto;
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

        .category-card {
            width: 18%;
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 15px;
            transition: 0.3s;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .category-card a {
            text-decoration: none;
            color: var(--primary-color);
        }

        .category-card i {
            margin-bottom: 10px;
        }


        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 60%;
            text-align: center;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

    </style>
</head>


<body>

<!-- Navigation -->
<!-- Navigation -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">BookQuartet</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="bookManagement.html"><i class="fas fa-cogs"></i> Book Managements</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item me-3">
                    <a class="nav-link" href="userprofile.html">
                        <i class="fas fa-user"></i> Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Wishlist.php">
                        <i class="fas fa-star"></i> Wishlist
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="exploreBooks.php">
                        <i class="fas fa-star"></i> Explore
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reviewMain.html">
                        <i class="fas fa-star"></i> Reviews
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Welcome.html">

                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero-section">
    <h1>Explore</h1>
    <p>Search for your next favourite book</p>
</section>

<main>
    <form method="GET" action="">
        <section class="py-5 text-center container">
            <div class="col-lg-6 col-md-8 mx-auto">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="search" placeholder="Search" aria-label="Search" aria-describedby="search-button">
                    <button class="btn btn-outline-primary" type="submit" id="search-button">Search</button>
                </div>
            </div>
        </section>
    </form>


    <?php
    if (isset($_GET['search'])) {
        // Database connection code
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bookonlineorder";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $searchTerm = $_GET['search'];

        $sql = "SELECT * FROM Books WHERE Title LIKE '%$searchTerm%' OR Author LIKE '%$searchTerm%'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<div class="container">';
            echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">';
            while ($row = $result->fetch_assoc()) {
                echo '<div class="col">';
                echo '<div class="card shadow-sm">';
                echo '<img class="bd-placeholder-img card-img-top" width="100%" height="225" src="' . $row["ImageURL"] . '" alt="Book Cover">';
                echo '<div class="card-body">';
                echo '<p class="card-text">' . $row["Description"] . '</p>';
                echo '<div class="d-flex justify-content-between align-items-center">';
                echo '<div class="btn-group">';
                echo '<button type="button" class="btn btn-sm btn-outline-secondary">View</button>';
                echo '<button type="button" class="btn btn-sm btn-outline-secondary">Add</button>';
                echo '</div>';
                echo '<small class="text-body-secondary">' . $row["Category"] . '</small>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
            echo '</div>';
        } else {
            echo "<p>No results found.</p>";
        }

        $conn->close();
    }
    ?>



</main>

<!-- Footer -->
<footer class="footer py-3">
    <div class="container text-center">
        <span>&copy; 2023 BookQuartets. All Rights Reserved.</span>
    </div>
</footer>

<!-- Optional: Include Bootstrap 5 and Font Awesome Icons JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script>

</body>

</html>
