<?php
function createDbConnection() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bookonlineorder";

    return new mysqli($servername, $username, $password, $dbname);
}
?>