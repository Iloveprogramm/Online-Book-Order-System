<?php
//Importing PHPUnit's TestCase class for creating test cases
use PHPUnit\Framework\TestCase;

class deleteProductTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        include 'db_config.php';
        $this->conn = $conn; 
    }

    protected function tearDown(): void
    {
        $this->conn->close();
    }

    public function testDeleteBookFromCart()
    {
       //Set the book ID and shopping cart ID to be deleted from the shopping cart
        $bookId = 1;
        $cartId = "testCart123"; 

        //Set the $_GET and $_COOKIE superglobal variables for use in the remove_item.php file
        $_GET['book_id'] = $bookId;
        $_COOKIE['cart_id'] = $cartId;

        // Use output buffering to capture the output of remove_item.php
        ob_start();
        include 'remove_item.php'; 
        $output = ob_get_clean();

        $response = json_decode($output, true);
        $this->assertEquals("success", $response["status"]);

        $sql = "SELECT * FROM cart WHERE book_id = $bookId AND cart_id = '$cartId'";
        $result = $this->conn->query($sql);

        // Assert that the number of rows in the query result should be 0
        //indicating that the book has been deleted from the shopping cart
        $this->assertEquals(0, $result->num_rows);
    }
}

