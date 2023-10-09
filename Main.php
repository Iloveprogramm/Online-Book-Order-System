<!DOCTYPE html>
<html lang="en">

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
                <li class="nav-item">
        <a class="nav-link" href="cart.php">
            <i class="fas fa-shopping-cart"></i> Cart
        </a>
    </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero-section">
    <h1>Welcome to BookQuartets</h1>
    <p>Your premium book destination</p>
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


<!-- Main Content -->
<div class="container mt-5">
    <div class="row gy-4">

<?php
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

    $sql = "SELECT BookID, Title, Author, Price, ImageURL, Category FROM Books";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo '<div class="col-md-4">';
            echo '<div class="card h-100">';
            echo '<div class="book-image-wrapper">';
            echo '<img src="' . $row["ImageURL"] . '" class="card-img" alt="Book Cover">';
            echo '</div>';
            echo '<div class="card-body d-flex flex-column">';
            echo '<span class="badge bg-secondary mb-2">' . $row["Category"] . '</span>';
            echo '<h5 class="card-title">“' . $row["Title"] . ' (' . $row["Category"] . ')”</h5>';
            echo '<p class="card-text mt-auto mb-2">By: ' . $row["Author"] . '</p>';
            echo '<p class="card-text mb-2">$' . number_format($row["Price"], 2) . '</p>';
            echo '<button class="btn btn-outline-primary mt-auto" onclick="addToCart(' . $row["BookID"] . ')">Add to Cart</button>';
            echo '<a href="/category/' . strtolower($row["Category"]) . '" class="btn btn-outline-secondary mt-auto">Explore Category</a>';
            echo '<button class="btn btn-outline-primary mt-auto" onclick="addToWishlist(' . $row["BookID"] . ')">Wishlist</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "0 results";
    }

    $conn->close();
    ?>

    </div>
</div>
<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close" id="closeModal">&times;</span>
    <p id="statusMessage"></p>
  </div>
</div>

<script>
    var modal = document.getElementById("myModal"); // Declare modal outside the function

    // Close the modal when the close button is clicked
    var closeModalBtn = document.getElementById("closeModal");

    closeModalBtn.onclick = function() {
        modal.style.display = "none";
    };

    function addToWishlist(bookId) {
        var xhr = new XMLHttpRequest();
        var url = "add-To-Wishlist.php?book_id=" + bookId;
        xhr.open("GET", url, true);

        xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
        var modal = document.getElementById("myModal");
        var statusMessage = document.getElementById("statusMessage");

        try {
            var response = JSON.parse(xhr.responseText);

            if (response.status === "success") {
                // Success message
                statusMessage.innerHTML = response.message;
            } else {
                // Error or info message
                statusMessage.innerHTML = response.message;
            }
        } catch (error) {
            // Handle JSON parsing error (unexpected response)
            statusMessage.innerHTML = "Error: Unexpected response from the server.";
        }

        // Display the modal
        modal.style.display = "block";
    }
};

        xhr.send();
    }

    function addToCart(bookId) {
    var xhr = new XMLHttpRequest();
    var url = "addToCart.php?book_id=" + bookId;
    xhr.open("GET", url, true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            alert(xhr.responseText);
        }
    };

    xhr.send();
}


</script>


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