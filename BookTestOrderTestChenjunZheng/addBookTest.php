<?php
//import addBookToDatabase.php for test
require_once 'addBookToDatabase.php';  

//Importing the TestCase class from PHPUnit to create test cases
use PHPUnit\Framework\TestCase;

class addBookTest extends TestCase
{
    public function testAddBookToDatabase()
    {
        //Simulation data add 
        $bookData = [
            'bookTitle' => 'Test Book',
            'bookAuthor' => 'Test Author',
            'bookPrice' => '19.99',
            'bookImgUrl' => 'http://example.com/img.jpg',
            'bookCategory' => 'Test'
        ];

       //Assign the book data to the addBookToDatabase method.
        // after that, save the returned response in the variable $response.
        $response = addBookToDatabase($bookData);
        $decodedResponse = json_decode($response, true);

        // Use PHPUnit's assertEquals method to verify whether the return status of the addBookToDatabase function is 'success'
        $this->assertEquals('success', $decodedResponse['status']);
        $this->assertEquals('Book added successfully!', $decodedResponse['message']);
    }
}
?>
