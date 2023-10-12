<?php
    use PHPUnit\Framework\TestCase;

    require_once 'update-password.php';

    class UpdatePasswordTest extends TestCase {

        protected function setUp(): void {
            $_SESSION['username'] = 'testuser';
        }

        protected function tearDown(): void {
            unset($_SESSION['username']);
        }

        public function testUpdatePasswordSuccess() {
            $response = updateUserPassword('testuser', 'newpassword');
            $this->assertEquals('success', $response);
        }

        public function testUpdatePasswordEmpty() {
            $response = updateUserPassword('testuser', '');
            $this->assertEquals('Password should not be empty', $response);
        }

        public function testUserNotLoggedIn() {
            $response = updateUserPassword(null, 'newpassword');
            $this->assertEquals('Not logged in', $response);
        }

    }
?>