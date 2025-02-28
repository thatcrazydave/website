<?php
session_start();
require 'config.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = ? AND reset_token_expiry > NOW()");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if (!$user) {
        $_SESSION['message'] = 'Invalid or expired token.';
        header('Location: forgot_password.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset'])) {
        $newPassword = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?");
        $stmt->execute([$newPassword, $user['id']]);
        $_SESSION['message'] = 'Your password has been reset successfully. You can now log in.';
        header('Location: login.php'); // Redirect to login page
        exit;
    }
} else {
    $_SESSION['message'] = 'No token provided.';
    header('Location: forgot_password.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-info"><?= $_SESSION['message'] ?></div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
        <h1>Reset Password</h1>
        <form method="POST" action="">
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="New Password" required>
            </div>
            <button type="submit" name="reset" class="btn btn-primary">Reset Password</button>
        </form>
    </div>
</body>
</html>


&& $hasSpecialChar