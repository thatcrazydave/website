<div class="landing-page">
        <header>
            <div class="container">
               <a href="#" class="logo">AP<b>OLO</b></a>
                <ul class="links">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Work</a></li>
                    <li><a href="#">Info</a></li>
                    <li><a href="register/login.php">Get Started</a></li>
                </ul>
            </div>
        </header>
</div>
<style>
/* Start Global Rules */
* {
    box-sizing: border-box;
}
body {
    font-family: 'Open Sans', sans-serif;
}
a {
    text-decoration: none;
    
}

ul {
    list-style: none;
    padding: 0;
    margin: 0;
}
.container {
    padding-left: 15px;
    padding-right: 15px;
    margin-left: auto;
    margin-right: auto;
    max-width: 1170px; /* Added max-width */
}
/* Small */
@media (min-width: 768px) {
    .container {
        width: 750px;
    }
}
/* Medium */
@media (min-width: 992px) {
    .container {
        width: 970px;
    }
}
/* Large */
@media (min-width: 1200px) {
    .container {
        width: 1170px;
    }
}
/* End Global Rules */

/* Start Landing Page */
.landing-page header {
    min-height: 80px;
    display: flex;
}
@media (max-width: 767px) {
    .landing-page header {
        min-height: auto;
        display: initial;
    }
}
.landing-page header .container {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
@media (max-width: 767px) {
    .landing-page header .container {
        flex-direction: column;
        justify-content: center;
    }
}
.landing-page header .logo {
    color: #5d5d5d;
    font-style: italic;
    text-transform: uppercase;
    font-size: 20px;
}
@media (max-width: 767px) {
    .landing-page header .logo {
        margin-top: 20px;
        margin-bottom: 20px;
    }
}
.landing-page header .links {
    display: flex;
    align-items: center;
}
@media (max-width: 767px) {
    .landing-page header .links {
        text-align: center;
        gap: 10px;
    }
}
.landing-page header .links li {
    margin-left: 30px;
    color: #5d5d5d;
    cursor: pointer;
    transition: .3s;
}
@media (max-width: 767px) {
    .landing-page header .links li {
        margin-left: auto;
    }
}
.landing-page header .links li:last-child {
    border-radius: 20px;
    padding: 10px 20px;
    color: #FFF;
    background-color: #6c63ff;
}
.landing-page header .links li a{
    color: black;
}

.landing-page header .links li:not(:last-child):hover {
    color: #6c63ff;
}
.landing-page .content .container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 140px;
    min-height: calc(100vh - 80px);
}
@media (max-width: 767px) {
    .landing-page .content .container {
        gap: 0;
        min-height: calc(100vh - 101px);
        justify-content: center;
        flex-direction: column-reverse;
    }
}
@media (max-width: 767px) {
    .landing-page .content .info {
        text-align: center;
        margin-bottom: 15px;
    }
}
.landing-page .content .info h1 {
    color: #5d5d5d;
    font-size: 44px;
}
.landing-page .content .info p {
    margin: 0;
    line-height: 1.6;
    font-size: 15px;
    color: #5d5d5d;
}
.landing-page .content .info button {
    border: 0;
    border-radius: 20px;
    padding: 12px 30px;
    margin-top: 30px;
    cursor: pointer;
    color: #FFF;
    background-color: #6c63ff;
}
.landing-page .content .image img {
    max-width: 100%;
}
/* End Landing Page */

/* Additional Styles */
.info-og p {
    text-align: center;
    font-size: 50px;
    font-family: 'Montserrat';
    font-weight: 20px;
}
.line {
    border: none;
    height: 2px;
    background-color: black;
    width: 80%;
    margin: 20px auto;
    border-radius: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}
.image-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin: 30px;
}
.image-wrapper {
    position: relative;
    overflow: hidden;
}
.image-wrapper img {
    width: 100%;
    height: 300px;
    display: block;
    object-fit: cover;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}
h2 {
    color: #FFF;
    font-size: 17px;
    margin-bottom: 30px;
}

</style>
<style>
/* Hamburger Menu */
.hamburger {
    display: none;
    flex-direction: column;
    cursor: pointer;
    position: absolute;
    right: 15px;
    top: 20px;
}
.hamburger div {
    width: 25px;
    height: 3px;
    background-color: #333;
    margin: 4px 0;
    transition: 0.4s;
}
@media (max-width: 768px) {
    .hamburger {
        display: flex;
    }
    .landing-page header .links {
        display: none;
        flex-direction: column;
        width: 100%;
    }
    .landing-page header .links.active {
        display: flex;
    }
    .landing-page header .links li {
        margin: 10px 0;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.querySelector('.hamburger');
    const links = document.querySelector('.landing-page header .links');

    hamburger.addEventListener('click', function() {
        links.classList.toggle('active');
    });
});
</script>

<div class="hamburger">
    <div></div>
    <div></div>
    <div></div>
</div>