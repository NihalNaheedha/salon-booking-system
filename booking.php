<?php
session_start(); // start session
include("db.php"); // database connection

$logged_in = isset($_SESSION['user_id']); // check if any user is logged in

// Only allow customers
if (!$logged_in || $_SESSION['role'] !== 'customer') {
    die("<p style='color:red; text-align:center; font-size:18px;'>Access Denied. Please log in as a customer to book an appointment.</p>");
}

$customer_id = $_SESSION['user_id'];
$message = "";

// Fetch services for dropdown
$services = [];
$sql = "SELECT id, service_name FROM services ORDER BY service_name ASC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $services[] = $row;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_date = $_POST['date'];
    $booking_time = $_POST['time'];
    $service_id   = $_POST['service'];

    // Check if the selected time slot is blocked by admin
    $stmt_block = $conn->prepare("SELECT * FROM availability WHERE day=? AND start_time<=? AND end_time>=? AND status='closed'");
    $stmt_block->bind_param("sss", $booking_date, $booking_time, $booking_time);
    $stmt_block->execute();
    $blocked_result = $stmt_block->get_result();

    if ($blocked_result->num_rows > 0) {
        $message = "<p style='color:red; text-align:center;'>This slot is already booked. Please select another time.</p>";
    } else {
        // Check if slot is already booked
        $stmt_check = $conn->prepare("SELECT * FROM appointments WHERE booking_date=? AND booking_time=?");
        $stmt_check->bind_param("ss", $booking_date, $booking_time);
        $stmt_check->execute();
        $check_result = $stmt_check->get_result();

        if ($check_result->num_rows >= 3) {
            $message = "<p style='color:red; text-align:center;'>This slot is already booked. Please select another time.</p>";
        } else {
            // Insert appointment for customer
            $stmt_insert = $conn->prepare("INSERT INTO appointments (customer_id, booking_date, booking_time, service_id) VALUES (?, ?, ?, ?)");
            $stmt_insert->bind_param("issi", $customer_id, $booking_date, $booking_time, $service_id);

            if ($stmt_insert->execute()) {
                $message = "<p style='color:green; text-align:center;'>Appointment booked successfully! Thank you.</p>";
            } else {
                $message = "<p style='color:red; text-align:center;'>Error: " . $stmt_insert->error . "</p>";
            }
            $stmt_insert->close();
        }
        $stmt_check->close();
    }
    $stmt_block->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>The Puttalam Men's Salon</title>
    <link rel="icon" href="./f.png">
    <style>
        body {
            margin: 0;
            font-family: 'Times New Roman', serif;
            background-image: linear-gradient(rgba(0,0,0,0.75), rgba(0,0,0,0.75)), url(./n.jpg);
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
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
        .box {
            padding: 30px;
            margin-top: 100px;
            width: 35%;
            border-radius: 20px;
            background-color: #fff;
            text-align: center;
            line-height: 30px;
            color: #040720;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .Button {
            background-color: #040720;
            width: 200px;
            height: 40px;
            border: none;
            font-size: 14pt;
            color: white;
            border-radius: 5px;
            margin: 10px;
            cursor: pointer;
            transition: 0.3s;
        }
        .Button:hover {
            background-color: gray;
        }
        fieldset {
            background-color: #f0f0f0;
            border: none;
            border-radius: 10px;
            font-size: 14pt;
            text-align: left;
            padding: 20px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            font-size: 14pt;
            margin-top: 5px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #bbb;
        }
        .message {
            margin-bottom: 15px;
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

    <div class="box">
        <h2 style="font-family: 'Pristina';">Book Your Appointment</h2>
        <hr>
        <?php if (!empty($message)) echo "<div class='message'>{$message}</div>"; ?>
        <form method="POST" action="booking.php">
            <fieldset>
                <label for="service">Choose Service:</label>
                <select name="service" id="service" required>
                    <option value="">-- Select Service --</option>
                    <?php foreach ($services as $service): ?>
                        <option value="<?php echo htmlspecialchars($service['id']); ?>">
                            <?php echo $service['service_name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required min="<?php echo date('Y-m-d'); ?>">

                <label for="time">Time:</label>
                <select name="time" id="time" required>
                    <?php
                    $start = 9; $end = 19;
                    for ($h = $start; $h <= $end; $h++) {
                        for ($m = 0; $m < 60; $m += 15) {
                            $time = sprintf("%02d:%02d", $h, $m);
                            echo "<option value='$time'>$time</option>";
                        }
                    }
                    ?>
                </select>

                <p>Opening Hours: Mon - Sat: 9 AM - 8 PM</p>

                <input type="submit" value="Confirm Booking" class="Button">
            </fieldset>
        </form>
    </div>
</body>
</html>
