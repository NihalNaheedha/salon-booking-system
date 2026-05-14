<?php
session_start();
include("db.php"); // Database connection file

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user’s appointments
$sql = "SELECT a.id, a.booking_date, a.booking_time, s.service_name, s.price 
        FROM appointments a 
        JOIN services s ON a.service_id = s.id 
        WHERE a.customer_id = ?"; // corrected column name

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>My Appointments | The Puttalam Men's Salon</title>
    <link rel="icon" href="./f.png">
    <style>
        body {
            margin: 0;
            font-family: 'Times New Roman', serif;
            background-image: linear-gradient(rgba(0,0,0,0.75), rgba(0,0,0,0.75)), url(./n.jpg);
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            padding-top: 80px;
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
            box-shadow: 0 2px 6px rgba(0,0,0,0.5);
        }
        .nav-link {
            color: #FAF9F6;
            text-decoration: none;
            font-size: 20px;
            font-weight: bold;
        }
        .nav-link:hover {
            color: #FFD700;
        }
        h1 {
            text-align: center;
            color: #040720;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #040720;
            color: #fff;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            color: #555;
            font-size: 18px;
        }
        .back-button {
            display: block;
            width: 150px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background-color: #040720;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }
        .back-button:hover {
            background-color: #333a63;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <a href="index.php" class="nav-link">Home</a>
        <a href="myappointment.php" class="nav-link">My Appointments</a>
        <a href="logout.php" class="nav-link">Logout</a>
    </nav>

    <h1>My Booked Appointments</h1>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Service Name</th>
                    <th>Price (Rs.)</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . html_entity_decode($row['service_name']) . "</td>
                    <td>" . $row['price'] . "</td>
                    <td>" . $row['booking_date'] . "</td>
                    <td>" . $row['booking_time'] . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='no-data'>You have not booked any appointments yet.</p>";
    }

    $stmt->close();
    $conn->close();
    ?>

    <a href="index.php" class="back-button">Back to Home</a>
</body>
</html>
