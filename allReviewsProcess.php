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
            // Security: sanitize and escape so we can prevent XSS attacks
            echo '<button class="btn btn-primary" onclick="redirectToEdit(' . $row["ReviewID"] . ', \'' . htmlspecialchars($row["ReviewerName"], ENT_QUOTES) . '\', ' . $row["Rating"] . ', \'' . htmlspecialchars($row["ReviewText"], ENT_QUOTES) . '\')">Edit</button>';
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

<script>

function redirectToEdit(reviewId, reviewerName, rating, reviewText) {
    window.location.href = 'editReview.php?reviewId=' + reviewId +
                          '&reviewerName=' + encodeURIComponent(reviewerName) +
                          '&rating=' + rating +
                          '&reviewText=' + encodeURIComponent(reviewText);
}



function confirmDelete(reviewId) {
    if (confirm('Are you sure you want to delete this review?')) {
        deleteReview(reviewId);
    }
}

function deleteReview(reviewId) {
    fetch('deleteReview.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ reviewID: reviewId })  
    })
    .then(response => response.json())  
    .then(data => {
        if(data.status === 'success') {
            alert(data.message);
            location.reload();  
        } else {
            alert(data.message);  
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
</script>

