<?php
use PHPUnit\Framework\TestCase;

require './editSingleBook.php'; 

class EditBookTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        $this->conn = getDatabaseConnection(); // Ensure this function is well-defined and error-handled
    }

    protected function tearDown(): void
    {
        $this->conn->close();
    }

    public function testEditBookOnRealDatabase()
    {
        // Fetch initial book details
        $initialData = getBookDetails($this->conn, 1); // Ensure this function is well-defined and error-handled

        // Prepare data for modification
        $modifiedData = [
            'bookID' => 1, 
            'title' => 'Test Title',
            'author' => 'Test Author',
            'price' => 9.99,
            'category' => 'Test Category'
        ];

        // Edit the book with the modified data
        editBook($this->conn, $modifiedData); // Ensure this function is well-defined and error-handled

        // Fetch the updated book details
        $updatedData = getBookDetails($this->conn, 1);

        // Assert the book details were updated correctly
        $this->assertEquals($modifiedData['title'], $updatedData['Title']);
        $this->assertEquals($modifiedData['author'], $updatedData['Author']);
        $this->assertEquals($modifiedData['price'], $updatedData['Price']);
        $this->assertEquals($modifiedData['category'], $updatedData['Category']);

        // Restore the original book details
        editBook($this->conn, $initialData);
    }
}