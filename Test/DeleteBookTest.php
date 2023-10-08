<?php

use PHPUnit\Framework\TestCase;

class DeleteBookTest extends TestCase
{
    private $conn;

    // 在每次测试前设置
    protected function setUp(): void
    {
        $servername = "127.0.0.1";
        $username = "root";
        $password = "";
        $dbname = "bookonlineorder";

        // 连接到测试数据库
        $this->conn = new mysqli($servername, $username, $password, $dbname);

        // 插入一个测试书籍
        $sql = "INSERT INTO Books (BookID, Title, Author, Category) VALUES (99999, 'TestBook', 'TestAuthor', 'TestCategory')";
        $this->conn->query($sql);
    }

    // 在每次测试后清理
    protected function tearDown(): void
    {
        // 删除测试数据
        $sql = "DELETE FROM Books WHERE BookID = 99999";
        $this->conn->query($sql);

        $this->conn->close();
    }

    public function testDeleteBook()
    {
        $_POST['bookIdToDelete'] = 99999;

        // 调用您的删除脚本
        require './deleteProcess.php';

        // 检查书籍是否已被删除
        $result = $this->conn->query("SELECT * FROM Books WHERE BookID = 99999");
        $this->assertEquals(0, $result->num_rows);
    }
}
