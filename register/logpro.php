<?php
// Start the session
session_start();

// Include the database connection
require_once '../db.php'; // Ensure this file contains the PDO connection to your database

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user inputs
    $username = trim($_POST['uid']);
    $password = trim($_POST['pwd']);

    // Validate inputs
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Username and password are required.";
        header('Location: login.php');
        exit();
    }

    // Check for admin login
    if ($username === "admin" && $password === "admin") {
        $_SESSION['user_id'] = "admin";
        $_SESSION['username'] = "qwertyxxx23:";
        header("Location: admin.php");
        exit();
    }

    // Check for regular user login
    try {
        // Prepare SQL statement
        $stmt = $pdo->prepare("SELECT * FROM users WHERE user_uid = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();

        // Verify password
        if ($user && password_verify($password, $user['user_pwd'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['user_uid'];

            // Redirect to dashboard
            header('Location: ../index.php');
            exit();
        } else {
            // Invalid login
            $_SESSION['error'] = "Invalid username or password.";
            header('Location: login.php');
            exit();
        }
    } catch (PDOException $e) {
        // Handle database errors
        $_SESSION['error'] = "An error occurred. Please try again later.";
        header('Location: login.php');
        exit();
    }
} else {
    // Invalid request method
    $_SESSION['error'] = "Invalid request method.";
    header('Location: login.php');
    exit();
}

// Close database connection
$pdo = null;
?>