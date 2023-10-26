<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elite Online Bookstore</title>
    <!-- Bootstrap 5 CSS, Icons, and Montserrat Font -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

    <style>
        /* Custom Styles */
        :root {
            --primary-color: #000;
            --secondary-color: #FFF;
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

        .card {
            border: none;
            transition: transform 0.3s;
            background: #f7f7f7;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card:hover {
            transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: var(--secondary-color);
        }

        .footer {
            background: var(--primary-color);
            color: var(--secondary-color);
            margin-top: auto;  
        }

        .book-image-wrapper {
            height: 250px;
            overflow: hidden;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        
        .category-card {
           width: 18%;
           border: 1px solid #eee;
           border-radius: 8px;
           padding: 15px;
           transition: 0.3s;
           text-align: center;
           box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .category-card:hover {
     transform: translateY(-5px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.category-card a {
    text-decoration: none;
    color: var(--primary-color);
}

.category-card i {
    margin-bottom: 10px;
}


.modal {
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
  background-color: #fefefe;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 60%;
  text-align: center;
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

    </style>
</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">BookQuartet</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="Main.php">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="welcome.html">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero-section">
    <h1>Welcome to BookQuartets</h1>
    <p>Your premium book destination</p>
</section>

<!-- Categories Navigation -->
<div class="container mt-4 mb-4">
    <h4 class="mb-3">Your Wishlist:</h4>
</div>


<!-- Main Content -->
<div class="container mt-5">
    <div class="row gy-4">
<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bookonlineorder";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection


    // Query to retrieve books wishlisted by the user
    $query = "SELECT * FROM shipping_companies";
    
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        echo "Error preparing statement: " . $conn->error;
        exit();
    }
    
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table id='shippingCompanyTable'>";
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
        
        while ($row = $result->fetch_assoc()) {
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
    } 
    else 
    {
        echo "No shipping companies found in the database.";
    }

    echo "<table>";
    echo "<tr>";
    echo "<td><input type='text' id='newCompanyName' placeholder='Company Name'></td>";
    echo "<td><input type='text' id='newCostPerKilo' placeholder='Cost per Kilo'></td>";
    echo "<td><input type='text' id='newPhoneNumber' placeholder='Phone Number'></td>";
    echo "<td><input type='text' id='newEmailAddress' placeholder='Email Address'></td>";
    echo "<td><input type='text' id='newAverageShippingTime' placeholder='Average Shipping Time'></td>";
    echo "<td><button onclick='addNewCompany()'>Add Company</button></td>";
    echo "</tr>";

    echo "</table>";

    //code here    

    $conn->close();
    ?>

    </div>
</div>
<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close" id="closeModal">&times;</span>
    <p id="statusMessage"></p>
  </div>
</div>

<script>
    var modal = document.getElementById("myModal"); // Declare modal outside the function

    // Close the modal when the close button is clicked
    var closeModalBtn = document.getElementById("closeModal");

    closeModalBtn.onclick = function() {
        modal.style.display = "none";
    };

    function removeFromDatabase(id) 
    {
        var xhr = new XMLHttpRequest();
        var url = "removeShippingCompany.php?id=" + id;
        xhr.open("GET", url, true);

        xhr.onreadystatechange = function() 
        {
            if (xhr.readyState === 4) 
            {
                var modal = document.getElementById("myModal");
                var statusMessage = document.getElementById("statusMessage");

                try 
                {
                    var response = JSON.parse(xhr.responseText);

                    if (response.status === "success") 
                    {
                        // Success message
                        statusMessage.innerHTML = response.message;
                        var rowToRemove = document.getElementById('row_' + id);
                        if (rowToRemove) 
                        {
                            rowToRemove.remove();
                        }
                    } 
                    else 
                    {
                        // Error or info message
                        statusMessage.innerHTML = response.message;
                    }
                } 
                catch (error) 
                {
                    // Handle JSON parsing error (unexpected response)
                    statusMessage.innerHTML = "Error: Unexpected response from the server.";
                }

                // Display the modal
                modal.style.display = "block";
            }
        };

        xhr.send();
    }

    function addNewCompany() 
    {
        var newCompanyName = document.getElementById('newCompanyName').value;
        var newCostPerKilo = document.getElementById('newCostPerKilo').value;
        var newPhoneNumber = document.getElementById('newPhoneNumber').value;
        var newEmailAddress = document.getElementById('newEmailAddress').value;
        var newAverageShippingTime = document.getElementById('newAverageShippingTime').value;

        var xhr = new XMLHttpRequest();
        var url = "addShippingCompany.php";  // Use a separate PHP file for adding companies
        var params = "CompanyName=" + newCompanyName +
                    "&CostPerKilo=" + newCostPerKilo +
                    "&PhoneNumber=" + newPhoneNumber +
                    "&EmailAddress=" + newEmailAddress +
                    "&AverageShippingTime=" + newAverageShippingTime;

        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() 
        {
            if (xhr.readyState === 4) 
            {
                var modal = document.getElementById("myModal");
                var statusMessage = document.getElementById("statusMessage");

                try 
                {
                    var response = JSON.parse(xhr.responseText);

                    if (response.status === "success") 
                    {
                        // Success message
                        statusMessage.innerHTML = response.message;

                        refreshTable();
                    } 
                    else 
                    {
                        // Error or info message
                        statusMessage.innerHTML = response.message;
                    }
                } 
                catch (error) 
                {
                    // Handle JSON parsing error (unexpected response)
                    statusMessage.innerHTML = "Error: Unexpected response from the server.";
                }

                // Display the modal
                modal.style.display = "block";
            }
        };
        xhr.send(params);
    }

    function refreshTable() 
    {
        var tableContainer = document.getElementById("shippingCompanyTable");
        var xhr = new XMLHttpRequest();
        var url = "retrieveCompanyInfo.php";

        xhr.open("GET", url, true);

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                tableContainer.innerHTML = xhr.responseText; // Update the table content with the updated data
            }
        };

        xhr.send();
    }
</script>


<!-- Footer -->
<footer class="footer py-3">
    <div class="container text-center">
        <span>&copy; 2023 BookQuartets. All Rights Reserved.</span>
    </div>
</footer>

<!-- Optional: Include Bootstrap 5 and Font Awesome Icons JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script>
</body>

</html>
