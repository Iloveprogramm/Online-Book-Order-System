<?php
include("dbConnection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ReviewID = $_POST['ReviewID'];
    $ReviewerName = $_POST['ReviewerName'];
    $Rating = $_POST['Rating'];
    $ReviewText = $_POST['ReviewText'];

    $conn = getConnection();

    // update statement
    $sql = "UPDATE Reviews SET ReviewerName=?, Rating=?, ReviewText=? WHERE ReviewID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisi", $ReviewerName, $Rating, $ReviewText, $ReviewID);

    if ($stmt->execute()) {
        $response = array("status" => "success");
        echo json_encode($response);
    } else {
        $response = array("status" => "error", "message" => "Error updating review");
        echo json_encode($response);
    }

    $stmt->close();
    $conn->close();
} else {
    $response = array("status" => "error", "message" => "Invalid request method");
    echo json_encode($response);
}
?>
