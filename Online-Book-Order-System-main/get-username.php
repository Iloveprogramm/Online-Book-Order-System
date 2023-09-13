<?php
session_start();
if(isset($_SESSION['username'])) {
    echo "Hi, " . $_SESSION['username'];
} else {
    echo "No user is logged in.";
}
?>
