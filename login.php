<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="gen">
    <header>
        <div class="container">
           <a href="index.php" class="logo">AP<b>OLO</b></a>
            <ul class="links">
                <!-- <li><a href="#">Home</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Work</a></li>
                <li><a href="#">Info</a></li>
                <li><a href="signup.html">Get Started</a></li> -->
            </ul>
        </div>
    </header>
    <main>
        <section class="container1">
            <h2>Login</h2>
            <form action="logpro.php" method="POST" autocomplete="off">
                <input type="text" id="username" name="uid" placeholder="Username" required>
                <br>
                <input type="password" id="password" name="pwd" placeholder="Password" required>
                <br>
                <button type="submit">Login</button>
                <p >Don't have an account? <a href="signup.php">Sign up</a>.</p>
            </form>
            
        </section>
    </main>
</div>
    <!-- <footer>
        <p>&copy; 2023 Your Website. All rights reserved.</p>
    </footer> -->
</body>
</html>