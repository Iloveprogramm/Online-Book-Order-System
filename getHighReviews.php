<?php
include("dbConnection.php");

// function searchHighestRatedBooks() {
    $conn = getConnection();

    $sql = "SELECT Rating FROM Books WHERE Rating >= 4 ORDER BY Rating DESC";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo '<div class="container">';
        echo '<div class="row">';
        while ($row = $result->fetch_assoc()) {
            echo '<div class="col">';
            echo '<p>' . $row["Rating"] . ' Stars</p>';
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';
    } else {
        echo "<p>No highly rated books found.</p>";
    }

    $conn->close();
// }
?>