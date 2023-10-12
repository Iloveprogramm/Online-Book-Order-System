<?php
//Importing PHPUnit's TestCase class for creating test cases
use PHPUnit\Framework\TestCase;

//import addToCart.php for test
require_once 'addToCart.php';  

//Define the AddToCartTest class to test the addToCart function, inherited from PHPUnit's TestCase class
class AddToCartTest extends TestCase
{
    public function testAddToCart()
    {
        $bookId = 1;
        $existingCartId = null;

        // Call the addToCart function and pass in the book ID, the existing shopping cart ID and a Boolean value
         // Store the returned result in the $output variable
        $output = addToCart($bookId, $existingCartId, false);

        $this->assertEquals("Book added to cart successfully", $output);
    }
}
