<?php
session_start();
include("db.php"); // your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if user exists
    $sql = "SELECT * FROM customer WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // If password is plain text (not hashed)
        if ($password === $row['password']) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];

            // Redirect based on role
            if (strtolower(trim($row['role'])) === 'admin') {
                header("Location: admindashboard.php");
                exit();


            } else {
                header("Location: index.php"); // salon system home
                exit();
            }
        } else {
            $error = "Invalid Password!";
        }
    } else {
        $error = "No account found with this email!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | The Puttalam Men's Salon</title>
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
        .login-box {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.2);
            width: 380px;
            text-align: center;
        }
        .login-box h1 {
            font-size: 22px;
            margin-bottom: 15px;
            color: #040720;
        }
        .login-box h2 {
            margin-bottom: 25px;
            font-size: 20px;
            color: #040720;
        }
        .login-box input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
        }
        .login-box button {
            width: 100%;
            padding: 12px;
            border: none;
            background: #040720;
            color: white;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }
        .login-box button:hover {
            background: gray;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
        .link {
            margin-top: 15px;
            font-size: 14px;
        }
        .link a {
            color: #040720;
            text-decoration: none;
            font-weight: bold;
        }
        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>The Puttalam Men's Salon</h1>
        <h2>Login Here</h2>
        <form method="post">
            <input type="email" name="email" placeholder="Enter Email" required>
            <input type="password" name="password" placeholder="Enter Password" required>
            <button type="submit">Login</button>
        </form>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <div class="link">
            <p>Don't have an account? <a href="register.php">Register here</a></p>
           

        </div>
    </div>
</body>
</html>
