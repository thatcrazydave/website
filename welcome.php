<?php
session_start();

// Add a PHP script to prevent right clicking
echo '<script>document.addEventListener("contextmenu", function(event) { event.preventDefault(); });</script>';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

$username = $_SESSION['username']; // Get the username from session

require_once 'headers/header2.php';

date_default_timezone_set('UTC');

function getGreeting() {
    $hour = date('H');
    $greetings = [
        'Good Morning' => $hour < 12,
        'Good Afternoon' => $hour >= 12 && $hour < 18,
        'Good Evening' => $hour >= 18,
    ];
    return array_search(true, $greetings);
}

$greeting = getGreeting();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
      /* Global Reset */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

/* Body Styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    padding: 15px;
    margin: 0;
    line-height: 1.6;
}

/* Content Container */
.content {
    max-width: 800px;
    width: 90%;
    margin: 50px auto;
    padding: 25px;
    background-color: #fff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    text-align: left;
}

/* Responsive Design */
@media (max-width: 768px) {
    .content {
        padding: 20px;
        margin: 30px auto;
    }
    h1, h2 {
        font-size: 1.5em;
    }
}

@media (max-width: 480px) {
    .content {
        padding: 15px;
        margin: 20px auto;
    }
    h1, h2 {
        font-size: 1.2em;
    }
}
.Top-details .Profile a {
    text-decoration: none;
    color: #000;
}
.Top-details .Profile{
    display: inline-block;
    margin: 10px;
    padding: 10px;
    border-radius: 10px;
    border: 1px solid #000;
    width: 100%;
}
.Low-details .Logout{
    display: inline-block;
    margin: 10px;
    padding: 10px;
    border-radius: 10px;
}
 .Logout {
    border: 1px solid blue;
    width: 10%;
    display: inline-block;
    margin: 10px;
    padding: 10px;
    border-radius: 10px;
}
.Logout p{
    width: 100%;

}
   
    </style>
</head>
<body>
<div class="content">
        <h1><?php echo $greeting . ', ' . htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>!</h1>
        <h2>Account Center</h2>
        <p>Manage your account information and settings.</p>
        <div class="Top-details">
            <h3>Account</h3>
            <div class="Profile">
                <!-- <i class="fas fa-cog"></i> -->
                <a href="../details.php"><p>Profile and information</p></a>
                <a href="register/update.php"><p>Update Information</p></a>
            </div>
        </div>
        <div class="Low-details">
            <div class ="Logout">
                <!-- <i class="fas fa-sign-out-alt"></i> -->
                <a href="register/logout.php"><p>Logout</p></a>
            </div>
        </div>
    </div>
</body>
</html>
