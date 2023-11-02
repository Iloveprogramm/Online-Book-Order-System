<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(["success" => false, "error" => "No user is logged in."]);
    exit;
}

$sessionUsername = $_SESSION['username'];

$data = json_decode(file_get_contents("php://input"), true);
// Add debugging to see what's inside $data
error_log(print_r($data, true));

if (is_array($data) && isset($data['password'])) {
    $userPassword = $data['password'];
} else {
    echo json_encode(["success" => false, "error" => "Password key is missing or invalid."]);
    exit;
}

$servername = "localhost";
$dbUsername = "root";
$dbPassword = ""; 
$dbname = "bookonlineorder";

try {
    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT password FROM UserTable WHERE user_id = ?");
    $stmt->bind_param("s", $sessionUsername);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($userPassword, $row['password'])) {
            $stmt = $conn->prepare("DELETE FROM UserTable WHERE user_id = ?");
            $stmt->bind_param("s", $sessionUsername);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $_SESSION = array();
                session_destroy();
                echo json_encode(["success" => true]);
            } else {
                throw new Exception("Failed to delete account.");
            }
        } else {
            throw new Exception("Password is incorrect.");
        }
    } else {
        throw new Exception("Account not found.");
    }
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    } finally {
        if ($conn) {
            $conn->close();
        }
    }
?>
