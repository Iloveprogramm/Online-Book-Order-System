<?php
require_once ("deleteReview.php");

function testDeleteReview()
{
    $data = [
        'reviewID' => 1
    ];

    $result = json_decode(deleteReview($data), true);

    if ($result['status'] === 'success') {
        echo "Review deleted successfully!\\n";
    } else {
        echo "Error deleting review: " . $result['message'] . "\\n";
    }
}

?>