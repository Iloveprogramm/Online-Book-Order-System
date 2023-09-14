<?php
session_start(); 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookonlineorder";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_POST["username"];
$password = $_POST["password"];

$stmt = $conn->prepare("SELECT * FROM UserTable WHERE user_id = ?");
$stmt->bind_param("s", $user_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    
    if (password_verify($password, $row["password"])) {
        $_SESSION['username'] = $row["user_id"]; 
        
        $redirectURL = str_ends_with($user_id, "@admin.com") ? "bookManagement.html" : "Main.php";
        
        echo json_encode([
            "status" => "success",
            "redirectURL" => $redirectURL
        ]);
        exit;
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Invalid password."
        ]);
        exit;
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid username."
    ]);
    exit;
}

$stmt->close();
$conn->close();
?>
