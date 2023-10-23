<?php

$servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bookonlineorder";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM Reviews WHERE Rating = (SELECT MAX(Rating) FROM Reviews) ORDER BY ReviewDate DESC";
$result = $conn->query($sql);

if ($conn->error) {
    die("SQL Error: " . $conn->error); 
}

if ($result->num_rows > 0) {
    echo '<div class="container">';
    echo '<div class="row">';
    while ($row = $result->fetch_assoc()) {
        echo '<div class="col">';
        echo '<p>Book ID: ' . $row["BookID"] . '</p>';
        echo '<p>Reviewer: ' . $row["ReviewerName"] . '</p>';
        echo '<p>Rating: ' . $row["Rating"] . ' Stars</p>';
        echo '<p>Review: ' . $row["ReviewText"] . '</p>';
        echo '<p>Date: ' . $row["ReviewDate"] . '</p>';
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';
} else {
    echo "<p>No reviews found.</p>";
}

$conn->close();
?>
