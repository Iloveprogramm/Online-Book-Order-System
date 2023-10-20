<script>
    function confirmDelete(reviewID) {
        if (confirm('Are you sure you want to delete this review?')) {
            // send request to delete review
            fetch('deleteReview.php', {
                method: 'POST',
                body: JSON.stringify({ reviewID: reviewID }),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // refresh after deleted
                    location.reload()
                } else {
                    // check error
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // check error
                alert('There was an error. Please try again later.');
            });
        }
    }
</script>

<?php
include("dbConnection.php");

function displayAllReviews() {
    $conn = getConnection();

    $sql = "SELECT * FROM Reviews";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // print review cards
        echo '<div class="container">';
        echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">';
        while ($row = $result->fetch_assoc()) {
            echo '<div class="col">';
            echo '<div class="card shadow-sm">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $row["Title"] . '</h5>';
            echo '<h6 class="card-subtitle mb-2 text-muted">' . $row["ReviewerName"] . '</h6>';
            echo '<p class="card-text">' . $row["ReviewText"] . '</p>';
            echo '<p class="card-text">Rating: ' . $row["Rating"] . '</p>';
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


