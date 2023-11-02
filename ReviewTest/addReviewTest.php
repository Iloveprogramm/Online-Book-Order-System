<?php
require_once 'addReviewProcess.php';

use PHPUnit\Framework\TestCase;

class AddReviewTest extends TestCase
{
    public function testAddReviewToDatabase()
    {
        $reviewData = [
            'bookID' => 122,
            'reviewerName' => 'Test Reviewer',
            'rating' => '5',
            'reviewText' => 'This book is amazing!'
        ];

        $response = addReviewToDatabase($reviewData);
        $decodedResponse = json_decode($response, true);

        $this->assertEquals('success', $decodedResponse['status']);
        $this->assertEquals('Review added successfully!', $decodedResponse['message']);
    }
}
?>

