<?php
function createDbConnection() {
    $servername = "localhost";
$username = "id21490898_uts";
$password = "Zcj030366*";
$dbname = "id21490898_onlinebookorder";

    return new mysqli($servername, $username, $password, $dbname);
}
?>