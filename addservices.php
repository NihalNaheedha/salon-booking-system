<?php
// Database connection
$dbserver = "localhost";
$dbuser = "root";
$dbuserpass = "";
$dbname = "puttalamsalon";

$conn = new mysqli($dbserver, $dbuser, $dbuserpass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize messages
$success = "";
$error = "";

// Handle Delete
if (isset($_GET['delete'])) {
    $del_id = (int)$_GET['delete'];
    if ($conn->query("DELETE FROM services WHERE id = $del_id")) {
        $success = "Service deleted successfully!";
    } else {
        $error = "Failed to delete: " . $conn->error;
    }
}

// Initialize edit variables
$edit_id = 0;
$edit_name = "";
$edit_price = "";
$edit_type = "";

// Handle Edit: pre-fill form
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $res = $conn->query("SELECT * FROM services WHERE id = $edit_id");
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $edit_name = $row['service_name'];
        $edit_price = $row['price'];
        $edit_type = $row['service_type'];
    }
}

// Handle Add / Update service
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_name = trim($_POST['service_name']);
    $service_type = trim($_POST['service_type']);
    $price_input  = trim($_POST['price']);

    if ($service_name === '') {
        $error = "Service name is required.";
    } elseif ($service_type === '') {
        $error = "Service type is required.";
    } elseif ($price_input === '' || !is_numeric($price_input)) {
        $error = "Price must be a number.";
    } else {
        $service_name = htmlspecialchars($service_name, ENT_QUOTES, 'UTF-8');
        $service_type = htmlspecialchars($service_type, ENT_QUOTES, 'UTF-8');
        $price = (float)$price_input;

        if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
            // Update existing service
            $update_id = (int)$_POST['edit_id'];
            $stmt = $conn->prepare("UPDATE services SET service_name=?, price=?, service_type=? WHERE id=?");
            $stmt->bind_param("sdsi", $service_name, $price, $service_type, $update_id);
            if ($stmt->execute()) {
                $success = "Service updated successfully!";
            } else {
                $error = "Update failed: " . $stmt->error;
            }
            $stmt->close();
        } else {
            // Add new service
            $stmt = $conn->prepare("INSERT INTO services(service_name, price, service_type) VALUES (?, ?, ?)");
            $stmt->bind_param("sds", $service_name, $price, $service_type);
            if ($stmt->execute()) {
                $success = "Service added successfully!";
            } else {
                $error = "Add failed: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}

// Fetch services for table
$sql = "SELECT * FROM services";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>The Puttalam Men's Salon</title>
    <link rel="icon" href="./f.png">
    <style>
        body{
           margin: 0;
           background: linear-gradient(rgba(0,0,0,0.75), rgba(0,0,0,0.75)), url('./n.jpg') no-repeat center center fixed;
           background-size: cover;
           min-height: 100vh;
           display: flex;
           justify-content: center;
           align-items: center;   
           flex-direction: column;
           font-family: Arial, sans-serif;
           color: #fff;
        }
        .button {
          background-color: #040720;
          width: 160px;
          height: 50px;
          border: none;
          font-size: 14pt;
          color: white;
          border-radius: 5px;
          margin: 5px;
          cursor: pointer;
          transition: 0.3s;
          text-decoration: none;
        }
        .button:hover {
          background-color: #333a63;
        }
        .text{
            width: 300px;
            border-radius: 5px;
            height: 25px;
            font-size: 12pt;
        }
        fieldset {
            background-color: rgba(255,255,255,0.9); 
            width:400px;
            padding:40px;
            text-align: center;
            border-radius: 40px 100px 40px 100px;
            font-weight: bold;
            margin-bottom: 30px;
            color: #000;
        }
        table {
            border-collapse: collapse;
            width: 80%;
            margin-bottom: 30px;
            background-color: rgba(255,255,255,0.85);
            color: #000;
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ccc;
        }
        th {
            background-color: #040720;
            color: #FFD700;
            font-weight: bold;
        }
        tr:nth-child(even) { background-color: rgba(200,200,200,0.3); }
        

        .edit{
            background-color:#040720;
            color:white;
            text-decoration:none;
            border-radius:30px;
            padding: 5px 10px;
            transition: 0.3s;
        }
        .edit:hover {
            background-color:#333a63;
        }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }

        .navbar {
            display: flex;
            justify-content: space-around;
            background-color: #040720;
            padding: 20px 0; /* a bit larger */
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 999;
        }
        .nav-link {
            color: #FAF9F6;
            text-decoration: none;
            font-size: 24px; /* slightly larger */
            font-weight: bold;
            font-family:'Times New Roman';
        }
        .nav-link:hover {
            color: #FFD700;
        }
    </style>
</head>
<body>
     <nav class="navbar">
        <a href="admindashboard.php" class="nav-link">Dashboard</a>
        <a href="logout.php" class="nav-link">Log Out</a>
    </nav>
    <br><br><br><br><br>
    <!-- Add / Edit Service Form -->
    <form action="addservices.php" method="POST">
        <fieldset>
            <h2><?php echo $edit_id ? "Edit Service" : "Add Service"; ?></h2>
            <hr size="2px" color="black">

            <?php if ($success): ?>
                <p class="success"><?php echo $success; ?></p>
            <?php endif; ?>
            <?php if ($error): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>

            Service Name:<br>
            <input type="text" name="service_name" required class="text" value="<?php echo htmlspecialchars($edit_name); ?>"><br><br>

            Price:<br>
            <input type="number" name="price" step="0.01" required class="text" value="<?php echo $edit_price; ?>"><br><br>

            Service Type:<br>
            <input type="text" name="service_type" required class="text" value="<?php echo htmlspecialchars($edit_type); ?>"><br><br>

            <?php if ($edit_id): ?>
                <input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>">
                <input type="submit" value="Update Service" class="button">
            <?php else: ?>
                <input type="submit" value="Add Service" class="button">
            <?php endif; ?>
            <input type="reset" value="Reset" class="button">
        </fieldset>
    </form>

    <!-- Service Table -->
    <h2>Our Services</h2>
    <?php
    if ($result->num_rows > 0) {
        echo "<table>
        <tr>
        <th>Service Name</th>
        <th>Price</th>
        <th>Service Type</th>
        <th>Actions</th>
        </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
            <td>{$row['service_name']}</td>
            <td>{$row['price']}</td>
            <td>{$row['service_type']}</td>
            <td>
                <a href='?edit={$row['id']}' class='edit'>Edit</a> &nbsp;&nbsp;
                <a href='?delete={$row['id']}' class='edit' onclick=\"return confirm('Are you sure?');\">Delete</a>
            </td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No services found</p>";
    }
    $conn->close();
    ?>
</body>
</html>
