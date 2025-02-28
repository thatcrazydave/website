<?php
session_start();
date_default_timezone_set('UTC');
$isLoggedIn = isset($_SESSION['username']);
if ($isLoggedIn) {
    include 'headers/header2.php'; 
} else {
    include 'headers/header.php';
}
function getGreeting() {
    $hour = date('H');
    if ($hour < 12) {
        return 'Good Morning';
    } elseif ($hour < 18) {
        return 'Good Afternoon';
    } else {
        return 'Good Evening';
    }
}
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $email = htmlspecialchars($_POST['email']);
//     if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
//         $_SESSION['success'] = "Thank you! You have successfully subscribed to our newsletter.";
//         header("Location: index.php");
//         exit();
//     } else {
//         $_SESSION['error'] = "Please enter a valid email address.";
//     }
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Community</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            line-height: 1.6;
            background-color: #f8f9fa;
        }
        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.9), rgba(139, 92, 246, 0.9)),
                url('https://source.unsplash.com/random/1920x1080') center/cover;
            color: white;
        }
        .hero-content {
            max-width: 800px;
        }
        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
        }
        .features {
            padding: 4rem 2rem;
            background-color: white;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .feature-card {
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
        .newsletter-section {
            padding: 4rem 2rem;
            background-color: #f8f9fa;
        }
        .newsletter-form {
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
        input {
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
        .success-message, .error-message {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 5px;
        }
        .success-message {
            background: #4CAF50;
            color: white;
        }
        .error-message {
            background: #f44336;
            color: white;
        }
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            .features-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <section class="hero" id="home">
        <div class="hero-content">
            <h1><?php echo getGreeting(); ?>, Welcome to Our Community!</h1>
            <p>Join us in creating something amazing together. Let's build, learn, and grow!</p>
            <button onclick="scrollToNewsletter()">Get Started</button>
        </div>
    </section>
    <section class="features" id="features">
        <div class="features-grid">
            <div class="feature-card">
                <h2>Collaborate</h2>
                <p>Work together with community members from around the world.</p>
            </div>
            <div class="feature-card">
                <h2>Learn</h2>
                <p>Access valuable resources and learning materials.</p>
            </div>
            <div class="feature-card">
                <h2>Grow</h2>
                <p>Develop your skills and advance your career with our support.</p>
            </div>
        </div>
    </section>
    <section class="newsletter-section" id="newsletter">
        <div class="newsletter-form">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="success-message"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php elseif (isset($_SESSION['error'])): ?>
                <div class="error-message"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>
            <h2>Subscribe to Our Newsletter</h2>
            <form method="POST" action="register/newsletter.php">
                <div class="form-group">
                    <input type="email" name="email" placeholder="Your Email" required>
                </div>
                <button type="submit">Subscribe</button>
            </form>
        </div>
    </section>
    <script>
        function scrollToNewsletter() {
            document.getElementById('newsletter').scrollIntoView({
                behavior: 'smooth'
            });
        }
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = 1;
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        });
        document.querySelectorAll('.feature-card').forEach((card) => {
            card.style.opacity = 0;
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.6s ease-out';
            observer.observe(card);
        });
        document.querySelector('form').addEventListener('submit', function(e) {
            const email = document.querySelector('input[name="email"]');
            if (!email.value.includes('@')) {
                e.preventDefault();
                alert('Please enter a valid email address');
            }
        });
    </script>
</body>
</html>
