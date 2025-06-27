<?php
/**
 * Admin Forgot Password – OTP Mail (with PHPMailer)
 * Path: admin/forgot_password.php
 */
session_start();
include("../database.php");
require '../vendor/autoload.php'; // Composer autoload

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$error = '';

if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);

    // Basic validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email.";
    } else {
        // Prepared statement – prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $check = $stmt->get_result();

        if ($check->num_rows === 1) {
            // Generate and store OTP (consider hashing if saving to DB)
            $otp = random_int(100000, 999999);
            $_SESSION['otp'] = $otp;
            $_SESSION['reset_email'] = $email;

            // Send mail via PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'ssivan361@gmail.com';           // Gmail ID
                $mail->Password   = 'gnpolwbjiukittiq';               // 16-char App Password (no spaces!)
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                $mail->setFrom('noreply@yourdomain.com', 'Admin Portal');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Admin Password Reset OTP';
                $mail->Body    = "Hi Admin,<br><br>Your OTP is <b>{$otp}</b>. It is valid for 10 minutes.";

                $mail->send();
                header('Location: verify_otp.php');
                exit();
            } catch (Exception $e) {
                $error = 'Mailer Error: ' . $mail->ErrorInfo;
            }
        } else {
            $error = 'Email not found';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forgot Password – Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <style>
        :root {
            --primary: #4f46e5; /* indigo-600 */
            --primary-hover: #4338ca;
            --bg: #f3f4f6; /* gray-100 */
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
            color: #111827; /* gray-900 */
            margin-bottom: 1rem;
            text-align: center;
        }
        p.desc {
            font-size: 0.9rem;
            color: #6b7280; /* gray-500 */
            text-align: center;
            margin-bottom: 1.5rem;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        input[type="email"] {
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db; /* gray-300 */
            border-radius: var(--radius);
            font-size: 0.95rem;
            outline: none;
            transition: box-shadow 0.2s;
        }
        input[type="email"]:focus {
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
            background: #fee2e2; /* red-100 */
            color: #b91c1c;      /* red-700 */
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
        <h2>Forgot Password</h2>
        <p class="desc">Enter your admin email to receive an OTP.</p>
        <?php if ($error): ?>
            <div class="alert"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST" novalidate>
            <input type="email" name="email" placeholder="Admin Email" required />
            <button type="submit" name="submit">Send OTP</button>
        </form>
        <a href="admin.php" class="back-link">&larr; Back to Login</a>
    </div>
</body>
</html>
