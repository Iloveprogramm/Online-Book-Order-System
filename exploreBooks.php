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
    <link rel="stylesheet" href="styles.css">
</head>


<body>
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
                    <a class="nav-link" href="reviewMain.php">
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

<section class="py-5 text-center container">
            <div class="col-lg-6 col-md-8 mx-auto">
        <!-- Bootstrap buttons for each category -->
        <div class="btn-group" role="group" aria-label="Categories">
            <button type="button" class="btn btn-primary" onclick="loadBooks('programming')">Programming</button>
            <button type="button" class="btn btn-primary" onclick="loadBooks('history')">History</button>
            <button type="button" class="btn btn-primary" onclick="loadBooks('novel')">Novel</button>
        </div>

        <!-- Container to display books -->
        <div class="mt-3" id="books-container"></div>
    </div>
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


    <?php include 'exploreBooksProcess.php';
        searchBooks();
    ?>



</main>

<!-- Footer -->
<footer class="footer py-3">
    <div class="container text-center">
        <span>&copy; d2023 BookQuartets. All Rights Reserved.</span>
    </div>
</footer>

<script>
        // Load the navigation menu using fetch and inject it into the #navigation element
        fetch('navigation.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('navigation').innerHTML = data;
            })
            .catch(error => {
                console.error('Error:', error);
            });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script>

</body>

</html>
