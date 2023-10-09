<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="payment.css" rel="stylesheet">
</head>

<body>

<div class="payment-container">
    <div class="payment-box">
        <h2>Payment Details</h2>

        <!-- Items -->
        <div class="items-container">
            <strong>Items:</strong>
            <ul class="cart-item-list">
                <?php
                    if (isset($_POST['cartItemsHTML']) && !empty($_POST['cartItemsHTML'])) {
                        $items = explode('</div>', $_POST['cartItemsHTML']);  
                        foreach($items as $item) {
                            if(trim($item) != '') {  
                                echo '<li>' . $item . '</div></li>';
                            }
                        }
                    } else {
                        echo "<li>None</li>";
                    }                    
                ?>
            </ul>
        </div>

        <!-- Total Amount -->
        <div class="total-container">
            <strong>Total Amount:</strong>
            <?php
                $totalAmount = isset($_POST['totalAmount']) ? $_POST['totalAmount'] : "0.00";
                echo "$" . $totalAmount;
            ?>
        </div>

        <br>

        <!-- Payment Option -->
        <form action="store-payment.php" method="post" id="paymentForm">
        <input type="hidden" name="cartItemsHTML" value="<?php echo isset($_POST['cartItemsHTML']) ? htmlspecialchars($_POST['cartItemsHTML']) : ''; ?>">
        <input type="hidden" name="totalAmount" value="<?php echo isset($_POST['totalAmount']) ? htmlspecialchars($_POST['totalAmount']) : '0.00'; ?>">
            <div class="input-form">
                <label for="payment-option" class="form-label">Payment Option</label>
                <select id="payment-option" name="payment-method">
                    <option value="paypal">PayPal</option>
                    <option value="visa">Visa</option>
                    <option value="mastercard">MasterCard</option>
                </select>
            </div>

            <!-- Payment Details -->
            <div id="payment-details" style="display: none;">
                <!-- This will be filled by JavaScript based on payment method selection -->
            </div>

            <br>

            <button type="submit">Submit</button>
        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

    document.getElementById('payment-option').addEventListener('change', function() {
        var paymentOption = this.value;
        var paymentDetails = document.getElementById('payment-details');

        paymentDetails.innerHTML = '';

        if (paymentOption === 'visa' || paymentOption === 'mastercard') {
            paymentDetails.innerHTML += `
                <div class="input-form">
                    <label for="card-number" class="form-label">Card Number</label>
                    <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" required>
                </div>
                <div class="row">
                    <div class="col-md-6 input-form">
                        <label for="expiry" class="form-label">Expiry</label>
                        <input type="text" id="expiry" name="expiry" placeholder="MM/YY" required>
                    </div>
                    <div class="col-md-6 input-form">
                        <label for="cvc" class="form-label">CVC</label>
                        <input type="text" id="cvc" name="cvc" placeholder="123" required>
                    </div>
                </div>
            `;
            // Show the payment details section
            paymentDetails.style.display = 'block';
        }else {
            // Hide the payment details section if a different option is selected
            paymentDetails.style.display = 'none';
        }
    });

    $("#paymentForm").submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: 'store-payment.php', 
            type: 'post',
            data: $(this).serialize(),
            success: function(response) {
                alert(response);
            },
            error: function() {
                alert('An error occurred. Please try again.');
            }
        });
    });
</script>

</body>

</html>
