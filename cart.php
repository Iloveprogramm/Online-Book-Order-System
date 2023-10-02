<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Custom Styles */
        :root {
            --primary-color: #000;
            --secondary-color: hsl(0, 0%, 95%);
            --font: "Montserrat", sans-serif;
        }

        body {
            font-family: var(--font);
            background-color: var(--secondary-color);
            color: var(--primary-color);
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .navbar {
            background-color: var(--primary-color);
        }

        .navbar .nav-link, .navbar .navbar-brand {
            color: var(--secondary-color);
        }

        .navbar .nav-link:hover, .navbar .navbar-brand:hover {
            color: #aaa;
        }

        .hero-section {
            background: var(--primary-color);
            color: var(--secondary-color);
            text-align: center;
            padding: 50px 0;
        }

        .footer {
            background: var(--primary-color);
            color: var(--secondary-color);
            margin-top: auto;  
        }

        #cart {
            max-height: 500px;
            overflow-y: auto;
        }
    </style>
</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">BookQuartet</a>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero-section">
    <h1>Welcome to BookQuartets</h1>
    <p>Your premium book destination</p>
</section>

<!-- Cart Section -->
<section id="cart-section" style="padding: 50px 0;">
    <div class="container">
        <h2>Your Cart</h2>
        <div id="cart" style="background-color:hsl(0, 0%, 95%); padding: 20px;">
            <?php
            error_reporting(E_ALL);
            ini_set('display_errors', 1);

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "bookonlineorder";

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $cartId = $_COOKIE['cart_id'] ?? null;

            if ($cartId) {
                $sql = "SELECT c.quantity, b.BookID, b.Title, b.Author, b.Price, b.ImageURL 
        FROM cart c
        JOIN Books b ON c.book_id = b.BookID
        WHERE c.cart_id = '$cartId'";


                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; background-color: white; display: flex; justify-content: space-between; align-items: center;">';
echo '<div style="display: flex; align-items: center;">';
echo '<img src="' . $row["ImageURL"] . '" alt="' . $row["Title"] . '" style="width: 100px; margin-right: 20px;">';
echo '<span>' . $row["Title"] . ' - ' . $row["Author"] . '</span>';
echo '</div>';
echo '<div style="display: flex; align-items: center;">';
echo '<span>$' . $row["Price"] . ' x </span>';
echo '<button onclick="updateQuantity(' . $row["BookID"] . ', -1)" style="margin-right: 10px; background-color: transparent; border: none;">';
echo '<i class="fas fa-minus-circle" style="color: red; font-size: 20px;"></i>';
echo '</button>';
echo '<input type="text" id="quantity' . $row["BookID"] . '" value="' . $row["quantity"] . '" style="width: 40px; text-align: center; margin-right: 10px;" readonly />';
echo '<button onclick="updateQuantity(' . $row["BookID"] . ', 1)" style="margin-right: 20px; background-color: transparent; border: none;">';
echo '<i class="fas fa-plus-circle" style="color: green; font-size: 20px;"></i>';
echo '</button>';
echo '<button onclick="removeItem(' . $row["BookID"] . ')" style="background-color: transparent; border: none;">';
echo '<i class="fas fa-trash-alt" style="color: grey; font-size: 20px;"></i>';
echo '</button>';
echo '</div>';
echo '</div>';

                    }
                } else {
                    echo "Your cart is empty.";
                }
            } else {
                echo "Your cart is empty.";
            }

            $conn->close();
            ?>
        </div>
        <div id="checkout-section" style="margin-top: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 10px; border-bottom: 1px solid #ccc; margin-bottom: 20px;">
    <span style="font-weight: bold; font-size: 20px;">Subtotal</span>
    <span id="subtotal" style="font-size: 20px;">$0.00</span> <!-- 添加了 id="subtotal" -->
</div>
            <button style="background-color: rgb(3, 192, 255); border: none; color: white; padding: 10px 20px; font-size: 18px; cursor: pointer; width: 100%; margin-bottom: 20px;">Checkout</button>
            <div style="text-align: center; font-size: 12px; color: grey; margin-bottom: 10px;">Secured by BookQuartet</div>
            <div style="display: flex; justify-content: center;">
                <i class="fab fa-cc-paypal" style="font-size: 24px; margin-right: 10px; color: #0070ba;"></i>
                <i class="fab fa-cc-visa" style="font-size: 24px; margin-right: 10px; color: #1a1f71;"></i>
                <i class="fab fa-cc-mastercard" style="font-size: 24px; color: #eb001b;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer py-3">
    <div class="container text-center">
        <span>&copy; 2023 BookQuartets. All Rights Reserved.</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function removeItem(bookId) {
        if (confirm("Are you sure you want to remove this item from your cart?")) {
            $.get("remove_item.php", {book_id: bookId}, function(data) {
                if (data.status === "success") {
                    location.reload();
                } else {
                    alert("There was an error removing the item from your cart. Please try again.");
                }
            }, "json");
        }
    }

    function updateQuantity(bookId, change) {
        var quantityInput = document.getElementById('quantity' + bookId);
        var newQuantity = parseInt(quantityInput.value) + change;

        if (newQuantity < 1) {
            alert('Quantity cannot be less than 1');
            return;
        }

        quantityInput.value = newQuantity;

        // Send an AJAX request to update the quantity in the database
        $.post('update_quantity.php', {book_id: bookId, quantity: newQuantity}, function(data) {
            if (data.status === "success") {
                console.log('Quantity updated successfully');
                calculateSubtotal(); // 计算购物车总价
            } else {
                alert('There was an error updating the quantity. Please try again.');
            }
        }, "json");
    }

    function calculateSubtotal() {
        var total = 0;
        $('#cart > div').each(function() {
            var price = parseFloat($(this).find('span:nth-child(1)').text().substring(1)); // 获取单价
            var quantity = parseInt($(this).find('input[type="text"]').val()); // 获取数量
            total += price * quantity;
        });

        $('#subtotal').text('$' + total.toFixed(2)); // 更新总价
    }

    $(document).ready(function() {
        calculateSubtotal(); // 在页面加载时计算总价
    });
</script>
</body>
</html>
