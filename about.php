<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <meta name="description" content="Learn more about our mission and team.">
    <meta name="keywords" content="about us, mission, team, contact">
    <meta name="author" content="Your Name">
</head>
<body>
    <?php include 'headers/header.php'; // Include the header ?>
    
    <section class="about-hero">
        <h1>About Us</h1>
        <p>Learn more about our mission and team.</p>
    </section>

    <section class="about-content">
        <h2>Our Mission</h2>
        <p>We are dedicated to providing the best service possible. Our mission is to create value for our customers and make a positive impact in our community.</p>

        <h2>Meet Our Team</h2>
        <div class="team-grid">
            <div class="team-member">
                <h3>John Doe</h3>
                <p>CEO</p>
                <img src="john-doe.jpg" alt="John Doe" class="team-member-image">
            </div>
            <div class="team-member">
                <h3>Jane Smith</h3>
                <p>CTO</p>
                <img src="jane-smith.jpg" alt="Jane Smith" class="team-member-image">
            </div>
            <div class="team-member">
                <h3>Emily Johnson</h3>
                <p>Marketing Manager</p>
                <img src="emily-johnson.jpg" alt="Emily Johnson" class="team-member-image">
            </div>
        </div>

        <h2>Contact Us</h2>
        <div class="contact-form">
            <form action="contpro.php" method="post" autocomplete="off" novalidate>
                <div class="form-group">
                    <label for="name">Your Name:</label>
                    <input type="text" id="name" name="name" placeholder="Your Name" required>
                </div>
                <div class="form-group">
                    <label for="email">Your Email:</label>
                    <input type="email" id="email" name="email" placeholder="Your Email" required>
                </div>
                <div class="form-group">
                    <label for="message">Your Message:</label>
                    <textarea id="message" name="message" placeholder="Your Message" required></textarea>
                </div>
                <button type="submit">Send Message</button>
            </form>
        </div>
    </section>

    <footer>
        <p>&copy; 2023 Your Company Name. All rights reserved.</p>
        <ul class="social-links">
            <li><a href="https://www.facebook.com/yourcompany" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
            <li><a href="https://www.twitter.com/yourcompany" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
            <li><a href="https://www.linkedin.com/company/yourcompany" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
        </ul>
    </footer>


</body>
</html>

<script>
        document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.contact-form form');
    const aboutContent = document.querySelector('.about-content');

    // Scroll animation for about content
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                aboutContent.classList.add('visible');
                observer.unobserve(entry.target); // Stop observing after it becomes visible
            }
        });
    });

    observer.observe(aboutContent); // Observe the about content section

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(form);
        fetch('submit_form.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Message sent successfully!');
                form.reset();
            } else {
                alert('There was an error sending your message. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('There was an error sending your message. Please try again.');
        });
    });
});
    </script>

    <style>
        /* Global Styles */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    color: #333;
    background-color: #f9f9f9;
    overflow-x: hidden; /* Prevent horizontal scroll */
}

h1, h2, h3, h4, h5, h6 {
    font-weight: bold;
    color: black;
}

h1 {
    font-size: 36px;
    margin-bottom: 1rem;
    font-weight: 200px;
}

h2 {
    font-size: 24px;
}

h3 {
    font-size: 18px;
}

p {
    font-size: 16px;
    margin-bottom: 1rem;
}

a {
    text-decoration: none;
    color: #6366f1;
}

a:hover {
    color: #4f46e5;
}

/* About Hero Section */
.about-hero {
    height: 50vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.9), rgba(139, 92, 246, 0.9)),
                url('https://source.unsplash.com/random/1920x1080') center/cover;
    color: white;
    flex-direction: column;
    padding: 2rem;
}

/* About Content Section */
.about-content {
    padding: 4rem 2rem;
    background-color: white;
    text-align: center;
    opacity: 0; /* Start hidden for animation */
    transform: translateY(20px); /* Start slightly lower */
    transition: opacity 0.6s ease, transform 0.6s ease; /* Transition for fade-in */
}

.about-content.visible {
    opacity: 1; /* Fully visible */
    transform: translateY(0); /* Move to original position */
}

.team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

.team-member {
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.3s; /* Add transition for hover effect */
}

.team-member:hover {
    transform: scale(1.05); /* Scale up on hover */
}

.team-member-image {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 10px 10px 0 0;
}

.contact-form {
    max-width: 600px;
    margin: 0 auto;
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 1.5rem;
}

input, textarea {
    width: 100%;
    padding: 0.8rem;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1rem;
}

button {
    background: #6366f1;
    color: white;
    padding: 1rem 2rem;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s;
}

button:hover {
    background: #4f46e5;
}

/* Footer Styles */
footer {
    background-color: #6366f1;
    color: white;
    text-align: center;
    padding: 1rem 0;
}

.social-links {
    list-style: none;
    padding: 0;
}

.social-links li {
    display: inline;
    margin: 0 10px;
}

.social-links a {
    color: white;
    font-size: 1.5rem;
}
    </style>