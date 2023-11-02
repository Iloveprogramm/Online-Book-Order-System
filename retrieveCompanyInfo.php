<?php
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bookonlineorder";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection


    $query = "SELECT * FROM shipping_companies";
    
    $stmt = $conn->prepare($query);
    
    if (!$stmt) 
    {
        echo "Error preparing statement: " . $conn->error;
        exit();
    }
    
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<table>";
    echo "<tr>
        <th>ID</th>
        <th>Company Name</th>
        <th>Date Added</th>
        <th>Cost per Kilo</th>
        <th>Phone Number</th>
        <th>Email Address</th>
        <th>Average Shipping Time</th>
        <th>Action</th>
      </tr>";

    while ($row = $result->fetch_assoc()) 
    {
        echo "<tr id='row_" . $row["id"] . "'>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["company_name"] . "</td>";
        echo "<td>" . $row["date_added"] . "</td>";
        echo "<td>" . $row["cost_per_Kilo"] . "</td>";
        echo "<td>" . $row["phone_number"] . "</td>";
        echo "<td>" . $row["email_address"] . "</td>";
        echo "<td>" . $row["average_shipping_time"] . "</td>";
        echo "<td><button onclick='removeFromDatabase(" . $row["id"] . ")'>Remove</button></td>";
        echo "</tr>";
    }
    echo "</table>";

    $conn->close();
?>