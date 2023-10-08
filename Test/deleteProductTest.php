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
        // 首先，我们需要确保测试的数据在数据库中存在
        $bookId = 1; // 您可以使用一个实际存在于数据库中的值
        $cartId = "testCart123"; // 您可以使用一个实际存在于数据库中的值
        $_GET['book_id'] = $bookId;
        $_COOKIE['cart_id'] = $cartId;

        ob_start();
        include 'remove_item.php'; // 替换为您的脚本路径
        $output = ob_get_clean();

        $response = json_decode($output, true);
        $this->assertEquals("success", $response["status"]);

        // 然后，检查书籍是否真的已从购物车中删除
        $sql = "SELECT * FROM cart WHERE book_id = $bookId AND cart_id = '$cartId'";
        $result = $this->conn->query($sql);
        $this->assertEquals(0, $result->num_rows);
    }
}

