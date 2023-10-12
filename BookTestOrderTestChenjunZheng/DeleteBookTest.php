<?php
//Importing PHPUnit's TestCase class for creating test cases
use PHPUnit\Framework\TestCase;

class DeleteBookTest extends TestCase
{
    private $conn;

   
    protected function setUp(): void
    {
        include 'db_config.php';
        $this->conn = $conn; 
        //Insert test books into the database
        $sql = "INSERT INTO Books (BookID, Title, Author, Category) VALUES (99999, 'TestBook', 'TestAuthor', 'TestCategory')";
        $this->conn->query($sql);
    }

 
    // The tearDown method will be run after each test method is executed
    protected function tearDown(): void
    {

        $sql = "DELETE FROM Books WHERE BookID = 99999";
        $this->conn->query($sql);

        $this->conn->close();
    }

    public function testDeleteBook()
    {
        $_POST['bookIdToDelete'] = 99999;

  
        require './deleteProcess.php';

        // Run a database query to see if the book has been removed.
        $result = $this->conn->query("SELECT * FROM Books WHERE BookID = 99999");

        // Declare that the query result should have zero rows, indicating that the book has been delete.
        $this->assertEquals(0, $result->num_rows);
    }
}
