<?php
session_start(); // Start session to check login

$logged_in = false;
if (isset($_SESSION['user_id'])) {
    $logged_in = true;
}

// Database connection
$dbserver = "localhost";
$dbuser = "root";
$dbuserpass = ""; 
$dbname = "puttalamsalon";

$conn = new mysqli($dbserver, $dbuser, $dbuserpass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM services";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>The Puttalam Men's Salon - Services</title>
    <link rel="icon" href="./f.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Verdana', sans-serif;
            background: linear-gradient(rgba(0,0,0,0.75), rgba(0,0,0,0.75)), url('./n.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 100px; /* space for fixed navbar */
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-around;
            align-items: center;
            background-color: #040720;
            padding: 15px 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 999;
            box-shadow: 0 2px 6px rgba(0,0,0,0.5);
        }

        .nav-link {
            color: #FAF9F6;
            text-decoration: none;
            font-size: 20px;
            font-weight: bold;
            transition: color 0.3s;
        }

        .nav-link:hover {
            color: #FFD700;
        }

        h1 {
            text-align: center;
            color: #fff;
            font-weight: bold;
            margin: 30px 0;
            font-size: 36px;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.7);
        }

        /* Table container */
        .table-container {
            width: 90%;
            max-width: 1000px;
            margin-bottom: 50px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: rgba(255,255,255,0.95);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #040720;
            color: white;
            font-size: 18px;
        }

        tr:hover {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <a href="index.php" class="nav-link">Home</a>
        <a href="about.php" class="nav-link">About Us</a>
        <a href="contact.php" class="nav-link">Contact</a>
        <a href="services.php" class="nav-link">Services</a>
        <?php if($logged_in): ?>
            <a href="logout.php" class="nav-link">Logout</a>
        <?php else: ?>
            <a href="login.php" class="nav-link">Login</a>
        <?php endif; ?>
    </nav>

    <!-- Page title -->
    <h1>Our Services</h1>

    <!-- Table container -->
    <div class="table-container">
        <?php
        if ($result->num_rows > 0) {
            echo "<table>
            <tr>
                <th>Service Name</th>
                <th>Price</th>
                <th>Service Type</th>
            </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                <td>{$row['service_name']}</td>
                <td>{$row['price']}</td>
                <td>{$row['service_type']}</td>
                </tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='text-align:center; font-size:18px; color:white;'>No services found</p>";
        }
        $conn->close();
        ?>
    </div>

</body>
</html>
