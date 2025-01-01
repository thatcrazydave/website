<?php
require 'database.php';
session_start();
$fullname = $_POST['fullname'];
$username = $_POST['uid'];
$email = $_POST['mail'];
$pwd = $_POST['pwd'];
$pwdRepeat = $_POST['pwdrepeat'];

if (!isset($_SESSION['mail'])) {
    $_SESSION['mail'] = $email;
}
$mail = $_SESSION['mail'];
//Error handlers
//Check for empty fields
if (empty($fullname) || empty($username) || empty($email) || empty($pwd) || empty($pwdRepeat)) {
    header("Location: signup.php?error=emptyfields&uid=".$username."&mail=".$email);
    exit();
}

//Check for invalid username characters
if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    header("Location: signup.php?error=invalidusername&mail=".$email);
    exit();
}

//Check for invalid email characters
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: signup.php?error=invalidemail&uid=".$username);
    exit();
}

//Check for matching passwords
if ($pwd !== $pwdRepeat) {
    header("Location: signup.php?error=passwordcheck&uid=".$username."&mail=".$email);
    exit();
}

//Hashing the password
$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

//Insert the new user into the database
$sql = "INSERT INTO users (user_uid, user_email, user_pwd, user_fullname) VALUES (?, ?, ?, ?);";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../signup.php?error=sqlerror");
    exit();
}

mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $hashedPwd, $fullname);
mysqli_stmt_execute($stmt);

//Redirect to the login page
header("Location: login.php?signup=success");
exit();

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>