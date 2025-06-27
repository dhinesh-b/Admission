<?php
/**
 * Verify OTP Page – redirects to reset password if success
 * Path: admin/verify_otp.php
 */
session_start();

if (!isset($_SESSION['otp'])) {
    header("Location: forgot_password.php");
    exit();
}

$error = '';

if (isset($_POST['verify'])) {
    if ($_POST['otp'] == $_SESSION['otp']) {
        header("Location: reset_password.php");
        exit();
    } else {
        $error = 'Invalid OTP. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Verify OTP</title>
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
        input[type="text"] {
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: var(--radius);
            font-size: 0.95rem;
            outline: none;
            transition: box-shadow 0.2s;
        }
        input[type="text"]:focus {
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
        <h2>Verify OTP</h2>
        <p class="desc">Enter the 6-digit code sent to your email.</p>
        <?php if ($error): ?>
            <div class="alert"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST" novalidate>
            <input type="text" name="otp" placeholder="Enter OTP" required />
            <button type="submit" name="verify">Verify OTP</button>
        </form>
        <a href="forgot_password.php" class="back-link">&larr; Resend OTP</a>
    </div>
</body>
</html>