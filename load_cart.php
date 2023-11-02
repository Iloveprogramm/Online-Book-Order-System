<?php
$servername = "localhost";
$username = "id21490898_uts";
$password = "Zcj030366*";
$dbname = "id21490898_onlinebookorder";
$conn = new mysqli($servername, $username, $password, $dbname);

$cartId = $_COOKIE['cart_id'] ?? null;
$items = '';
$subtotal = 0.00;

if ($cartId) {
    $sql = "SELECT c.quantity, b.Title, b.Author, b.Price, b.ImageURL, b.BookID 
            FROM cart c
            JOIN Books b ON c.book_id = b.BookID
            WHERE c.cart_id = '$cartId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $totalPrice = $row["Price"] * $row["quantity"];
            $subtotal += $totalPrice;
            $items .= '<div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; background-color: white; display: flex; justify-content: space-between; align-items: center;">
                            <div style="display: flex; align-items: center;">
                                <img src="' . $row["ImageURL"] . '" alt="' . $row["Title"] . '" style="width: 100px; margin-right: 20px;">
                                <span>' . $row["Title"] . ' - ' . $row["Author"] . '</span>
                            </div>
                            <div style="display: flex; align-items: center;">
                                <span>$' . $row["Price"] . ' x ' . $row["quantity"] . ' = $' . number_format($totalPrice, 2) . '</span>
                                <button onclick="removeItem(' . $row["BookID"] . ')" style="margin-left: 20px; background-color: transparent; border: none;">
                                    <i class="fas fa-trash-alt" style="color: grey; font-size: 20px;"></i>
                                </button>
                            </div>
                        </div>';
        }
    } else {
        $items = "Your cart is empty.";
    }
} else {
    $items = "Your cart is empty.";
}

$response = array("items" => $items, "subtotal" => number_format($subtotal, 2));
echo json_encode($response);

$conn->close();
?>
