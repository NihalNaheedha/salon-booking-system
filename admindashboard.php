<?php
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || strtolower(trim($_SESSION['role'])) !== 'admin') {
    header("Location: login.php");
    exit();
}

// Get admin name from session
$admin_name = $_SESSION['admin_name'] ?? 'Admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | The Puttalam Men's Salon</title>
    <link rel="icon" href="./f.png">
    <style>
        body {
            margin: 0;
            font-family: 'Times New Roman', serif;
            background-image: linear-gradient(rgba(0,0,0,0.75), rgba(0,0,0,0.75)), url('./n.jpg');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .dashboard {
            background: white;
            padding: 40px 50px;
            border-radius: 20px;
            text-align: center;
            width: 450px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        }
        h1 {
            color: #040720;
            margin-bottom: 10px;
        }
        h3 {
            color: gray;
            margin-top: 0;
            margin-bottom: 20px;
        }
        p {
            color: #333;
        }
        .button {
            background-color: #040720;
            width: 300px;
            height: 40px;
            border: none;
            font-size: 14pt;
            color: white;
            border-radius: 5px;
            margin: 10px 0;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            line-height: 40px;
            transition: 0.3s;
        }
        .button:hover {
            background-color: gray;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <h1>Welcome, <?php echo htmlspecialchars($admin_name); ?>!</h1>
        <h3>The Puttalam Men's Salon</h3>
        <p>You are logged in as Admin.</p>
        <hr>
        <a href="addservices.php" class="button">Add, Edit, Delete Services</a>
        <a href="cdetails.php" class="button">View Customer Details</a>
        <a href="manageavailability.php" class="button">Manage Availability</a>
        <!-- Back button instead of logout -->
        <a href="index.php" class="button">Back</a>
    </div>
</body>
</html>
