<!DOCTYPE html>
<html lang="en">
<?php session_start();?>
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
<!-- Categories Navigation -->
<div class="container mt-4 mb-4">
    <h4 class="mb-3">Book Categories:</h4>
    <div class="d-flex justify-content-between">
        <div class="category-card">
            <a href="/category/novel">
                <i class="fas fa-book-open fa-2x"></i>
                <span>Novel</span>
            </a>
        </div>
        <div class="category-card">
            <a href="/category/education">
                <i class="fas fa-graduation-cap fa-2x"></i>
                <span>Education</span>
            </a>
        </div>
        <div class="category-card">
            <a href="/category/programming">
                <i class="fas fa-code fa-2x"></i>
                <span>Programming</span>
            </a>
        </div>
        <div class="category-card">
            <a href="/category/cartoon">
                <i class="fas fa-child fa-2x"></i>
                <span>Cartoon</span>
            </a>
        </div>
        <div class="category-card">
            <a href="/category/history">
                <i class="fas fa-history fa-2x"></i>
                <span>History</span>
            </a>
        </div>
    </div>
</div>

<main>

<div class="container mt-4 mb-4">
    <ul class="nav nav-tabs" id="categoryTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="search-tab" data-bs-toggle="tab" href="#search" role="tab" aria-controls="search" aria-selected="true">Search</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="novel-tab" data-bs-toggle="tab" href="#novel" role="tab" aria-controls="novel" aria-selected="fase">Novel</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="education-tab" data-bs-toggle="tab" href="#education" role="tab" aria-controls="education" aria-selected="false">Education</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="programming-tab" data-bs-toggle="tab" href="#programming" role="tab" aria-controls="programming" aria-selected="false">Programming</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="cartoon-tab" data-bs-toggle="tab" href="#cartoon" role="tab" aria-controls="cartoon" aria-selected="false">Cartoon</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="history-tab" data-bs-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="false">History</a>
        </li>
    </ul>


    <div class="tab-content" id="categoryTabsContent">
        <div class="tab-pane active" id="search" role="tabpanel" aria-labelledby="search-tab">
            <!-- search tab -->
            <section class="py-5 text-center container">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <form method="GET" action="">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="search" placeholder="Search" aria-label="Search" aria-describedby="search-button">
                            <button class="btn btn-outline-primary" type="submit" id="search-button">Search</button>
                        </div>
                    </form>

                    <?php
                    include 'exploreBooksProcess.php';
                    searchBooks();
                    ?>
                </div>
            </section>
        </div>

        <div class="tab-pane fade" id="novel" role="tabpanel" aria-labelledby="novel-tab">
            <div class="col-lg-6 col-md-10 mx-auto">
                <?php searchBooksCategory('novel'); ?>
            </div>
        </div>

        <div class="tab-pane fade" id="education" role="tabpanel" aria-labelledby="education-tab">
            <div class="col-lg-6 col-md-10 mx-auto">
                <?php searchBooksCategory('Education'); ?>
            </div>
        </div>
        <div class="tab-pane fade" id="programming" role="tabpanel" aria-labelledby="programming-tab">
            <div class="col-lg-6 col-md-10 mx-auto">
            <?php searchBooksCategory('Programming'); ?>
            </div>
        </div>
        <div class="tab-pane fade" id="cartoon" role="tabpanel" aria-labelledby="cartoon-tab">
            <div class="col-lg-6 col-md-10 mx-auto">
            <?php searchBooksCategory('Cartoon'); ?>
            </div>
        </div>
        <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
            <div class="col-lg-6 col-md-10 mx-auto">
            <?php searchBooksCategory('History'); ?>
            </div>
        </div>
    </div>
</div>
</main>


<!-- Footer -->
<footer class="footer py-3">
    <div class="container text-center">
        <span>&copy; d2023 BookQuartets. All Rights Reserved.</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script>

</body>

</html>
