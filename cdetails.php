<?php
session_start();
include("db.php");

// Admin check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch customer + appointment + service details
$sql = "SELECT c.id AS customer_id, c.name, c.email, c.phone, 
               a.booking_date, a.booking_time, s.service_name
        FROM customer c
        LEFT JOIN appointments a ON c.id = a.customer_id
        LEFT JOIN services s ON a.service_id = s.id
        ORDER BY c.id DESC, a.booking_date, a.booking_time";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Customer & Appointment Details | Admin</title>
<link rel="icon" href="./f.png">
<style>
    body {
        margin: 0;
        font-family: 'Verdana', sans-serif;
        background: linear-gradient(rgba(0,0,0,0.75), rgba(0,0,0,0.75)), url('./n.jpg') no-repeat center center fixed;
        background-size: cover;
        min-height: 100vh;
        color: #333;
    }
    .navbar {
        display: flex;
        justify-content: space-around;
        background: #040720;
        padding: 20px 0;  /* increased from 15px to 25px */
    }

    .nav-link {
        color: #FAF9F6;
        text-decoration: none;
        font-weight: bold;
        font-size: 20px;   /* increased font size */
        padding: 5px 10px; /* added padding around links */
    }

    .nav-link:hover {
        color: #FFD700;
    }
  
    .container {
        background: rgba(255,255,255,0.95);
        width: 95%;
        max-width: 1200px;
        margin: 80px auto 50px auto;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        overflow-x: auto;
    }
    h1 {
        text-align: center;
        color: #040720;
        margin-bottom: 30px;
        font-size: 36px;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
    }
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 16px;
        min-width: 900px;
    }
    th, td {
        padding: 12px 15px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }
    th {
        background-color: #040720;
        color: #fff;
        font-weight: bold;
    }
    tr:nth-child(even) { background-color: rgba(0,0,0,0.03); }
    tr:hover { background-color: #f0f0f0; }
    .button {
        background-color: #c0392b;
        color: white;
        padding: 6px 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    .button:hover { background-color: #e74c3c; }
</style>
</head>
<body>
    <nav class="navbar">
    <a href="admindashboard.php" class="nav-link">Dashboard</a>
    <a href="logout.php" class="nav-link">Log Out</a>
    </nav>
<div class="container">
    <h1>Customer & Appointment Details</h1>
    <table>
        <tr>
           
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Booking Date</th>
            <th>Booking Time</th>
            <th>Service Name</th>
            <th>Action</th>
        </tr>
        <?php if($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
            
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['phone']) ?></td>
                <td><?= $row['booking_date'] ?? '-' ?></td>
                <td><?= $row['booking_time'] ?? '-' ?></td>
                <td><?= $row['service_name'] ?? '-' ?></td>
                <td>
                    <a href="delete.php?id=<?= $row['customer_id'] ?>" class="button" onclick="return confirm('Are you sure you want to delete this customer?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="8">No customers found.</td>
            </tr>
        <?php endif; ?>
    </table>
</div>
</body>
</html>
<?php $conn->close(); ?>

