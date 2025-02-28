<?php
// Start the session
session_start();

// Store the last activity timestamp
if (!isset($_SESSION['LAST_ACTIVITY'])) {
    $_SESSION['LAST_ACTIVITY'] = time();
}

// Check the last activity timestamp
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // Last request was more than 30 minutes ago
    session_unset();     // Unset $_SESSION variables
    session_destroy();   // Destroy session data
    header('Location: login.php'); // Redirect to login page
    exit;
}

// Update the last activity timestamp
$_SESSION['LAST_ACTIVITY'] = time();
?>