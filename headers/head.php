<header>
    <div class="container">
        <a href="#" class="logo">AP<b>OLO</b></a>
        <nav>
            <ul class="nav-links">
                <!-- <li><a href="#">Home</a></li>
                <li><a href="#">About Us</a></li> -->
                <li><a href="#">Work</a></li>
                <li><a href="#">Settings</a></li>
                <li><a href="logout.php">Log out</a></li>
            </ul>
            <div class="hamburger" id="hamburger">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
        </nav>
    </div>
</header>
<style>
  * {
    box-sizing: border-box;
}

body {
    font-family: 'Open Sans', sans-serif;
    margin: 0;
    padding: 0;
}

header {
    background-color: #fff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    position: sticky;
    top: 0;
    z-index: 1000;
}

.container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 30px;
    max-width: 1170px;
    margin: auto;
}

.logo {
    color: #6c63ff;
    font-size: 24px;
    text-decoration: none;
    font-weight: bold;
}

nav {
    display: flex;
    align-items: center;
}

.nav-links {
    list-style: none;
    display: flex;
    margin: 0;
    padding: 0;
}

.nav-links li {
    margin-left: 30px;
}

.nav-links a {
    text-decoration: none;
    color: #5d5d5d;
    transition: color 0.3s;
}

.nav-links a:hover {
    color: #6c63ff;
}

.hamburger {
    display: none;
    flex-direction: column;
    cursor: pointer;
}

.line {
    height: 3px;
    width: 25px;
    background-color: #5d5d5d;
    margin: 4px 0;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .nav-links {
        display: none;
        flex-direction: column;
        position: absolute;
        top: 60px;
        right: 0;
        background-color: #fff;
        width: 100%;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .nav-links.active {
        display: flex;
    }

    .hamburger {
        display: flex;
    }

    .nav-links li {
        margin: 15px 0;
        text-align: center;
    }
}
</style>
<script>
    const hamburger = document.getElementById('hamburger');
    const navLinks = document.querySelector('.nav-links');

    hamburger.addEventListener('click', () => {
        navLinks.classList.toggle('active');
    });
</script>