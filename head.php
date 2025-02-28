<header>
            <div class="container1">
                <a href="../index.php" class="logo">AP<b>OLO</b></a>
                <ul class="links">
                    <!-- <li><a href="#">Home</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Work</a></li>
                    <li><a href="#">Info</a></li>
                    <li><a href="signup.html">Get Started</a></li> -->
                </ul>
            </div>
        </header>
        <?php
        // Add a PHP script to prevent right clicking
echo '<script>document.addEventListener("contextmenu", function(event) { event.preventDefault(); });</script>';
        ?>
        <style>
            * {
    box-sizing: border-box;
}
body {
    font-family: 'Open Sans', sans-serif;
}
a{
    text-decoration: none;
}
ul {
    list-style: none;
    padding: 0;
    margin: 0;
}
.container1 {
    padding-left: 15px;
    padding-right: 15px;
    margin-left: auto;
    margin-right: auto;
    max-width: 1170px; /* Added max-width */
}
header .container1 {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 30px;
}
header .logo {
    color: #5d5d5d;
    font-style: italic;
    text-transform: uppercase;
    font-size: 20px;
}
header .container1 .links li {
    margin-left: 30px;
    color: #5d5d5d;
    cursor: pointer;
    transition: .3s;
}
header .links li:last-child {
    border-radius: 20px;
    padding: 10px 20px;
    color: #FFF;
    background-color: #6c63ff;
}
.landing-page header .links li:not(:last-child):hover {
    color: #6c63ff;
}
header .links {
    display: flex;
    align-items: center;
}
@media (max-width: 767px) {
    header .links {
        text-align: center;
        gap: 10px;
    }
}
.container11{
    width: 100%;
    max-width: 400px;
    margin: 50px auto;
    background: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    margin-top: 70px;
    align-items: center;
}
.gen{
    margin-top: 30px;
}
h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}
form {
    
    align-items: center;
    display: flex;
    flex-direction: column;
    align-items: center;
}
input[type="text"],
input[type="email"],
input[type="password"] {
    width: 80%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 10px;
    height: 40px;
}

button {
    width: 30%;
    padding: 10px;
    background-color: #5cb85c;
    border: none;
    border-radius: 4px;
    color: white;
    font-size: 16px;
    cursor: pointer;
    border-radius: 10px;
}

button:hover {
    background-color: #4cae4c;
}

.error {
    color: red;
    margin-top: 10px;
    text-align: center;
}
        </style>