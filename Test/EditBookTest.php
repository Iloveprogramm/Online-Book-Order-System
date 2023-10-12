<?php

use PHPUnit\Framework\TestCase;

require './editSingleBook.php'; 

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

    $initialData = getBookDetails($this->conn, 1);


    $initialData['bookID'] = $initialData['BookID'];  
    $initialData['title'] = $initialData['Title'];
    $initialData['author'] = $initialData['Author'];
    $initialData['price'] = $initialData['Price'];
    $initialData['category'] = $initialData['Category'];
    

    $mockBookData = [
        'bookID' => 1, 
        'title' => 'Test Title',
        'author' => 'Test Author',
        'price' => 9.99,
        'category' => 'Test Category'
    ];
    

    editBook($this->conn, $mockBookData);


    $updatedBookData = getBookDetails($this->conn, $mockBookData['bookID']);

    $this->assertEquals($mockBookData['title'], $updatedBookData['Title']);
    $this->assertEquals($mockBookData['author'], $updatedBookData['Author']);
    $this->assertEquals($mockBookData['price'], $updatedBookData['Price']);
    $this->assertEquals($mockBookData['category'], $updatedBookData['Category']);


    editBook($this->conn, $initialData);
}
}
