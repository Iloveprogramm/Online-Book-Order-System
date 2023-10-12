<?php
    session_start();

    function createDbConnection() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bookonlineorder";

        return new mysqli($servername, $username, $password, $dbname);
    }

    function loginUser($user_id, $password) {
        $conn = createDbConnection();

        if ($conn->connect_error) {
            return [
                "status" => "error",
                "message" => "Connection failed: " . $conn->connect_error
            ];
        }

        $stmt = $conn->prepare("SELECT * FROM UserTable WHERE user_id = ?");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            
            if (password_verify($password, $row["password"])) {
                $_SESSION['username'] = $row["user_id"]; 
                
                $redirectURL = str_ends_with($user_id, "@admin.com") ? "bookManagement.html" : "Main.php";
                
                $stmt->close();
                $conn->close();
                
                return [
                    "status" => "success",
                    "redirectURL" => $redirectURL
                ];
            } else {
                $stmt->close();
                $conn->close();
                
                return [
                    "status" => "error",
                    "message" => "Invalid password."
                ];
            }
        } else {
            $stmt->close();
            $conn->close();
            
            return [
                "status" => "error",
                "message" => "Invalid username."
            ];
        }

        $stmt->close();
        $conn->close();
    }

    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        echo json_encode(loginUser($_POST["username"], $_POST["password"]));
    }
?>