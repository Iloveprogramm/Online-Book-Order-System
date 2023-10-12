<?php
require_once ("dbConnection.php");

function deleteReview($data)
{
    $conn = getConnection();

    if ($conn->connect_error) {
        return json_encode(['status' => 'error', 'message' => "Connection failed: " . $conn->connect_error]);
    }

    $reviewID = $data['reviewID'];

    $stmt = $conn->prepare("DELETE FROM Reviews WHERE ReviewID = ?");
    $stmt->bind_param("i", $reviewID);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return json_encode(['status' => 'success', 'message' => 'Review deleted successfully!']);
    } else {
        return json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $postData = file_get_contents("php://input");

    $requestData = json_decode($postData, true);

    echo deleteReview($requestData);
}
?>
