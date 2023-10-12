<?php
include("dbConnection.php");

// Check if data is received via POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // get the review ID from the JSON data
    $data = json_decode(file_get_contents("php://input"));
    $reviewID = $data->reviewID;

    $conn = getConnection();

    // Prepare SQL statement to delete the review
    $sql = "DELETE FROM Reviews WHERE ReviewID = ?";

    // Prepare and bind the parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $reviewID);

    // Execute the statement
    if ($stmt->execute()) {
        // Return success message
        echo json_encode(['status' => 'success', 'message' => 'Review deleted successfully!']);
    } else {
        // Return error message
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Handle invalid request method
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
