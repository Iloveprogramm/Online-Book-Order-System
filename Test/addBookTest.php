<?php

require_once 'addBookToDatabase.php';  // 修改为您的 PHP 文件的路径

use PHPUnit\Framework\TestCase;

class AddBookTest extends TestCase
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
