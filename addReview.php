<!DOCTYPE html>
<html lang="en">
<?php session_start(); ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Hub</title>
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
    <h1>Review Hub</h1>
    <p>Share and read reviews</p>
</section>

<main>
    <div class="container mt-5">
        <h1>Add Review</h1>
        <form id="addReviewForm" method="POST", action="addReviewProcess.php">
            <div class="mb-3">
                <label for="bookID" class="form-label">Book ID:</label>
                <input type="text" class="form-control" id="bookID" name="bookID" required>
            </div>
            <div class="mb-3">
                <label for="reviewerName" class="form-label">Your Name:</label>
                <input type="text" class="form-control" id="reviewerName" name="reviewerName" required>
            </div>
            <div class="mb-3">
                <label for="rating" class="form-label">Rating (1-5):</label>
                <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" required>
            </div>
            <div class="mb-3">
                <label for="reviewText" class="form-label">Review:</label>
                <textarea class="form-control" id="reviewText" name="reviewText" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Submit Review</button>
            </div>
        </form>
    </div>
</main>

<script>
document.querySelector('#addReviewForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    let formData = new FormData(e.target);
    // Get php function
    fetch('addReviewProcess.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // Show success message
            alert('Review added successfully!');
            // Redirect to reviewMain.php
            window.location.href = 'reviewMain.php';
        } else {
            // Show error message
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Show error message
        alert('An error has occurred. Please try again later.');
    });
});
</script>



<!-- Footer -->
<footer class="footer py-3">
    <div class="container text-center">
        <span>&copy; 2023 BookQuartets. All Rights Reserved.</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script>

</body>

</html>