<?php
use PHPUnit\Framework\TestCase;

require_once 'login.php';

class LoginTest extends TestCase
{
    protected function setUp(): void {
        $_POST = [];
        $_SESSION = [];
    }

    protected function tearDown(): void {
        $_POST = [];
        $_SESSION = [];
    }

    public function testValidLogin()
    {
        $response = loginUser("valid_user@test.com", "valid_test");

        $this->assertEquals("success", $response["status"]);
        $this->assertEquals("Main.php", $response["redirectURL"]);
    }

    public function testInvalidLogin()
    {
        $response = loginUser("invalid_user@test.com", "wrong_test");

        $this->assertEquals("error", $response["status"]);
        $this->assertEquals("Invalid username.", $response["message"]);
    }
}

// cd C:\Users\perme\Online-Book-Order-System\Online-Book-Order-System
//vendor\bin\phpunit UserTestPaymentTest\LoginTest.php
?>