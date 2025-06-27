<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
        }
        .login-box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px #999;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }
        button {
            background: blue;
            color: white;
            padding: 10px;
            border: none;
            width: 105%;
            cursor: pointer;
        }
        button:hover {
            background: darkblue;
        }
    </style>
</head>
<body>
    <form class="login-box" action="admin.php" method="POST">
        <h2>Admin Login</h2>
        <input type="email" name="email" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
        <p style="text-align:right;">
    <a href="forgot_password.php">Forgot Password?</a>
</p>

    </form>
</body>
</html>

<?php
session_start();
include("../database.php");

if (isset($_POST['login'])) {
    $user = $_POST['email'];
    $pass = md5($_POST['password']);

    $query = "SELECT * FROM admin WHERE username='$user' AND password='$pass'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $_SESSION['admin'] = $user;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "<script>alert('Invalid credentials');</script>";
    }
}
?>
