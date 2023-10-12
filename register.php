<?php
    function registerUser($user_id, $raw_password, $Country, $City, $post_code, $shipping_Address) {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bookonlineorder";

        $conn = new mysqli($servername, $username, $password, $dbname);
        
        if ($conn->connect_error) {
            return [
                "status" => "error",
                "message" => "Connection failed: " . $conn->connect_error
            ];
        }

        // Check if the password is at least 3 characters long
        if (strlen($raw_password) < 3) {
            return [
                "status" => "error",
                "message" => "Password must be at least 3 characters long."
            ];
        }

        $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);
        $shipping_Address_Full = $Country . "," . $City . "," . $post_code . "," . $shipping_Address;

        // Prepare an SQL statement for inserting a new user into the UserTable
        $stmt = $conn->prepare("INSERT INTO UserTable (user_id, password, shipping_address) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $user_id, $hashed_password, $shipping_Address_Full);

        if ($stmt->execute() === TRUE) {
            return [
                "status" => "success",
                "message" => "Registration successful."
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Error: " . $stmt->error
            ];
        }

        $stmt->close();
        $conn->close();
    }

    if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
        echo json_encode(registerUser($_POST["username"], $_POST["password"], $_POST["Country"], $_POST["City"], $_POST["Postcode"], $_POST["shipping-address"]));
    }
?>