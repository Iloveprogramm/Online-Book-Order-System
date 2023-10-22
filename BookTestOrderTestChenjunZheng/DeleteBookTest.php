<?php
//Importing PHPUnit's TestCase class for creating test cases
use PHPUnit\Framework\TestCase;

class DeleteBookTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        // Handling the session if needed
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        include 'db_config.php';
        $this->conn = $conn; 

        // Using prepared statement to insert test books into the database
        $stmt = $this->conn->prepare("INSERT INTO Books (BookID, Title, Author, Category) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $bookID, $title, $author, $category);

        $bookID = 99999;
        $title = 'TestBook';
        $author = 'TestAuthor';
        $category = 'TestCategory';
        $stmt->execute();
        $stmt->close();
    }

    protected function tearDown(): void
    {
        // Using prepared statement to delete the test book from the database
        $stmt = $this->conn->prepare("DELETE FROM Books WHERE BookID = ?");
        $stmt->bind_param("i", $bookID);

        $bookID = 99999;
        $stmt->execute();
        $stmt->close();

        $this->conn->close();
    }

    public function testDeleteBook()
    {
        $_POST['bookIdToDelete'] = 99999;

        require './deleteProcess.php';

        // Run a database query to see if the book has been removed.
        $stmt = $this->conn->prepare("SELECT * FROM Books WHERE BookID = ?");
        $stmt->bind_param("i", $bookID);

        $bookID = 99999;
        $stmt->execute();
        $stmt->store_result();

        // Declare that the query result should have zero rows, indicating that the book has been deleted.
        $this->assertEquals(0, $stmt->num_rows);
        $stmt->close();
    }
}
