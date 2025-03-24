<?php
session_start();
require_once '../db/database.php'; // Your database connection file

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Fetch current user data
$userUid = $_SESSION['username'];
$stmt = $conn->prepare("SELECT * FROM users WHERE user_uid = ?");
$stmt->bind_param("s", $userUid);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Initialize variables
$error = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = $_POST['password'];

    // Initialize update array
    $updateFields = [];
    $params = [];
    $types = '';

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format';
    } elseif ($email === $user['user_email']) {
        $error = 'New email is the same as current email. Please enter a different email.';
    } else {
        $updateFields[] = "user_email = ?";
        $params[] = $email;
        $types .= 's';
    }

    // Validate username
    if (strlen($username) < 3) {
        $error = 'Username must be at least 3 characters';
    } elseif ($username === $user['user_uid']) {
        $error = 'New username is the same as current username. Please enter a different username.';
    } else {
        $updateFields[] = "user_uid = ?";
        $params[] = $username;
        $types .= 's';
    }

    // Handle password update
    if (!empty($password)) {
        // Check if new password is the same as current password
        if (password_verify($password, $user['user_pwd'])) {
            $error = 'New password cannot be the same as current password. Please enter a different password.';
        } elseif (strlen($password) < 8) {
            $error = 'Password must be at least 8 characters';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $updateFields[] = "user_pwd = ?";
            $params[] = $hashedPassword;
            $types .= 's';
        }
    }

    // Update database if no errors
    if (empty($error)) {
        if (!empty($updateFields)) {
            $params[] = $userUid;
            $types .= 's';

            $sql = "UPDATE users SET " . implode(', ', $updateFields) . " WHERE user_uid = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param($types, ...$params);

            if ($stmt->execute()) {
                $success = 'Profile updated successfully!';
                // Refresh user data
                $_SESSION['username'] = $username;
                header("Location: ../welcome.php");
                exit();
            } else {
                $error = 'Error updating profile: ' . $conn->error;
            }
        } else {
            $error = 'No changes made';
        }
    }
}

// Add a PHP script to prevent right clicking
echo '<script>document.addEventListener("contextmenu", function(event) { event.preventDefault(); });</script>';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Profile</title>

    <style>
        .container1 {
            padding-left: 15px;
            padding-right: 15px;
            margin-left: auto;
            margin-right: auto;
            max-width: 1170px; /* Added max-width */
        }

        a{
            text-decoration: none;
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
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        label{
            font-size: 1.2em;
            font-weight: 100;
        }
        form{
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container {
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-top: 20px;
            font-size: 2.5em;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .form-group input[type="email"],
        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: 100%;
            min-width: 350px;
            padding: 12px;
            border: 1px solid #ced4da;
            border-radius: 10px;
            box-sizing: border-box;
            font-size: 1em;
            color: #333;
        }

        .form-group input[type="email"]:focus,
        .form-group input[type="text"]:focus,
        .form-group input[type="password"]:focus {
            border-color: #007bff;
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.25);
        }

        button[type="submit"] {
            display: block;
            width: 45%;
            padding: 10px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1.25em;
            font-weight: 200;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-message {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.1em;
            font-weight: 600;
            color: #dc3545;
        }

        .success-message {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.1em;
            font-weight: 600;
            color: #28a745;
        }

        .back-button {
            position: absolute;
            top: 20px;
            left: 50px;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1.25em;
            font-weight: 200;
            transition: background-color 0.3s ease;
            padding: 10px 20px;
        }

        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <button class="back-button" onclick="history.back()">Profile</button>
    <div class="container">
        <h1>Update Profile</h1>

        <?php if ($error): ?>
            <div class="error-message"><?= $error ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success-message"><?= $success ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" placeholder="<?= htmlspecialchars($user['user_email']) ?>" value="" required autocomplete="off">
            </div>

            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" placeholder="<?= htmlspecialchars($user['user_uid']) ?>" value="" required autocomplete="off">
            </div>

            <div class="form-group">
                <label>New Password:</label>
                <input type="password" name="password" autocomplete="off">
            </div>

            <button type="submit">Update Profile</button>
        </form>
    </div>
</body>
</html>