<?php

require_once './addReviewProcess.php';
use PHPUnit\Framework\TestCase;

class ReviewTest extends TestCase
{
    public function testAddReview()
    {
        $postData = [
            'bookID' => 1,
            'reviewerName' => 'Jelly Bean',
            'rating' => '5',
            'reviewText' => 'Great book!'
        ];

        $response = addReviewToDatabase($postData);
        $decodedResponse = json_decode($response, true);

        $this->assertEquals('success', $decodedResponse['status']);
        $this->assertEquals('Review added successfully!', $decodedResponse['message']);
    }
}
?>

