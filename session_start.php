<?php
session_start();

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $messageType = $_SESSION['message_type'];

    echo "<script>
        Swal.fire({
            icon: '$messageType',
            title: '$message',
            showConfirmButton: true
        });
    </script>";

    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}
?>
