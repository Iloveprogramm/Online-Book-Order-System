<?php
    function getConnection() {
        $servername = "localhost";
        $username = "id21490898_uts";
        $password = "Zcj030366*";
        $dbname = "id21490898_onlinebookorder";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
?>
