<?php
include("db.php"); // your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $phone    = $_POST['phone'];
    $password = $_POST['password'];

    // Always set role = "customer" when registering
    $role = "customer";

    // Insert into database
    $sql = "INSERT INTO customer (name, email, phone, password, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $email, $phone, $password, $role);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! Please login now.'); window.location='login.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Customer Registration | The Puttalam Men's Salon</title>
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
        .register-box {
    background: #fff;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
    width: 380px;
    border: 1px solid #ddd;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.register-box h2 {
    margin-bottom: 25px;
    text-align: center;
    color: #040720;
    font-size: 24px;
    font-weight: bold;
    border-bottom: 2px solid #ddd;
    padding-bottom: 10px;
}
.register-box input {
    width: 100%;
    padding: 12px;
    margin: 12px 0;
    border-radius: 6px;
    border: 1px solid #bbb;
    background: #f9f9f9;
    outline: none;
    transition: border 0.3s, box-shadow 0.3s;
}
.register-box input:focus {
    border: 1px solid #040720;
    box-shadow: 0 0 5px rgba(4, 7, 32, 0.4);
    background: #fff;
}
.register-box button {
    width: 100%;
    padding: 12px;
    border: none;
    background: #040720;
    color: white;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
    font-weight: bold;
    transition: background 0.3s, transform 0.2s;
}
.register-box button:hover {
    background: gray;
    transform: scale(1.02);
}
.login-link {
    margin-top: 15px;
    text-align: center;
    font-size: 14px;
    color: gray;
}
.login-link a {
    text-decoration: none;
    font-weight: bold;
    color: #040720;
    transition: color 0.3s;
}
.login-link a:hover {
    color: gray;
}



        
    </style>
</head>
<body>
    <div class="register-box">
        <h1> The Puttalam Men's Salon</h1>
        <h2>Create Account</h2>
        <form method="post">
            <input type="text" name="name" placeholder="Enter Name" required>
            <input type="email" name="email" placeholder="Enter Email" required>
            <input type="text" name="phone" placeholder="Enter Phone" required>
            <input type="password" name="password" placeholder="Enter Password" required>
            <button type="submit">Register</button>
        </form>
        <div class="login-link">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
</body>
</html>


