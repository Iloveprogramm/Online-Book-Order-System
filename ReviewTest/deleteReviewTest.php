<?php

require_once 'deleteReview.php';
use PHPUnit\Framework\TestCase;

class DeleteReviewTest extends TestCase
{
    public function testDeleteReviewSuccess()
    {
        // good review id to make sure it runs
        $reviewID = 1;

        $response = deleteReview($reviewID);
        $decodedResponse = json_decode($response, true);

        $this->assertEquals('success', $decodedResponse['status']);
        $this->assertEquals('Review deleted successfully!', $decodedResponse['message']);
    }

    public function testDeleteReviewFailure()
    {
        // review that doesnt exist to see if it fails
        $reviewID = 999;

        $response = deleteReview($reviewID);
        $decodedResponse = json_decode($response, true);

        $this->assertEquals('error', $decodedResponse['status']);
        $this->assertStringContainsString('Error', $decodedResponse['message']);
    }
}
?>
