<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <link rel="stylesheet" href="signup.css"> <!-- Link to your CSS file -->
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
            <h2>Signup</h2>
            <form action="indus.php" method="post" autocomplete="off">
                <input type="text" id="fullname" name="fullname" placeholder="Full name" required>
                <br>
                <input type="text" id="username" name="uid" placeholder="Username" required>
                <br>
                <input type="email" id="email" name="mail" placeholder="Email" required>
                <br>
                <input type="password" id="password" name="pwd" placeholder="Password" required>
                <br>
                <input type="password" id="confirm-password" name="pwdrepeat" placeholder="Confirm Password" required>
                <br>
                <button type="submit">Signup</button>
                <p >Already have an account? <a href="login.php">Login in</a>.</p>
            </form>
            
        </section>
    </main>
</div>
    <!-- <footer>
        <p>&copy; 2023 Your Website. All rights reserved.</p>
    </footer> -->
</body>
</html>