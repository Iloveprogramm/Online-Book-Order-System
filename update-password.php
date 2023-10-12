<?php
    function updateUserPassword($user_id, $newPassword) {
        // Check if user_id is null
        if ($user_id === null) {
            return 'Not logged in';
        }

        // Check if the new password is empty
        if (empty($newPassword)) {
            return 'Password should not be empty';
        }

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bookonlineorder";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            return "Connection failed: " . $conn->connect_error;
        }

        // HASH-NEWPASSWORD
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // UPDATE NEWPASSWORD
        $query = "UPDATE UserTable SET password = ? WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $hashedPassword, $user_id);

        if ($stmt->execute()) {
            session_regenerate_id(true);  // UPDATE SESSIONID
            return 'success';
        } else {
            return 'Error: ' . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
?>