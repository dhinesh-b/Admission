<?php
/**
 * Reset Password Page – after OTP verification
 * Path: admin/reset_password.php
 */
session_start();
include("../database.php");

if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot_password.php");
    exit();
}

$error = '';

if (isset($_POST['reset'])) {
    $password = trim($_POST['password']);

    if (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        $new_pass = md5($password);  // Note: Use bcrypt/argon2 in production
        $email = $_SESSION['reset_email'];

        $update = $conn->query("UPDATE admin SET password='$new_pass' WHERE username='$email'");

        if ($update) {
            session_destroy();
            echo "<script>alert('Password reset successful'); window.location='admin.php';</script>";
        } else {
            $error = "Failed to update password. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --bg: #f3f4f6;
            --card-bg: #ffffff;
            --radius: 12px;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .card {
            background: var(--card-bg);
            width: 100%;
            max-width: 400px;
            padding: 2.5rem 2rem;
            border-radius: var(--radius);
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            animation: fadeIn 0.6s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 1rem;
            text-align: center;
        }
        p.desc {
            font-size: 0.9rem;
            color: #6b7280;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        input[type="password"] {
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: var(--radius);
            font-size: 0.95rem;
            outline: none;
            transition: box-shadow 0.2s;
        }
        input[type="password"]:focus {
            box-shadow: 0 0 0 3px rgba(79,70,229,0.3);
            border-color: var(--primary);
        }
        button {
            background: var(--primary);
            color: #fff;
            font-weight: 500;
            padding: 0.75rem 1rem;
            border: none;
            border-radius: var(--radius);
            cursor: pointer;
            transition: background 0.2s;
        }
        button:hover { background: var(--primary-hover); }
        .alert {
            background: #fee2e2;
            color: #b91c1c;
            padding: 0.75rem 1rem;
            border-radius: var(--radius);
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }
        .back-link {
            display: block;
            margin-top: 1rem;
            text-align: center;
            font-size: 0.85rem;
            color: var(--primary);
            text-decoration: none;
        }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Reset Password</h2>
        <p class="desc">Set a new password for your admin account.</p>
        <?php if ($error): ?>
            <div class="alert"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST" novalidate>
            <input type="password" name="password" placeholder="New Password" required />
            <button type="submit" name="reset">Reset Password</button>
        </form>
        <a href="admin.php" class="back-link">&larr; Back to Login</a>
    </div>
</body>
</html>
