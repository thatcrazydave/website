<?php
// Start the session to manage user login status
session_start();

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['username']); // Assuming 'username' is set upon login

// Include the appropriate navigation bar based on login status
if ($isLoggedIn) {
    include 'headers/header2.php'; // Navigation bar for logged-in users
} else {
    include 'headers/header.php'; // Navigation bar for logged-out users
}

// Handle logout action
if (isset($_GET['logout'])) {
    session_destroy(); // Destroy the session
    header("Location: index.php"); // Redirect to the homepage or login page
    exit(); // Ensure no further code is executed
}
?>
<!DOCTYPE html>
<html lang="en">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">

<head>
    <title>Site</title>
    <link rel="stylesheet" href="index.css">

</head>
<body>
  <div class="top-text">
    <h1>THAT GUY</h1>
  </div>
     
  </body>
</html>
