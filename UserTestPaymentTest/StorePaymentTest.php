<?php
use PHPUnit\Framework\TestCase;

require_once 'store-payment.php';

class StorePaymentTest extends TestCase {

    protected function setUp(): void {
        $_SERVER["REQUEST_METHOD"] = "POST";
    }

    public function testInvalidExpiry() {
        // Set up POST values
        $_POST["payment-method"] = 'credit';
        $_POST["card_number"] = '4111111111111111';
        $_POST["expiry"] = '13/23';
        $_POST["cvc"] = '123';
        $_POST["cartItemsHTML"] = '<div>Test item</div>';
        $_POST["totalAmount"] = '10.99';

        $response = storePaymentData(
            $_POST["payment-method"],
            $_POST["card_number"],
            $_POST["expiry"],
            $_POST["cvc"],
            $_POST["cartItemsHTML"],
            $_POST["totalAmount"]
        );

        $this->assertEquals("Invalid expiry format. Please use MM/YY.", $response);
    }

    public function testInvalidCVC() {
        // Set up POST values
        $_POST["payment-method"] = 'credit';
        $_POST["card_number"] = '4111111111111111';
        $_POST["expiry"] = '12/23';
        $_POST["cvc"] = '12a'; // Invalid CVC
        $_POST["cartItemsHTML"] = '<div>Test item</div>';
        $_POST["totalAmount"] = '10.99';

        $response = storePaymentData(
            $_POST["payment-method"],
            $_POST["card_number"],
            $_POST["expiry"],
            $_POST["cvc"],
            $_POST["cartItemsHTML"],
            $_POST["totalAmount"]
        );

        $this->assertEquals("Invalid CVC. It must be a 3-digit number.", $response);
    }

    public function testOrderAndPaymentInsertion() {
        // Set up POST values
        $_POST["payment-method"] = 'credit';
        $_POST["card_number"] = '4111111111111111';
        $_POST["expiry"] = '12/23';
        $_POST["cvc"] = '123';
        $_POST["cartItemsHTML"] = '<div>Test item</div>';
        $_POST["totalAmount"] = '10.99';

        $response = storePaymentData(
            $_POST["payment-method"],
            $_POST["card_number"],
            $_POST["expiry"],
            $_POST["cvc"],
            $_POST["cartItemsHTML"],
            $_POST["totalAmount"]
        );

        $this->assertStringContainsString("Order and payment details stored successfully!", $response);
    }
}
?>    