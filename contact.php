<?php
session_start(); // Start session to check login

$logged_in = false;
if (isset($_SESSION['user_id'])) {
    $logged_in = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>The Puttalam Men's Salon - Contact Us</title>
    <link rel="icon" href="./f.png">
    <style>
        /* Reset */
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
        }

        .nav-link:hover {
            color: #FFD700;
        }

        /* Glass container */
        .container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0,0,0,0.25);
            border-radius: 20px;
            width: 400px;
            max-width: 90%;
            padding: 50px;
            margin-top: 150px; /* Push below navbar */
            text-align: center;
            color: #F0F0F0;
        }

        .container h1 {
            font-size: 26px;
            margin-bottom: 10px;
            color: #FFD700;
        }

        .container hr {
            border: 1px solid #FFD700;
            margin-bottom: 20px;
        }

        .info p {
            font-size: 18px;
            margin: 10px 0;
            line-height: 1.6;
        }

        .info a {
            color: #FFD700;
            text-decoration: none;
        }

        .info a:hover {
            text-decoration: underline;
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

    <!-- Glass container -->
    <div class="container">
        <h1>Contact Us</h1>
        <hr>
        <div class="info">
            <p><b>Address:</b><br> Puttalam Town, Sri Lanka</p>
            <p><b>Phone:</b><br><a href="tel:+94779253920">+94 77 925 3920</a></p>
            <p><b>Email:</b><br><a href="mailto:puttalammen@gmail.com">puttalammen@gmail.com</a></p>
            <p><b>Opening Hours:</b><br>Mon - Sat: 9 AM - 8 PM</p>
        </div>
    </div>

</body>
</html>
