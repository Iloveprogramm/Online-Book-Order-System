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
          <a class="nav-link" href="Main.php">
            <i class="fas fa-home"></i> Home
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
    <h1>Explore Reviews</h1>
    <div class="mt-5">
      <h3 class="section-heading">Highest Rated Books</h3>
      <hr class="section-divider">
      <div id="highestRatedBooks">
      </div>

      <script>
        fetch('getHighReviews.php')
          .then(response => response.text())
          .then(data => {
              document.getElementById('highestRatedBooks').innerHTML = data;
          })
          .catch(error => {
              console.error('Error:', error);
          });
      </script>

    </div>
    <div class="mt-5">
      <h3 class="section-heading">Add Review</h3>
      <hr class="section-divider">
      <p>Users can make reviews for books they have read.</p>
      <a href="addReview.php" class="btn btn-primary btn-lg">Add Review</a>
    </div>
    
    <div class="mt-5">
      <h3 class="section-heading">All Reviews</h3>
      <hr class="section-divider">
      
      <?php 
        include 'allReviewsProcess.php';
        displayAllReviews(); 
      ?>
      

    </div>
  </div>
</main>

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
