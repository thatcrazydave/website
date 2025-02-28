<?php
session_start();

// Regenerate session ID to prevent session fixation attacks
if (!isset($_SESSION['initiated'])) {
    session_regenerate_id(true);
    $_SESSION['initiated'] = true;
}

// Validate the session ID
if (!isset($_COOKIE['session_id']) || $_COOKIE['session_id'] !== session_id()) {
    // Invalid session ID
    header("Location: login.php");
    exit;
}

// Additional security measures
// Set session cookie parameters
$cookieParams = session_get_cookie_params();
session_set_cookie_params([
    'lifetime' => $cookieParams['lifetime'],
    'path' => $cookieParams['path'],
    'domain' => $cookieParams['domain'],
    'secure' => true, // Ensure the cookie is sent over HTTPS
    'httponly' => true, // Prevent JavaScript access to session cookie
    'samesite' => 'Strict' // Prevent CSRF attacks
]);

// Check for session timeout
$timeout_duration = 1800; // 30 minutes
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset(); // Unset session variables
    session_destroy(); // Destroy the session
    header("Location: login.php");
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time(); // Update last activity time

// Check for IP address change to prevent session hijacking
if (!isset($_SESSION['IP_ADDRESS'])) {
    $_SESSION['IP_ADDRESS'] = $_SERVER['REMOTE_ADDR'];
} elseif ($_SESSION['IP_ADDRESS'] !== $_SERVER['REMOTE_ADDR']) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

// Check for user agent change to prevent session hijacking
if (!isset($_SESSION['USER_AGENT'])) {
    $_SESSION['USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
} elseif ($_SESSION['USER_AGENT'] !== $_SERVER['HTTP_USER_AGENT']) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}
?>