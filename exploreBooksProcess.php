<?php
require_once("dbConnection.php");

function searchBooks() {
    if (isset($_GET['search'])) {
        $searchTerm = $_GET['search'];
        $conn = getConnection();

        $sql = "SELECT * FROM Books WHERE Title LIKE '%$searchTerm%' OR Author LIKE '%$searchTerm%'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output book cards
            echo '<div class="container">';
            echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">';
            while ($row = $result->fetch_assoc()) {
                echo '<div class="col">';
                echo '<div class="card shadow-sm">';
                echo '<img class="bd-placeholder-img card-img-top" width="100%" height="225" src="' . $row["ImageURL"] . '" alt="Book Cover">';
                echo '<div class="card-body">';
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

        // Close the connection
        $conn->close();
    }
}
?>

