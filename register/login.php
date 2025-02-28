<?php
session_start();

// Initialize errors array
$errors = [];

// Generate CSRF token if not already set
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Check if there are any errors in the session
if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
}

// Initialize username variable
$username = '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Global Styles */
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
        
        /* Container Styles */
        .container {
            padding-left: 15px;
            padding-right: 15px;
            margin-left: auto;
            margin-right: auto;
            max-width: 1170px;
        }
        
        /* Header Styles */
        header .container {
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
        header .links {
            display: flex;
            align-items: center;
        }
        
        /* Login Container Styles */
        .container1 {
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
        
        /* Form Styles */
        form {
            align-items: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        input[type="text"],
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
        
        /* Error Messages Styles */
        .error-message {
            color: #ff4d4d;
            font-size: 16px;
            font-weight: 600;
            text-align: center;
            padding: 15px;
            border: 1px solid #ff4d4d;
            border-radius: 5px;
            background-color: #ffe6e6;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            display: none;
            transition: all 0.3s ease-in-out;
        }

        .error-message.show {
            display: block;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="gen">
        <header>
            <div class="container">
                <a href="../index.php" class="logo">AP<b>OLO</b></a>
                <ul class="links">
                    <!-- Additional links can be added here -->
                </ul>
            </div>
        </header>
        <main>
            <section class="container1">
                <h2>Login</h2>
                <form action="logpro.php" method="POST" autocomplete="off" id="login-form" novalidate>
                    <input type="text" id="username" name="uid" placeholder="Username" required>
                    <br>
                    <input type="password" id="password" name="pwd" placeholder="Password" required>
                    <br>
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <button type="submit">Login</button>
                    <p>Don't have an account? <a href="signup.php">Sign up</a>.</p>
                </form>
                <?php if (!empty($errors)): ?>
                <div class="error-message show">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </section>
        </main>
    </div>
</body>
</html>