<?php

$servername = "127.0.0.1";
$username = "testuser";
$password = "TestPass123!"; 
$dbname = "bookonlineorder";

$conn = new mysqli($servername, $username, $password, $dbname);
?>

<!--
CREATE USER 'testuser'@'localhost' IDENTIFIED BY 'TestPass123!';

GRANT ALL PRIVILEGES ON bookonlineorder.* TO 'testuser'@'localhost';

FLUSH PRIVILEGES;
-->
