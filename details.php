<?php
// dashboard.php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Database connection (example)
$user = [
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'avatar' => 'https://via.placeholder.com/150',
    'stats' => [
        'posts' => 45,
        'followers' => 234,
        'following' => 156
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        /* CSS */
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
        }

        .dashboard-container {
            display: grid;
            grid-template-columns: 250px 1fr;
            min-height: 100vh;
        }

        .sidebar {
            background: var(--dark-color);
            color: white;
            padding: 1rem;
            position: fixed;
            height: 100%;
            width: 250px;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 2rem;
        }

        .nav-menu {
            list-style: none;
        }

        .nav-item {
            margin: 0.5rem 0;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            padding: 0.75rem 1rem;
            border-radius: 5px;
            display: block;
            transition: background 0.3s;
        }

        .nav-link:hover,
        .nav-link.active {
            background: var(--primary-color);
        }

        .main-content {
            padding: 2rem;
            margin-left: 250px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        @media (max-width: 768px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="logo">Dashboard</div>
            <nav>
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="#" class="nav-link active" data-content="dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-content="profile">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-content="settings">Settings</a>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link">Logout</a>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <div class="header">
                <h1>Welcome, <?php echo $user['name']; ?></h1>
                <img src="<?php echo $user['avatar']; ?>" alt="Avatar" class="avatar">
            </div>

            <div id="dashboard-content" class="content-section">
                <div class="stats-container">
                    <div class="stat-card">
                        <h3>Posts</h3>
                        <p><?php echo $user['stats']['posts']; ?></p>
                    </div>
                    <div class="stat-card">
                        <h3>Followers</h3>
                        <p><?php echo $user['stats']['followers']; ?></p>
                    </div>
                    <div class="stat-card">
                        <h3>Following</h3>
                        <p><?php echo $user['stats']['following']; ?></p>
                    </div>
                </div>
            </div>

            <div id="profile-content" class="content-section" style="display: none;">
                <div class="stat-card">
                    <h2>Profile Information</h2>
                    <p>Name: <?php echo $user['name']; ?></p>
                    <p>Email: <?php echo $user['email']; ?></p>
                </div>
            </div>

            <div id="settings-content" class="content-section" style="display: none;">
                <div class="stat-card">
                    <h2>Account Settings</h2>
                    <form id="settings-form">
                        <div class="form-group">
                            <label>Email:</label>
                            <input type="email" value="<?php echo $user['email']; ?>">
                        </div>
                        <button type="submit" class="btn">Save Changes</button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        // JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.nav-link');
            const contentSections = document.querySelectorAll('.content-section');

            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Remove active class from all links
                    navLinks.forEach(l => l.classList.remove('active'));
                    // Add active class to clicked link
                    this.classList.add('active');
                    
                    // Hide all content sections
                    contentSections.forEach(section => {
                        section.style.display = 'none';
                    });
                    
                    // Show selected content section
                    const target = this.dataset.content;
                    document.getElementById(`${target}-content`).style.display = 'block';
                });
            });
        });
    </script>
    <style>
        
    </style>
</body>
</html>