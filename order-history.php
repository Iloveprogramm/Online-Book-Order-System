<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #000;
            --secondary-color: hsl(0, 0%, 95%);
            --font: "Montserrat", sans-serif;
        }

        body {
            font-family: var(--font);
            background-color: var(--secondary-color);
            color: var(--primary-color);
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .navbar {
            background-color: var(--primary-color);
        }

        .navbar .nav-link, .navbar .navbar-brand {
            color: var(--secondary-color);
        }

        .navbar .nav-link:hover, .navbar .navbar-brand:hover {
            color: #aaa;
        }

        .hero-section {
            background: var(--primary-color);
            color: var(--secondary-color);
            text-align: center;
            padding: 50px 0;
        }

        .footer {
            background: var(--primary-color);
            color: var(--secondary-color);
            margin-top: auto;
        }

        .order-history-item {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            background-color: white;
            border-radius: 5px; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
        }

        .order-detail {
            padding: 5px 0;
            border-bottom: 1px solid #ccc;
            font-size: 20px;
            color: #555;
        }

        .order-detail:last-child {
            border-bottom: none;
        }


        .search-box {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 30px;
        }

        input[type="text"] {
            padding: 10px 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            flex-grow: 1; 
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: var(--primary-color);
            color: var(--secondary-color);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #444;
        }

        h2 {
            font-size: 1.75em;
            margin-bottom: 20px;
        }

        label {
            margin-right: 15px;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">BookQuartet</a>
    </div>
</nav>

<section class="hero-section">
    <h1>Welcome to BookQuartets</h1>
    <p>Your order history</p>
</section>

<section id="order-history-section" style="padding: 50px 0;">
    <div class="container">
        <h2>Your Order History</h2>
        <form action="order-history.php" method="get">
            <div class="search-box">
                <label for="orderNumber">Order Number:</label>
                <input type="text" id="orderNumber" name="orderNumber">
                <input type="submit" value="Search">
            </div>
        </form>

        <div id="order-history" style="background-color:hsl(0, 0%, 95%); padding: 20px; margin-top: 20px;">
        <?php
if (isset($_GET['orderNumber']) && !empty($_GET['orderNumber'])) {
    $orderNumber = $_GET['orderNumber'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bookonlineorder";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM Orders WHERE orderNumber = '$orderNumber'";


    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<br>';
            echo '<div class="order-history-item">';
            echo '<div class="order-detail"><i class="fas fa-receipt"></i> Order Number: ' . $row["orderNumber"] . '</div>';  // 添加了图标
            echo '<div class="order-detail"><i class="fas fa-calendar-alt"></i> Order Date: ' . $row["orderDate"] . '</div>'; // 添加了图标
        
            $items = json_decode(trim($row["items"], '"'), true);
            if (json_last_error() != JSON_ERROR_NONE) {
                echo 'JSON Error: ' . json_last_error_msg() . '<br>';
            }
            
            if ($items) {
                foreach ($items as $item) {
                    echo '<div class="order-detail"><i class="fas fa-book"></i> Item: '; 
                    echo $item["title"];
        
                    if (!empty($item["author"])) {
                        echo ' (' . $item["author"] . ')';
                    }
        
                    echo ' - $' . $item["price"] . ' x ' . $item["quantity"] . ' = $' . ($item["price"] * $item["quantity"]) . '</div>';
                }
            } else {
                echo '<div class="order-detail">No items found in this order.</div>';
            }
        
            echo '<div class="order-detail"><i class="fas fa-dollar-sign"></i> Total Amount: $' . $row["totalAmount"] . '</div>'; // 添加了图标
            echo '</div>';
        }
        
        
    } else {
        echo "No order found with this order number.";
    }

    $conn->close();
}
?>
        </div>
    </div>
</section>

<footer class="footer py-3">
    <div class="container text-center">
        <span>&copy; 2023 BookQuartets. All Rights Reserved.</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>
</html>