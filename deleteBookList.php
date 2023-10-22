<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Books - BookQuartet</title>
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
            margin-top: auto;  /* Makes sure footer sticks to bottom */
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

        .btn-danger {
            background-color: #ff3b30;
            border-color: #ff3b30;
            color: #FFF;
        }

        .btn-danger:hover {
            background-color: #d92b21;
            border-color: #d92b21;
            color: #FFF;
        }

        .custom-checkbox {
            position: relative;
        }

        .custom-checkbox input[type="checkbox"] {
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            cursor: pointer;
            height: 100%;
            width: 100%;
        }

        .custom-checkbox .checkmark {
            position: relative;
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid #ddd;
            border-radius: 4px;
        }

        .custom-checkbox input[type="checkbox"]:checked ~ .checkmark {
            background-color: #f44336;
            border-color: #f44336;
        }

        .custom-checkbox .checkmark::after {
            content: "";
            position: absolute;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            transform: rotate(45deg);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: none;
        }

        .custom-checkbox input[type="checkbox"]:checked ~ .checkmark::after {
            display: block;
        }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">BookQuartet</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                <a class="nav-link" href="bookManagement.html">
                    <i class="fas fa-arrow-left"></i> Back to Book Management
                </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2>Delete Books</h2>
    <form action="deleteProcess.php" method="POST">
        <div class="row gy-4">
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "bookonlineorder";

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT BookID, Title, Author, Price, ImageURL, Category FROM Books";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4">';
                    echo '<div class="card h-100">';
                    echo '<div class="book-image-wrapper">';
                    echo '<img src="' . $row["ImageURL"] . '" class="card-img" alt="Book Cover">';
                    echo '</div>';
                    echo '<div class="card-body d-flex flex-column">';
                    echo '<input type="checkbox" name="booksToDelete[]" value="' . $row["BookID"] . '"> Delete';
                    echo '<h5 class="card-title">' . $row["Title"] . ' (' . $row["Category"] . ')</h5>';
                    echo '<p class="card-text">By: ' . $row["Author"] . '</p>';
                    echo '<button type="button" onclick="confirmDelete(' . $row["BookID"] . ')" class="btn btn-danger mt-auto">Delete</button>'; // 修改为type="button"
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "No books available to delete.";
            }
            ?>
        </div>
        <button type="submit" name="bulkDelete" class="btn btn-danger mt-3">Delete Selected</button>
    </form>
</div>

<script>
    // 这个函数用于显示删除确认提示
    function confirmDelete(bookId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = 'deleteProcess.php';

                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'bookIdToDelete';
                input.value = bookId;

                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        <?php
        if (isset($_SESSION['message'])):
        ?>
            Swal.fire({
                icon: '<?= $_SESSION['msg_type'] ?>',
                title: '<?= $_SESSION['message'] ?>',
                showConfirmButton: false,
                timer: 1500
            });
        <?php
            unset($_SESSION['message']);
            unset($_SESSION['msg_type']);
        endif;
        ?>
    });
</script>

            

<footer class="footer py-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <p class="text-center mb-0">© 2023 BookQuartet</p>
                </div>
            </div>
        </div>
    </footer>

    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
</body>

</html>