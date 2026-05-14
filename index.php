<?php
session_start(); // start session

$logged_in = false;
if (isset($_SESSION['user_id'])) {
    $logged_in = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>The Puttalam Men's Salon</title>
    <link rel="icon" href="./f.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Reset default margins */
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
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-around;
            background-color: #040720;
            padding: 15px 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 999;
        }

        .nav-link {
            color: #FAF9F6;
            text-decoration: none;
            font-size: 22px;
            font-weight: bold;
            transition: 0.3s;
        }

        .nav-link:hover {
            color: #FFD700;
        }

        /* Banner Section */
        .banner {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            padding-top: 15vh;
            padding-bottom: 5vh;
            width: 100%;
        }

        .banner h1 {
            font-family: Verdana, sans-serif;
            font-size: 48px;
            line-height: 1.2;
        }

        .banner h1 span {
            font-size: 80px;
            display: block;
        }

        .banner h2 {
            font-size: 24px;
            margin-top: 15px;
            font-weight: normal;
        }

        .book-btn {
            display: inline-block;
            margin-top: 30px;
            padding: 15px 30px;
            background-color: blue;
            color: white;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            border-radius: 8px;
            transition: 0.3s;
        }

        .book-btn:hover {
            background-color: gray;
        }

        /* Center container for Book Now button */
        .button-container {
            display: flex;
            justify-content: center;
            width: 100%;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <a href="index.php" class="nav-link">Home</a>
        <a href="about.php" class="nav-link">About Us</a>
        <a href="contact.php" class="nav-link">Contact</a>
        <a href="services.php" class="nav-link">Services</a>
        <?php if(!$logged_in): ?>
            <a href="login.php" class="nav-link">Login</a>
        <?php else: ?>
            <a href="logout.php" class="nav-link">Logout</a>
        <?php endif; ?>
    </nav>

    <!-- Banner -->
    <div class="banner">
        <h1>Welcome to<br><span>The Puttalam Men's Salon</span></h1>
        <h2>Your trusted destination for premium grooming.</h2>

        <?php if($logged_in): ?>
        <div class="button-container">
            <a href="booking.php" class="book-btn">Book Now</a>
        </div>
       <?php endif; ?>
       <?php if($logged_in): ?>
        <div class="button-container">
            <a href="myappointments.php" class="book-btn">My Appointments</a>
        </div>
       <?php endif; ?>
    </div>
</body>
</html>

