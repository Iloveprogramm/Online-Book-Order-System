<?php
    $bookId = $_GET['book_id'];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bookonlineorder";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM Books WHERE BookID = $bookId";
    $result = $conn->query($sql);

    header('Content-Type: application/json');  // 设置 Content-Type

    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(["error" => "Book not found"]);
    }

    $conn->close();
?>