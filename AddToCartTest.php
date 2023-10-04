<?php
use PHPUnit\Framework\TestCase;

require_once 'AddToCart.php';  // 引入 AddToCart.php

class AddToCartTest extends TestCase
{
    public function testAddToCart()
    {
        $bookId = 1;
        $existingCartId = null;

        $output = addToCart($bookId, $existingCartId, false);

        $this->assertEquals("Book added to cart successfully", $output);
    }
}
