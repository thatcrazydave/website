<?php
session_start();
require 'database.php'; // Include your database connection file

// Retrieve form data
$fullname = $_POST['fullname'];
$username = $_POST['uid'];
$email = $_POST['mail'];
$pwd = $_POST['pwd'];
$pwdRepeat = $_POST['pwdrepeat'];

// Error handlers
// Check for empty fields
if (empty($fullname) || empty($username) || empty($email) || empty($pwd) || empty($pwdRepeat)) {
    header("Location: signup.php?error=emptyfields&uid=" . urlencode($username) . "&mail=" . urlencode($email));
    exit();
}

// Check for invalid username characters
if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    header("Location: signup.php?error=invalidusername&mail=" . urlencode($email));
    exit();
}

// Check for invalid email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: signup.php?error=invalidemail&uid=" . urlencode($username));
    exit();
}

// Check if passwords match
if ($pwd !== $pwdRepeat) {
    header("Location: signup.php?error=passwordcheck&uid=" . urlencode($username) . "&mail=" . urlencode($email));
    exit();
}

// Check if the username already exists
$sql = "SELECT user_uid FROM users WHERE user_uid = ?";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: signup.php?error=sqlerror");
    exit();
}

mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    header("Location: signup.php?error=usernametaken&mail=" . urlencode($email));
    exit();
}

// Hash the password
$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

// Insert the new user into the database
$sql = "INSERT INTO users (user_uid, user_email, user_pwd, user_fullname) VALUES (?, ?, ?, ?)";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: signup.php?error=sqlerror");
    exit();
}

mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $hashedPwd, $fullname);
mysqli_stmt_execute($stmt);

// Redirect to the login page with a success message
header("Location: login.php?signup=success");
exit();

mysqli_stmt_close($stmt);
mysqli_close($conn);