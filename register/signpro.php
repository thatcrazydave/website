<?php
// Include the database connection
require '../database.php';

// Function to check password complexity
function isPasswordComplex($password) {
    $minLength = 8; // Minimum length
    $maxLength = 20; // Maximum length
    $hasUppercase = preg_match('/[A-Z]/', $password); // At least one uppercase letter
    $hasLowercase = preg_match('/[a-z]/', $password); // At least one lowercase letter
    $hasNumber = preg_match('/[0-9]/', $password); // At least one number
    $hasSpecialChar = preg_match('/[\W_]/', $password); // At least one special character
    $lengthValid = strlen($password) >= $minLength && strlen($password) <= $maxLength;

    return $lengthValid && $hasUppercase && $hasLowercase && $hasNumber && $hasSpecialChar;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Start a session for error handling
    session_start();

    // Check for CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error_messages'][] = "Invalid CSRF token.";
        header("Location: signup.php");
        exit;
    }

    // Sanitize user inputs
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['uid']);
    $email = trim($_POST['mail']);
    $password = trim($_POST['pwd']);
    $passwordRepeat = trim($_POST['pwdrepeat']);

    // Validate inputs
    $errors = array();

    // Check for empty fields
    if (empty($fullname)) {
        $errors[] = "Full name is required.";
    }
    if (empty($username)) {
        $errors[] = "Username is required.";
    }
    if (empty($email)) {
        $errors[] = "Email is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }
    if (empty($passwordRepeat)) {
        $errors[] = "Repeat password is required.";
    }

    // Check for invalid username characters
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $errors[] = "Invalid username. Only alphanumeric characters are allowed.";
    }

    // Check for restricted usernames
    $restrictedUsernames = array("test", "admin", "user");
    if (in_array($username, $restrictedUsernames)) {
        $errors[] = "Username is restricted. Please choose a different username.";
    }

    // Check for invalid email characters
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Check for matching passwords
    if ($password !== $passwordRepeat) {
        $errors[] = "Passwords do not match.";
    }

    // Check password complexity
    if (!isPasswordComplex($password)) {
        $errors[] = "Password must be between 8 and 20 characters long, and include at least one uppercase letter, one lowercase letter, one number, and one special character.";
    }

    // Check if username already exists
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE user_uid = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($usernameCount);
    $stmt->fetch();
    $stmt->close();

    if ($usernameCount > 0) {
        $errors[] = "Username already exists. Please choose a different username.";
    }

    // Check if email has been used more than 3 times
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE user_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($emailCount);
    $stmt->fetch();
    $stmt->close();

    if ($emailCount >= 3) {
        $errors[] = "This email has been used too many times. Please use a different email.";
    }

    // If there are errors, store them in the session and redirect
    if (!empty($errors)) {
        $_SESSION['error_messages'] = $errors;
        header("Location: signup.php");
        exit;
    }

    // If no errors, proceed with user registration
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (user_fullname, user_uid, user_email, user_pwd) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fullname, $username, $email, $hashedPassword);
    $stmt->execute();
    $stmt->close();

    // Set success message and clear input data
    header("Location: login.php");
    exit;
}

?>