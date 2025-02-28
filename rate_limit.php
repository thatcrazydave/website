<?php
// Rate limiting function
function rateLimit($ipAddress) {
    $maxAttempts = 2; // Maximum allowed attempts
    $lockoutTime = 15 * 60; // Lockout time in seconds (15 minutes)

    // Check the number of attempts from the IP address
    $sql = "SELECT attempts, last_attempt FROM login_attempts WHERE ip_address = ?";
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false; // Database error
    }

    mysqli_stmt_bind_param($stmt, "s", $ipAddress);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $attempts, $lastAttempt);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Check if the user is locked out
    if ($attempts >= $maxAttempts && (time() - $lastAttempt) < $lockoutTime) {
        return false; // User is locked out
    }

    // Reset attempts if lockout time has passed
    if ($attempts >= $maxAttempts && (time() - $lastAttempt) >= $lockoutTime) {
        $sql = "UPDATE login_attempts SET attempts = 0 WHERE ip_address = ?";
        $stmt = mysqli_stmt_init($conn);
        
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            return false; // Database error
        }

        mysqli_stmt_bind_param($stmt, "s", $ipAddress);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    return true; // User is not locked out
}
?>