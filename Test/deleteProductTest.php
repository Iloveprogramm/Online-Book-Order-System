<?php

use PHPUnit\Framework\TestCase;

class deleteProductTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        $servername = "127.0.0.1";
$username = "testuser";
$password = "TestPass123!"; // 使用新的密码
$dbname = "bookonlineorder";
        $this->conn = new mysqli($servername, $username, $password, $dbname);
    }

    protected function tearDown(): void
    {
        $this->conn->close();
    }

    public function testDeleteBookFromCart()
    {
       
        $bookId = 1;
        $cartId = "testCart123"; 
        $_GET['book_id'] = $bookId;
        $_COOKIE['cart_id'] = $cartId;

        ob_start();
        include 'remove_item.php'; 
        $output = ob_get_clean();

        $response = json_decode($output, true);
        $this->assertEquals("success", $response["status"]);

        $sql = "SELECT * FROM cart WHERE book_id = $bookId AND cart_id = '$cartId'";
        $result = $this->conn->query($sql);
        $this->assertEquals(0, $result->num_rows);
    }
}

