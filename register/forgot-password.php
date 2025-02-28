<?php
// Start the session
session_start();

// Include the database connection
require_once '../db.php'; // Ensure this file contains the PDO connection to your database

// Initialize an empty array to store error messages
$errors = array();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user inputs
    $username = trim($_POST['uid']);

    // Validate inputs
    if (empty($username)) {
        $errors[] = "Username is required.";
    }

    // Check for invalid username characters
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $errors[] = "Invalid username. Only alphanumeric characters are allowed.";
    }

    // Display errors
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['username'] = $username;
        header("Location: forgot-password.php");
        exit;
    }

    // Check if user exists
    php
    $stmt = $pdo->prepare("SELECT * FROM users WHERE user_uid = :username");
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user) {
        // Logic to send password reset email goes here
        $_SESSION['success'] = "A password reset link has been sent to your email.";
        header("Location: login.php");
        exit;
    } else {
        $errors[] = "No user found with that username.";
        $_SESSION['errors'] = $errors;
        header("Location: forgot-password.php");
        exit;
    }
}

// Close database connection
$pdo = null;
?>

<!-- Forgot Password Form -->
<form action="" method="post">
    <label for="uid">Username:</label>
    <input type="text" id="uid" name="uid" value="<?php echo $_SESSION['username']; ?>">
    <br>
    <input type="submit" value="Reset Password">
</form>

<!-- Display Error Messages -->
<?php if (isset($_SESSION['errors'])): ?>
    <div class="error-messages">
        <ul>
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>

<!-- Display Success Messages -->
<?php if (isset($_SESSION['success'])): ?>
    <div class="success-message">
        <?php echo $_SESSION['success']; ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>