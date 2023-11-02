<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link rel="stylesheet" href="userprofile.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="profile-container">
        <div class="header-container">
        <button type="button" class="delete-button" onclick="confirmDelete()">Delete Account</button>
        </div>
        <h1>User Profile</h1>
        <div class="username-display">
            <span id="username"></span>
        </div>
        <div class="profile-box">
            <form id="profile-form">
                <!-- User Information Section -->
                <div class="input-form">
                    <label for="old-password">Old Password:</label>
                    <input type="password" id="old-password" name="old-password" disabled placeholder="Enter old password">
                </div>
                <div class="input-form">
                    <label for="new-password">New Password:</label>
                    <input type="password" id="new-password" name="new-password" disabled placeholder="Enter new password">
                </div>
                <div class="input-form">
                    <label for="confirm-password">Confirm New Password:</label>
                    <input type="password" id="confirm-password" name="confirm-password" disabled placeholder="Confirm new password">
                </div>
                <!-- Payment Information Section -->
                <div class="input-form">
                    <label for="card-number">Card Number:</label>
                    <input type="text" id="card-number" name="card-number" disabled placeholder="Enter card number">
                </div>
                <div class="input-form">
                    <label for="expiry">Expiry:</label>
                    <input type="text" id="expiry" name="expiry" disabled placeholder="MM/YY">
                </div>
                <div class="input-form">
                    <label for="cvc">CVC:</label>
                    <input type="text" id="cvc" name="cvc" disabled placeholder="CVC">
                </div>
                <div class="button-container">
                    <button type="button" class="edit-button" onclick="editProfile()">Edit</button>
                    <button type="button" class="save-button" id="save-button" disabled onclick="saveChanges()">Save</button>
                </div>
            </form>
            <p><a href="Main.php">Back to Main Page</a></p>
        </div>
    </div>
    
    <script>
    $(document).ready(function() {
        $.get("get-username.php", function(data) {
            $("#username").text(data);
        });
        
        // Validate old password when it loses focus
        $('#old-password').blur(validateOldPassword);
    });

    function editProfile() {
        $('#old-password, #new-password, #confirm-password').prop('disabled', false);
        $('#card-number, #expiry, #cvc').prop('disabled', false);
        $('#save-button').prop('disabled', false);
    }

    function saveChanges() {
        console.log('saveChanges called');
        const oldPassword = $('#old-password').val();
        const newPassword = $('#new-password').val();
        const confirmPassword = $('#confirm-password').val();
        const userId = $('#username').text();
        const cardNumber = $('#card-number').val();
        const expiry = $('#expiry').val();
        const cvc = $('#cvc').val();

        // Check if password and payment sections are filled out correctly
        const passwordSectionFilled = oldPassword !== '' && newPassword !== '' && confirmPassword !== '';
        const paymentSectionFilled = cardNumber !== '' && expiry !== '' && cvc !== '';
        const sectionsEmpty = oldPassword === '' && newPassword === '' && confirmPassword === '' && cardNumber === '' && expiry === '' && cvc === '';

        if (sectionsEmpty) {
            alert('Please fill out fields for at least one section to update.');
            return;
        }

        if (!passwordSectionFilled && (oldPassword !== '' || newPassword !== '' || confirmPassword !== '')) {
            alert('Please fill out all password fields to update your password.');
            return;
        }

        if (!paymentSectionFilled && (cardNumber !== '' || expiry !== '' || cvc !== '')) {
            alert('Please fill out all payment fields to update your payment information.');
            return;
        }

        if (passwordSectionFilled && newPassword !== confirmPassword) {
            alert('New passwords do not match.');
            return;
        }

        if (passwordSectionFilled) {
            updatePassword(userId, oldPassword, newPassword);
        }

        if (paymentSectionFilled) {
            updatePaymentInfo(userId, cardNumber, expiry, cvc);
        }
    }

    function updatePassword(userId, oldPassword, newPassword) {
    $.post("update-password.php", { oldPassword: oldPassword, newPassword: newPassword, user_id: userId })
        .done(function(response) {
            response = typeof response === 'object' ? response : JSON.parse(response);

            if (response.success) {
                alert('Your password has been updated successfully!');
            } else {
                // Access the 'error' property of the response
                alert('There was an issue updating your password: ' + response.error);
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            alert('Error: Could not reach the server to update password.');
            console.error('AJAX Error:', textStatus, errorThrown);
        });
    }


    function updatePaymentInfo(userId, cardNumber, expiry, cvc) {
        // AJAX call to update the payment info
        $.post("update-payment.php", { user_id: userId, card_number: cardNumber, expiry: expiry, cvc: cvc })
            .done(function(response) {
                if (response.success) {
                    alert('Payment information updated successfully!');
                } else {
                    alert('Failed to update payment information: ' + response.error);
                }
            })
            .fail(function() {
                alert('Error: Could not reach the server to update payment information.');
            });
    }

        function validateOldPassword() {
            const oldPassword = $('#old-password').val();
            const userId = $('#username').text(); 
            
            $.post("validate-password.php", { oldPassword: oldPassword, user_id: userId })
                .done(function(response) {
                    if (response === 'success') {
                        $('#new-password, #confirm-password').prop('disabled', false);
                        $('#save-button').prop('disabled', false);
                    } else {
                        alert('Oopsie-daisy! That is not the right old password. Cannot switch it up yet.');
                        $('#new-password, #confirm-password').prop('disabled', true);
                        $('#save-button').prop('disabled', true);
                    }
                })
                .fail(function() {
                    alert('Uh-oh! Cannot reach the server right now.');
                });
        }

        function checkPasswordMatch() {
            const newPassword = $('#new-password').val();
            const confirmPassword = $('#confirm-password').val();

            if (newPassword !== confirmPassword) {
                alert('Aww, your passwords are not playing nice! Make them match to move on!');
            }
        }
        
        function confirmDelete() {
            var password = prompt("Please enter your password to confirm deletion:");
            if (password) {
                deleteAccount(password);
            }
        }

        function deleteAccount(password) {
            console.log("Password to send:", password);
    
            if (!password) {
                console.error('deleteAccount was called without a password.');
                return;
            }
            fetch('delete_account.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ password: password }),
            })
            .then(response => {
                if (response.ok) {
                    return response.text(); 
                }
                throw new Error('Network response was not ok.');
            })
            .then(text => {
                try {
                    // Try to parse it as JSON
                    const data = JSON.parse(text);
                    if (data.success) {
                        alert("Account deleted successfully.");
                        window.location.href = 'login.html';
                    } else {
                        alert("Error: " + data.error);
                    }
                } catch (e) {
                    // If an error occurs here, it means the response wasn't valid JSON
                    console.error("Could not parse JSON:", text);
                    alert("An error occurred while deleting the account. The server's response was not valid JSON.");
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                alert("An error occurred while deleting the account.");
            });
        }
    </script>
</body>
</html>