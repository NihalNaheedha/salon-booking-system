<?php
session_start(); // Start session

$logged_in = false;
if (isset($_SESSION['user_id'])) {
    $logged_in = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>The Puttalam Men's Salon - About Us</title>
    <link rel="icon" href="./f.png">
   
    <style>
        /* Reset default margins */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Verdana', sans-serif;
            background: linear-gradient(rgba(0,0,0,0.75), rgba(0,0,0,0.75)), url('./n.jpg');
            background-size: cover;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #C0C0C0;
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

        /* Glass content box */
        .glass-box {
            max-width: 900px;
            margin: 100px auto 50px auto; /* Push below navbar */
            padding: 30px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0,0,0,0.25);
            text-align: center;
        }

        .glass-box h3 {
            font-size: 32px;
            margin: 20px 0 10px 0;
        }

        .glass-box p {
            font-size: 20px;
            line-height: 1.6;
            margin: 10px 0;
            color: #F0F0F0;
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

    <!-- Glass content -->
    <div class="glass-box">
        <h3>Our Story</h3>
        <p>Founded seven years ago by Mr. Nasrulla, our salon has become a well-known place where men come to refresh their look and style with confidence. From classic haircuts to modern grooming services, we are dedicated to making every customer look sharp and feel great.</p>

        <p>We believe grooming is not just about appearance - it's about confidence and self-care. That's why our team focuses on delivering quality service, comfort, and a friendly atmosphere.</p>

        <p>With our new online appointment system, booking your haircut or grooming session is easier than ever. No more long waits - simply book online, choose your service, and walk in at your scheduled time.</p>

        <h3>💈 Our Mission</h3>
        <p>To provide professional grooming services with care, style, and convenience.</p>
    </div>
</body>
</html>
