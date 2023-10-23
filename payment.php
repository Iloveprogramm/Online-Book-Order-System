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
<div class="ripple-loader" id="ripple-loader">
    <div class="ripple"></div>
    <div class="ripple"></div>
    <div class="ripple"></div>
</div>


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
            <div id="payment-details" style="display: none;"></div>

            <br>

            <!-- Email Notification Option -->
            <div class="input-form">
                <input type="checkbox" id="notifyByEmail" name="notifyByEmail">
                <label for="notifyByEmail" class="form-label">Notify me by email</label>
            </div>

            <div id="emailField" style="display: none;" class="input-form">
                <label for="customerEmail" class="form-label">Email Address</label>
                <input type="email" id="customerEmail" name="customerEmail" placeholder="example@example.com" required>
            </div>

            <br>

            <button type="submit">Submit</button>
        </form>

    </div>
</div>

<!-- Custom modal -->
<div id="successModal" class="modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Success</h5>
      </div>
      <div class="modal-body">
        <p id="orderSuccessMessage">Order and payment details stored successfully!</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="continueButton">OK</button>
      </div>
    </div>
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
            paymentDetails.style.display = 'block';
        } else {
            paymentDetails.style.display = 'none';
        }
    });

    $("#paymentForm").submit(function(e) {
        e.preventDefault();

        // Show the ripple loader
    $('#ripple-loader').css('display', 'block');

        $.ajax({
            url: 'store-payment.php',
            type: 'post',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                // Hide the ripple loader
            $('#ripple-loader').css('display', 'none');
                if(response.status === 'success') {
                    $('#orderSuccessMessage').text('Order and payment details stored successfully!\nYour Order Number is: ' + response.orderNumber);

                    var successModal = new bootstrap.Modal(document.getElementById('successModal'), {
                        keyboard: false,
                        backdrop: 'static'
                    });
                    successModal.show();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                // Hide the ripple loader and show an error message
            $('#ripple-loader').css('display', 'none');
            alert('An error occurred. Please try again.');
            }
        });
    });

    $('#continueButton').click(function() {
        window.location.href = 'EditShipping.html';
    });

    $('#notifyByEmail').change(function() {
        if($(this).prop('checked')) {
            $('#emailField').show();
        } else {
            $('#emailField').hide();
        }
    });
</script>

</body>
</html>
