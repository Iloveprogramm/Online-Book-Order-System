<?php

use PHPUnit\Framework\TestCase;

require './editSingleBook.php'; // 替换为您的脚本路径

class EditBookTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        $this->conn = getDatabaseConnection();
    }

    protected function tearDown(): void
    {
        $this->conn->close();
    }

    public function testEditBookOnRealDatabase()
{
    // 获取初始书籍数据
    $initialData = getBookDetails($this->conn, 1);

    // 调整大小写以匹配editBook函数的期望
    $initialData['bookID'] = $initialData['BookID'];  
    $initialData['title'] = $initialData['Title'];
    $initialData['author'] = $initialData['Author'];
    $initialData['price'] = $initialData['Price'];
    $initialData['category'] = $initialData['Category'];
    
    // 创建一个模拟书籍数据
    $mockBookData = [
        'bookID' => 1, // 使用真实的BookID
        'title' => 'Test Title',
        'author' => 'Test Author',
        'price' => 9.99,
        'category' => 'Test Category'
    ];
    
    // 调用函数
    editBook($this->conn, $mockBookData);

    // 从数据库获取修改后的书籍数据
    $updatedBookData = getBookDetails($this->conn, $mockBookData['bookID']);

    // 断言数据是否已被成功修改
    $this->assertEquals($mockBookData['title'], $updatedBookData['Title']);
    $this->assertEquals($mockBookData['author'], $updatedBookData['Author']);
    $this->assertEquals($mockBookData['price'], $updatedBookData['Price']);
    $this->assertEquals($mockBookData['category'], $updatedBookData['Category']);

    // 恢复原始数据
    editBook($this->conn, $initialData);
}
}
