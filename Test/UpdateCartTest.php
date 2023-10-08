<?php

use PHPUnit\Framework\TestCase;

class UpdateCartTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        $servername = "127.0.0.1";  // 使用127.0.0.1代替localhost
        $username = "root";
        $password = "";
        $dbname = "bookonlineorder";
        $this->conn = new mysqli($servername, $username, $password, $dbname);
    }

    protected function tearDown(): void
    {
        $this->conn->close();
    }

    public function testUpdateBookQuantityInCart()
    {
        $bookId = 1;  
        $quantity = 5;  
        $cartId = "testCart123";
        
        $_POST['book_id'] = $bookId;
        $_POST['quantity'] = $quantity;
        $_COOKIE['cart_id'] = $cartId;
    
        // 1. 确保测试数据存在
        $initialQuantity = $quantity - 1;
        $stmt = $this->conn->prepare("INSERT INTO cart (book_id, cart_id, quantity) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quantity = ?");
        $stmt->bind_param("isis", $bookId, $cartId, $initialQuantity, $initialQuantity);
        $stmt->execute();
        $stmt->close();
    
        ob_start();
        include 'update_quantity.php'; 
        $output = ob_get_clean();
    
        $response = json_decode($output, true);
        $this->assertEquals("success", $response["status"]);
    
        // 2. 验证书籍数量是否已更新
        $stmt = $this->conn->prepare("SELECT quantity FROM cart WHERE book_id = ? AND cart_id = ?");
        $stmt->bind_param("is", $bookId, $cartId);
        $stmt->execute();
        $stmt->bind_result($updatedQuantity);
        $stmt->fetch();
        $stmt->close();
    
        $this->assertEquals($quantity, $updatedQuantity);
    
        // 清理：删除插入的测试数据
        $stmt = $this->conn->prepare("DELETE FROM cart WHERE book_id = ? AND cart_id = ?");
        $stmt->bind_param("is", $bookId, $cartId);
        $stmt->execute();
        $stmt->close();
    }
    

}