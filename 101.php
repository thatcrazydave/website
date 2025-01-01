<?php
session_start();

// Mock user data (in a real application, this would be fetched from a database)
$currentUser  = [
    'username' => 'currentUsername',
    'email' => 'currentEmail@example.com',
];

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

// Handle form submission for updating profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Normally, you would validate and sanitize input here
    $username = $_POST['username'];
    $email = $_POST['email'];

    // Update user data in the database (mocked here)
    // In a real application, you would perform a database update here

    // Set a success message
    $successMessage = "Profile updated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>User Profile</h1>
        <?php if (isset($successMessage)): ?>
            <div class="success-message"><?php echo $successMessage; ?></div>
        <?php endif; ?>
        <form method="POST" id="profileForm">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($currentUser ['username']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($currentUser ['email']); ?>" required>
            </div>
            <button type="submit">Update Profile</button>
        </form>
        <button id="logoutButton">Logout</button>
    </div>

    <script src="script.js"></script>
</body>
</html>
<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
}

.container {
    max-width: 600px;
    margin: auto;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #333;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
    color: #555;
}

input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    transition: border-color 0.3s;
}

input:focus {
    border-color: #007bff;
    outline: none;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #218838;
}

.success-message {
    color: green;
    text-align: center;
    margin-bottom: 15px;
}

#logoutButton {
    background-color: #dc3545;
}

#logoutButton:hover {
    background-color: #c82333;
}
</style>
<script>
    document.getElementById('logoutButton').addEventListener('click', function() {
    if (confirm('Are you sure you want to log out?')) {
        // Redirect to logout window.location.href = 'logout.php'; // Redirect to your logout script
    }
});
</script>