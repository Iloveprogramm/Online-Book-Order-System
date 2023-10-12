<?php

use PHPUnit\Framework\TestCase;

require_once 'database.php';
require_once 'register.php';  

class RegisterTest extends TestCase {

    protected function setUp(): void {
        $_POST = [];
        $conn = createDbConnection();
    
        $emailToDelete = "testuser_register@test.com";
        $stmt = $conn->prepare("DELETE FROM UserTable WHERE user_id = ?");
        $stmt->bind_param("s", $emailToDelete);
        $stmt->execute();
    
        $stmt->close();
        $conn->close();
    }    

    protected function tearDown(): void {
        $_POST = [];
    }

    public function testValidRegistration() {
        $response = registerUser("testuser_register@test.com", "valid_test");

        $this->assertEquals("success", $response["status"]);
    }

    public function testShortPassword() {
        $response = registerUser("testuser_shortpass@test.com", "12");

        $this->assertEquals("error", $response["status"]);
        $this->assertEquals("Password must be at least 3 characters long.", $response["message"]);
    }
}
?>