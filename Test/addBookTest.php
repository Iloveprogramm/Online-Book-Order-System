<?php

require_once 'addBookToDatabase.php';  

use PHPUnit\Framework\TestCase;

class addBookTest extends TestCase
{
    public function testAddBookToDatabase()
    {
        $bookData = [
            'bookTitle' => 'Test Book',
            'bookAuthor' => 'Test Author',
            'bookPrice' => '19.99',
            'bookImgUrl' => 'http://example.com/img.jpg',
            'bookCategory' => 'Test'
        ];

        $response = addBookToDatabase($bookData);
        $decodedResponse = json_decode($response, true);

        $this->assertEquals('success', $decodedResponse['status']);
        $this->assertEquals('Book added successfully!', $decodedResponse['message']);
    }
}
?>
