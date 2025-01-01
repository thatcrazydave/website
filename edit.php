<?php
session_start();
require 'db.php'; // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

// Get the username of the logged-in user
$username = $_SESSION['username'];

// Prepare and execute the SQL statement to fetch user data
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_uid = ?");
$stmt->execute([$username]);

// Fetch the result
$user = $stmt->fetch();

if (!$user) {
    $_SESSION['error'] = "No user found with that username.";
    header('Location: profile.php?No user found with that username.'); // Redirect to profile page
    exit();
}

$currentUser  = [
    'username' => $username,
    'email' => $user['email'],
];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    $newUsername = filter_input(INPUT_POST, 'uid', FILTER_SANITIZE_STRING);
    $newEmail = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'pwd', FILTER_SANITIZE_STRING);

    // Validate inputs
    if (empty($newUsername) || empty($newEmail) || empty($password)) {
        $_SESSION['error'] = "All fields are required.";
        header('Location: edit.php?All fields are required.');
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Update user data in the database
    try {
        $updateStmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, password = ? WHERE username = ?");
        $updateStmt->execute([$newUsername, $newEmail, $hashedPassword, $username]);

        // Update session data
        $_SESSION['username'] = $newUsername;

        // Set a success message
        $_SESSION['success'] = "Profile updated successfully!";
        header('Location: profile.php?Profile updated successfully!'); // Redirect to profile page
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "An error occurred while updating your profile.";
        header('Location: edit.php?An error occurred while updating your profile.');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="signm.css">
</head>
<body>
    <div class="container">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="success-message"><?php echo htmlspecialchars($_SESSION['success']); ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message"><?php echo htmlspecialchars($_SESSION['error']); ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <main>
            <section class="container1">
                <h2>Edit Details</h2>
                <form method="post" autocomplete="off">
                    <input type="text" id="username" name="uid" placeholder="<?php echo htmlspecialchars($currentUser ['username']); ?>" required>
                    <br>
                    <input type="email" id="email" name="mail" placeholder="<?php echo htmlspecialchars($currentUser ['email']); ?>" required>
                    <br>
                    <input type="password" id="password" name="pwd" placeholder="Password" required>
                    <br>
                    <button type="submit">Update</button>
                    <p>Already have an account? <a href="login.php">Login</a>.</p>
                </form>
            </section>
        </main>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="signm.css">
</head>
<body>
    <div class="container">
        <?php if (isset($successMessage)): ?>
            <div class="success-message"><?php echo $successMessage; ?></div>
        <?php endif; ?>
        <main>
            <section class="container1">
                <h2>Edit Details</h2>
                <form method="post" autocomplete="off">
                    <input type="text" id="fullname" name="fullname" placeholder="Full name" required>
                    <br>
                    <input type="text" id="username" name="uid" placeholder="<?php echo htmlspecialchars($currentUser['username']); ?>" required>
                    <br>
                    <input type="email" id="email" name="mail" placeholder="<?php echo htmlspecialchars($currentUser['email']); ?>" required>
                    <br>
                    <input type="password" id="password" name="pwd" placeholder="Password" required>
                    <br>
                    <button type="submit">Update</button>
                    <p>Already have an account? <a href="login.php">Login in</a>.</p>
                </form>
            </section>
        </main>
    </div>
</body>
</html>
