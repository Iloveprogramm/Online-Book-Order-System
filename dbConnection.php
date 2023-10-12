<?php

if (!function_exists('getConnection')) {
    function getConnection() {
        $servername = "localhost";
        $username = "username";
        $password = "password";
        $dbname = "database";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }
}
?>
