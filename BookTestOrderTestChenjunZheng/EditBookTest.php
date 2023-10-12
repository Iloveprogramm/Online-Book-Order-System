<?php
//Importing PHPUnit's TestCase class for creating test cases
use PHPUnit\Framework\TestCase;

require './editSingleBook.php'; 

class EditBookTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        $this->conn = getDatabaseConnection();
    }

    // Called after each test method is executed to clean up the test environment
    protected function tearDown(): void
    {
        $this->conn->close();
    }

    public function testEditBookOnRealDatabase()
{

    // Get and store book details before testing
    $initialData = getBookDetails($this->conn, 1);


    $initialData['bookID'] = $initialData['BookID'];  
    $initialData['title'] = $initialData['Title'];
    $initialData['author'] = $initialData['Author'];
    $initialData['price'] = $initialData['Price'];
    $initialData['category'] = $initialData['Category'];
    

    // Define new book details for the simulation
    $mockBookData = [
        'bookID' => 1, 
        'title' => 'Test Title',
        'author' => 'Test Author',
        'price' => 9.99,
        'category' => 'Test Category'
    ];
    

    //Call the editBook function to edit using simulated new book data
    editBook($this->conn, $mockBookData);


    $updatedBookData = getBookDetails($this->conn, $mockBookData['bookID']);

    // Assert that the edited book details match the simulated new book data
    $this->assertEquals($mockBookData['title'], $updatedBookData['Title']);
    $this->assertEquals($mockBookData['author'], $updatedBookData['Author']);
    $this->assertEquals($mockBookData['price'], $updatedBookData['Price']);
    $this->assertEquals($mockBookData['category'], $updatedBookData['Category']);


    //Restore the original state of the book using the book details before testing
    editBook($this->conn, $initialData);
}
}
