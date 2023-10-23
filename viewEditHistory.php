<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #000;
            --secondary-color: #FFF;
            --accent-color: #007BFF;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f7f7;
            color: var(--primary-color);
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        h2 {
            text-align: center;
            margin-top: 30px;
            color: #000;
        }

        .navbar, .footer {
            background-color: var(--primary-color);
            color: var(--secondary-color);
        }

        .navbar .nav-link, .navbar .navbar-brand {
            color: var(--secondary-color);
            transition: color 0.3s;
        }

        .navbar .nav-link:hover, .navbar .navbar-brand:hover {
            color: var(--accent-color);
        }

        .footer {
            text-align: center;
            padding: 20px 0;
            margin-top: auto;
        }

        table {
            margin: 40px 0;
            width: 100%;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        th {
    background-color: #000;
    color: #FFF; 
}
        th, td {
            padding: 12px 15px;
            border: none;
        }

        tr:nth-child(odd) {
            background-color: #000;
        }

        tr:hover {
            background-color: #000;
        }

    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">BookQuartet</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="editBook.php">
                        <i class="fas fa-arrow-left"></i> Back to Edit Book
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<h2 class="animate__animated animate__fadeInDown">Books Edit History</h2>

<?php
    include 'db_config.php';
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = 'SELECT * FROM book_edit_history';
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<table id="editHistoryTable" class="table display">';
        echo '<thead><tr><th>Book ID</th><th>Old Value</th><th>New Value</th><th>Edit Timestamp</th></tr></thead>';
        echo '<tbody>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['book_id'] . '</td>';
            echo '<td>' . $row['old_value'] . '</td>';
            echo '<td>' . $row['new_value'] . '</td>';
            echo '<td>' . $row['edit_timestamp'] . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p class="text-center">No edit history found.</p>';
    }
    $conn->close();
?>

<!-- Footer -->
<footer class="footer">
    &copy; 2023 BookQuartet. All rights reserved.
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<script type="text/javascript">
    $(document).ready( function () {
        $('#editHistoryTable').DataTable({
            "pagingType": "full_numbers",
            "info": false,
            "lengthChange": false
        });
    });
</script>

</body>

</html>
