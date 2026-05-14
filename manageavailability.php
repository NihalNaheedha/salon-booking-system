<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "puttalamsalon";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// Handle form submission to block a time slot
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $day   = $_POST['day'];
    $start = $_POST['start_time'];
    $end   = $_POST['end_time'];

    // Insert into availability table
    $stmt = $conn->prepare("INSERT INTO availability (day, start_time, end_time, status) VALUES (?, ?, ?, 'closed')");
    $stmt->bind_param("sss", $day, $start, $end);

    if ($stmt->execute()) {
        $message = "Time slot blocked successfully.";

        // Delete existing appointments in this slot
        $stmt2 = $conn->prepare("DELETE FROM appointments WHERE booking_date=? AND booking_time BETWEEN ? AND ?");
        $stmt2->bind_param("sss", $day, $start, $end);
        $stmt2->execute();
        $stmt2->close();
    } else {
        $message = "Error blocking slot: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch all blocked slots
$slots = $conn->query("SELECT * FROM availability ORDER BY day, start_time");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Availability - Admin</title>
    <link rel="icon" href="./f.png">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: linear-gradient(rgba(0,0,0,0.75), rgba(0,0,0,0.75)), url(./n.jpg);
            background-size: cover;
            background-position: center;0FF;
        }

        .navbar {
            display: flex;
            justify-content: space-around;
            background: #040720;
            padding: 20px;
        }

        .nav-link {
            color: #FAF9F6;
            text-decoration: none;
            font-weight: bold;
        }

        .nav-link:hover {
            color: #FFD700;
        }

        .container {
            width: 400px;
            margin: 50px auto;
            background: #FAF9F6;
            padding: 30px;
            border-radius: 15px;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            font-size: 14pt;
        }

        button {
            padding: 10px;
            width: 100%;
            background: #040720;
            color: white;
            font-size: 14pt;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #333a63;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        th {
            background: #040720;
            color: white;
        }

        .success {
            color: green;
            text-align: center;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="admindashboard.php" class="nav-link">Dashboard</a>
        <a href="logout.php" class="nav-link">Log Out</a>
    </nav>

    <div class="container">
        <h2>Block a Time Slot</h2>
        <?php if($message) echo "<p class='success'>$message</p>"; ?>

        <form method="POST">
            <label>Day (YYYY-MM-DD):</label>
            <input type="date" name="day" required>

            <label>Start Time:</label>
            <input type="time" name="start_time" required>

            <label>End Time:</label>
            <input type="time" name="end_time" required>

            <button type="submit">Block Slot</button>
        </form>

        <h3>Blocked Slots</h3>
        <?php if($slots->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Day</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Status</th>
                </tr>
                <?php while($row = $slots->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['day'] ?></td>
                        <td><?= $row['start_time'] ?></td>
                        <td><?= $row['end_time'] ?></td>
                        <td><?= $row['status'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No blocked slots.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php $conn->close(); ?>
