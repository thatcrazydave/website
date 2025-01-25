<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Braintrust</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const hamburger = document.querySelector('.navbar .hamburger');
            const navLinks = document.querySelector('.navbar .nav-links');

            hamburger.addEventListener('click', function () {
                hamburger.classList.toggle('active');
                navLinks.classList.toggle('active');
            });
        });
    </script>
    <style>
/* General Styles */
body {
    margin: 0;
    font-family: 'Roboto', sans-serif;
    line-height: 1.6;
}
a {
    text-decoration: none;
}
* {
    box-sizing: border-box;
}

/* Base Navbar Styles */
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    position: relative;
}

/* Logo Styling */
.navbar .logo {
    font-weight: 700;
    font-size: 1.5em;
    color: #000;
    text-decoration: none;
    margin-top: 5px;
}

/* Navigation Links Styling */
.navbar .nav-links {
    display: flex;
    align-items: center;
    list-style: none;
    margin: 0;
    padding: 0;
}

.navbar .nav-links a {
    text-decoration: none;
    color: #000;
    margin: 0 15px;
    font-weight: 500;
    transition: color 0.3s ease;
}

.navbar .nav-links a:hover {
    color: #555;
}

/* Button Styling */
.navbar .buttons a {
    padding: 10px 20px;
    border-radius: 5px;
    border: 1px solid #000;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.navbar .buttons .sign-up {
    background-color: #000;
    color: #fff;
}

.navbar .buttons a:hover {
    background-color: #555;
    color: #fff;
}

/* Hamburger Menu for Mobile */
.navbar .hamburger {
    display: none;
    flex-direction: column;
    cursor: pointer;
    margin-left: auto; /* Move hamburger to the right */
}

.navbar .hamburger .line {
    width: 25px;
    height: 3px;
    background-color: #000;
    margin: 4px 0;
    transition: transform 0.3s ease, opacity 0.3s ease;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .navbar {
        flex-direction: row; /* Keep the navbar in a row */
        align-items: center; /* Center items vertically */
    }

    .navbar .nav-links {
        display: none;
        flex-direction: column;
        width: 100%;
        position: absolute;
        top: 70px;
        left: 0;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .navbar .nav-links.active {
        display: flex;
    }

    .navbar .nav-links a {
        margin: 10px 0;
        text-align: center;
    }

    .navbar .buttons {
        display: none;
    }

    .navbar .hamburger {
        display: flex;
    }

    /* Hamburger Animation */
    .navbar .hamburger.active .line:nth-child(1) {
        transform: rotate(45deg) translate(5px, 5px);
    }

    .navbar .hamburger.active .line:nth-child(2) {
        opacity: 0;
    }

    .navbar .hamburger.active .line:nth-child(3) {
        transform: rotate(-45deg) translate(5px, -5px);
    }
}

/* Hero Section */
.hero {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #000;
    color: #fff;
    padding: 100px;
}

.hero .text {
    max-width: 50%;
}

.hero h1 {
    font-size: 3em;
    margin: 0 0 20px;
}

.hero p {
    font-size: 1.2em;
    margin: 0 0 20px;
}

.hero .button {
    padding: 15px 30px;
    background-color: #fff;
    color: #000;
    border-radius: 5px;
    text-decoration: none;
    font-weight: 700;
    transition: background-color 0.3s ease, color 0.3s ease ```css
}

.hero .button:hover {
    background-color: #555;
    color: #fff;
}

.hero img {
    border-radius: 10px;
    border: 3px solid #fff;
    max-width: 100%;
    /* height: 70%; */
}

/* Trusted Section */
.trusted {
    text-align: center;
    padding: 50px 20px;
    background-color: #f9f9f9;
}

.trusted p {
    font-size: 1.2em;
    margin-bottom: 30px;
}

.trusted img {
    max-width: 100px;
    margin: 0 15px;
    transition: transform 0.3s ease;
}

.trusted img:hover {
    transform: scale(1.1);
}

/* Footer */
.footer {
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 20px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .navbar {
        flex-direction: column;
        align-items: flex-start;
    }

    .navbar .buttons {
        margin-top: 10px;
    }

    .hero {
        flex-direction: column;
        text-align: center;
        padding: 30px;
    }

    .hero .text {
        max-width: 100%;
        margin-bottom: 20px;
    }

    .hero img {
        max-width: 100%;
        max-height: 50% ;
        height: 50%;
    }

    .trusted img {
        max-width: 80px;
        margin: 10px;
    }
}

@media (max-width: 480px) {
    .navbar a {
        margin: 0 10px;
    }

    .hero h1 {
        font-size: 2em;
    }

    .hero p {
        font-size: 1em;
    }

    .hero .button {
        padding: 10px 20px;
    }

    .trusted img {
        max-width: 60px;
    }
}
.top-img img{
    
    border-radius: 10px;
}
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">Braintrust</div>
        <div class="nav-links">
            <a href="#">Pricing</a>
            <a href="#">For Companies</a>
            <a href="#">For Talent</a>
            <a href="#">About Us</a>
            <a href="#">Blog</a>
        </div>
        <div class="buttons">
            <a class="log-in" href="login.php">Log in</a>
            <a class="sign-up" href="signup.php">Sign Up</a>
        </div>
        <div class="hamburger">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
    </div>
    <div class="hero">
        <div class="text">
            <h1>The all-in-one hiring solution</h1>
            <p>Hire top tech, design, and marketing talent to drive innovation and accelerate your projects. Our platform connects you with the best professionals in the industry, ensuring you have the expertise needed to succeed quickly and efficiently.</p>
            <a class="button" href="#">Book demo</a>
        </div class="top-img">
        <img alt="" height="400" src="img/3.jpg" width="600"/>
    </div>
    <div class="trusted">
        <p>Trusted by the world's leading enterprises</p>
        <img alt="" height="50" src="" width="100"/>
        <img alt="" height="50" src="" width="100"/>
        <img alt="" height="50" src="" width="100"/>
    </div>
    <div class="footer">
        <p>Braintrust</p>
    </div>
</body>
</html>
