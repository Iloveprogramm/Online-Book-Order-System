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

        <div class="shipping-container">
            <div class="row gy-4">
                <?php

                    if (isset($_POST['itemQuantity'])) 
                    {
                        $numberOfItems = (int)$_POST['itemQuantity'];
                    } 
                    else 
                    {
                        $numberOfItems = 0; // Or another default value
                    }

                    
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "bookonlineorder";
                
                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    // Check connection
                
                    // Query to retrieve shipping companies
                    $query = "SELECT company_name, cost_per_Kilo, average_shipping_time FROM shipping_companies";
                    
                    $stmt = $conn->prepare($query);
                    
                    if (!$stmt) {
                        echo "Error preparing statement: " . $conn->error;
                        exit();
                    }
                    
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        echo "<table id='shippingCompanyTable'>";
                        echo "<tr>
                                <th>Company Name</th>
                                <th>Cost per Kilo</th>
                                <th>Average Shipping Time (days)</th>
                                <th>Select</th>
                            </tr>";
                        
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["company_name"] . "</td>";
                            echo "<td>" . $row["cost_per_Kilo"] . "</td>";
                            echo "<td>" . $row["average_shipping_time"] . "</td>";
                            echo "<td><input type='radio' name='selectedCompany' value='" . $row["company_name"] . "'></td>";
                            echo "</tr>";
                        }
                        
                        echo "</table>";
                        
                    } else {
                        echo "No shipping companies found in the database.";
                    }
                ?>
            </div>
        </div>


        <!-- Total Amount -->
        <div class="total-container">
            <strong>Total Amount:</strong>
            <?php
                $totalAmount = isset($_POST['totalAmount']) ? $_POST['totalAmount'] : "0.00";
                echo "$" . $totalAmount;
            ?>
        </div>

        
        <div id="shipping-cost">
            Shipping Cost: <span id="cost-value">$0.00</span>
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
                <input type="email" id="customerEmail" name="customerEmail" placeholder="example@example.com">
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
                $('#ripple-loader').css('display', 'none');
                if(response.status === 'success') {
                    $('#orderSuccessMessage').text('Order and payment details stored successfully!\nYour Order Number is: ' + response.orderNumber);

                   
                    $.get('clear_cart.php', function(clearCartResponse) {
                        if(clearCartResponse.status !== 'success') {
                            console.error('Failed to clear the cart');
                        }
                    }, 'json');

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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const shippingCompanyTable = document.getElementById("shippingCompanyTable");
        const costValue = document.getElementById("cost-value");

        // Add an event listener to the shipping company table to listen for changes in the selection
        shippingCompanyTable.addEventListener("change", function (event) {
            const selectedCompanyInput = event.target;
            
            if (selectedCompanyInput.type === 'radio' && selectedCompanyInput.checked) {
                const selectedCompany = selectedCompanyInput.value;
                const costPerKilo = parseFloat(
                    selectedCompanyInput
                        .closest("tr")
                        .querySelector("td:nth-child(2)")
                        .textContent
                );
                const numberOfItems = <?php echo $numberOfItems; ?>; // Get the number of items from PHP

                // Calculate the shipping cost
                const shippingCost = costPerKilo * numberOfItems;

                // Update the display
                costValue.textContent = "$" + shippingCost.toFixed(2);
            }
        });
    });
</script>

</body>
</html>