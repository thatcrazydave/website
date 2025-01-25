<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}
// $mail = $_SESSION['mail'];
$username = $_SESSION['username']; // Get the username from session
require_once 'headers/header2.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
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
            width: 90%; /* More responsive width */
            margin: 50px auto;
            padding: 25px;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: left; /* Explicitly set text alignment */
        }

        /* Headings */
        h1, h2 {
            color: #333;
            margin-bottom: 20px;
            font-weight: 600; /* Added font weight for better readability */
        }

        /* Paragraphs */
        p {
            color: #666;
            margin-bottom: 20px;
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
        .details form{
            display: flex;
            flex-direction: column;
        }
        .details form input{
            margin: 10px 0;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 50%;
        }
    </style>
</head>
<body>
    <div class="content">
        <h2>Settings</h2>
        <p>Here you can manage your account settings and make changes.</p>
        <div class="details">
            <form action="" method="post">
            <br>
            <label for="">Fullname:</label>
            <input type="text" name="" id="">
            <br>
            <label for="">Email:</label>
            <input type="text" name="" id="">
            <br>
            <label for="">Username:</label>
            <input type="text" name="" id="">
            <!-- <br>
            <input type="text" name="" id="">
            <br>
            <input type="text" name="" id=""> -->
            
            </form>
        </div>
    </div>
</body>
</html>
