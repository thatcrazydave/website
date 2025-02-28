<?php
session_start();
require 'config.php';
require 'vendor/autoload.php'; // Make sure to install PHPMailer via Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = 'Please enter a valid email address.';
        header('Location: forgot_password.php');
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $token = bin2hex(random_bytes(50));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE email = ?");
        $stmt->execute([$token, $expiry, $email]);

        $resetLink = "http://yourdomain.com/reset_password.php?token=$token";
        $body = "Click the following link to reset your password: <a href='$resetLink'>$resetLink</a>";

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.example.com'; // Your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'your_email@example.com'; // Your email
            $mail->Password = 'your_email_password'; // Your email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('your_email@example.com', 'Password Reset');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body = $body;

            $mail->send();
            $_SESSION['message'] = 'Password reset email sent! Please check your inbox.';
        } catch (Exception $e) {
            $_SESSION['message'] = 'Failed to send email. Please try again later.';
        }
    } else {
        $_SESSION['message'] = 'No account found with that email address.';
    }

    header('Location: forgot_password.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-info"><?= $_SESSION['message'] ?></div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
        <h1>Forgot Password</h1>
        <form method="POST" action="">
            <div class="form-group">
                <input type="email" name="email " class="form-control" placeholder="Enter your email" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Send Reset Link</button>
        </form>
    </div>
</body>
</html>