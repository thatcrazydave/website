<?php
session_start();
require 'rate_limit.php';
require 'database.php';

// Get client IP address
function getClientIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

$currentIP = getClientIP();
$showPopup = false;

// Check if we should show the popup
if (!isset($_COOKIE['newsletter_closed']) && !isset($_SESSION['subscribed'])) {
    // Check IP in database
    try {
        $stmt = $conn->prepare("SELECT * FROM visitor_tracking WHERE ip_address = ?");
        if (!$stmt) {
            throw new Exception($conn->error);
        }
        $stmt->bind_param("s", $currentIP);
        if (!$stmt->execute()) {
            throw new Exception($stmt->error);
        }
        $result = $stmt->get_result();
        if (!$result) {
            throw new Exception($conn->error);
        }
        if ($result->num_rows === 0) {
            // New IP address - show popup
            $showPopup = true;
            // Record new visitor
            $conn->query("INSERT INTO visitor_tracking (ip_address) VALUES ('$currentIP')");
        } else {
            // Existing visitor - update tracking
            $conn->query("UPDATE visitor_tracking SET 
                last_visit = NOW(), 
                visit_count = visit_count + 1 
                WHERE ip_address = '$currentIP'");
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Handle newsletter form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['newsletter_email'])) {
    $email = filter_var($_POST['newsletter_email'], FILTER_SANITIZE_EMAIL);
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        try {
            $stmt = $conn->prepare("INSERT INTO newsletter_subscribers (email, ip_address) VALUES (?, ?)");
            if (!$stmt) {
                throw new Exception($conn->error);
            }
            $stmt->bind_param("ss", $email, $currentIP);
            if (!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $_SESSION['subscribed'] = true;
            setcookie('newsletter_closed', '1', time() + (86400 * 30), "/"); // 30 days
            echo "<script>alert('Thank you for subscribing!');</script>";
        } catch (mysqli_sql_exception $e) {
            echo "<script>alert('This email is already subscribed.');</script>";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

// Session timeout implementation code
if (!isset($_SESSION['LAST_ACTIVITY'])) {
    $_SESSION['LAST_ACTIVITY'] = time();
}
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // Last request was more than 30 minutes ago
    session_unset();     // Unset $_SESSION variables
    session_destroy();   // Destroy session data
    header('Location: login.php'); // Redirect to login page
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time();

// Start the session to manage user login status
date_default_timezone_set('UTC');

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['username']); // Assuming 'username' is set upon login

// Include the appropriate navigation bar based on login status
if ($isLoggedIn) {
    include 'headers/header2.php'; // Navigation bar for logged-in users
} else {
    include 'headers/header.php'; // Navigation bar for logged-out users
}

// Handle logout action
if (isset($_GET['logout'])) {
    session_destroy(); // Destroy the session
    header("Location: index.php"); // Redirect to the homepage or login page
    exit(); // Ensure no further code is executed
}

function getGreeting() {
    $hour = date('H');
    if ($hour < 12) {
        return 'Good Morning';
    } elseif ($hour < 12) {
        return 'Good Afternoon';
    } else {
        return 'Good Evening';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Welcome to Our Community</title>
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
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
        .feature-card h2 {
            color: black;
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
            padding: auto;
        }
        button:hover {
            background: #4f46e5;
        }
        button a {
            color: white;
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
        .newsletter-popup {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 300px;
            padding: 20px;
            background: white;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        .newsletter-popup.active {
            display: block;
        }
        .close-btn {
            float: right;
            cursor: pointer;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <section class="hero" id="home">
        <div class="hero-content">
            <h1><?php echo getGreeting(); ?>, Welcome to Our Community!</h1>
            <p>Join us in creating something amazing together. Let's build, learn, and grow!</p>
            <button onclick="scrollToNewsletter()"><a href="register/signup.php">Get Started</a></button>
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
            <form method="POST" action="">
                <div class="form-group">
                    <input type="email" name="newsletter_email" placeholder="Your Email" required autocomplete="off">
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
            const email = document.querySelector('input[name="newsletter_email"]');
            if (!email.value.includes('@')) {
                e.preventDefault();
                alert('Please enter a valid email address');
            }
        });

        // Show popup after 5 seconds if enabled
        <?php if ($showPopup): ?>
            setTimeout(() => {
                document.getElementById('newsletterPopup').classList.add('active');
            }, 2000);
        <?php endif; ?>

        function closeNewsletter() {
            document.getElementById('newsletterPopup').classList.remove('active');
            // Set cookie to remember dismissal for 30 days
            document.cookie = "newsletter_closed=1; max-age=" + (60*60*24*30) + "; path=/";
        }

        // Close popup on ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeNewsletter();
        });
    </script>

    <!-- Newsletter Popup -->
    <div id="newsletterPopup" class="newsletter-popup">
        <span class="close-btn" onclick="closeNewsletter()">&times;</span>
        <h3>Subscribe to Our Newsletter</h3>
        <form id="newsletterForm" method="POST" action="register/newsletter.php">
            <input type="email" name="newsletter_email" placeholder="Enter your email" required>
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <button type="submit">Subscribe</button>
        </form>
        <p><small>By subscribing, you agree to our <a href="/privacy">privacy policy</a>.</small></p>
    </div>
</body>
</html>