<?php

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

include("dbConnection.php");

    $conn = getConnection();

    $sql = "SELECT Books.BookID, Books.Author, Books.Title, Books.ImageURL, AVG(Reviews.Rating) AS AvgRating
    FROM Books
    JOIN Reviews ON Books.BookID = Reviews.BookID
    GROUP BY Books.BookID, Books.Title, Books.ImageURL
    HAVING AVG(Reviews.Rating) >= 4;
    ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<div class="container" style="overflow-x: auto;">'; 
        echo '<div class="row flex-nowrap">';
    
        while ($row = $result->fetch_assoc()) {
            echo '<div class="col-md-4">';
            echo '<div class="card h-100">';
            echo '<div class="book-image-wrapper">';
            echo '<img src="' . $row["ImageURL"] . '" class="card-img" alt="Book Cover">';
            echo '</div>';
            echo '<div class="card-body d-flex flex-column">';
            echo '<span class="badge bg-secondary mb-2">' . $row["Category"] . '</span>';
            echo '<h5 class="card-title"><a href="#' . $row["BookID"] . '">' . $row["Title"] . '</a></h5>';
            echo '<p class="card-text mt-auto mb-2">By: ' . $row["Author"] . '</p>';
            echo '<p class="card-text mb-2">Average Rating: ' . number_format($row["AvgRating"], 1) . '</p>';
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
?>