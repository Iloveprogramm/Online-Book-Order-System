<?php

use PHPUnit\Framework\TestCase;

class DeleteBookTest extends TestCase
{
    private $conn;

   
    protected function setUp(): void
    {
        include 'db_config.php';
        $sql = "INSERT INTO Books (BookID, Title, Author, Category) VALUES (99999, 'TestBook', 'TestAuthor', 'TestCategory')";
        $this->conn->query($sql);
    }

 
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

        $result = $this->conn->query("SELECT * FROM Books WHERE BookID = 99999");
        $this->assertEquals(0, $result->num_rows);
    }
}
