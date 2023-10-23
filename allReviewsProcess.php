<?php
include("dbConnection.php");

function displayAllReviews() {
    $conn = getConnection();

    $sql = "SELECT Reviews.*, Books.Title FROM Reviews JOIN Books ON Reviews.BookID = Books.BookID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<div class="container">';
        echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">';
        while ($row = $result->fetch_assoc()) {
            echo '<div class="col">';
            echo '<div class="card shadow-sm">';
            echo '<div class="card-body">';
            

            echo '<h5 class="card-title">' . htmlspecialchars($row["Title"]) . '</h5>'; 
            
            echo '<h6 class="card-subtitle mb-2 text-muted">' . htmlspecialchars($row["ReviewerName"]) . '</h6>';
            echo '<p class="card-text">' . htmlspecialchars($row["ReviewText"]) . '</p>';
            echo '<p class="card-text">Rating: ' . htmlspecialchars($row["Rating"]) . '</p>';
            echo '<button class="btn btn-danger" onclick="confirmDelete(' . $row["ReviewID"] . ')">Delete</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';
    } else {
        echo "<p>No reviews found.</p>";
    }

    $conn->close();
}
?>

