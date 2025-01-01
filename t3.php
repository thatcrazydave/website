<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <!-- <link rel="stylesheet" href="signup.css">  Link to your CSS file -->
</head>
<body>
    <div class="container">
        <main>
            <section class="signup-section">
                <h2>Sign Up</h2>
                <form action="indus.php" method="post" autocomplete="off">
                    <!-- Full Name -->
                    <input type="text" name="fullname" placeholder="Full Name" 
                           value="<?php echo isset($_GET['fullname']) ? htmlspecialchars($_GET['fullname']) : ''; ?>" required>
                    <br>
                    <!-- Username -->
                    <input type="text" name="uid" placeholder="Username" 
                           value="<?php echo isset($_GET['uid']) ? htmlspecialchars($_GET['uid']) : ''; ?>" required>
                    <br>
                    <!-- Email -->
                    <input type="email" name="mail" placeholder="Email" 
                           value="<?php echo isset($_GET['mail']) ? htmlspecialchars($_GET['mail']) : ''; ?>" required>
                    <br>
                    <!-- Password -->
                    <input type="password" name="pwd" placeholder="Password" required>
                    <br>
                    <!-- Repeat Password -->
                    <input type="password" name="pwdrepeat" placeholder="Repeat Password" required>
                    <br>
                    <!-- Submit Button -->
                    <button type="submit" name="signup-submit">Sign Up</button>
                </form>

                <!-- Display Error Messages -->
                <?php
                if (isset($_GET['error'])) {
                    $error = $_GET['error'];
                    if ($error === 'emptyfields') {
                        echo '<p class="error-message">Please fill in all fields.</p>';
                    } elseif ($error === 'invalidusername') {
                        echo '<p class="error-message">Invalid username. Only letters and numbers are allowed.</p>';
                    } elseif ($error === 'invalidemail') {
                        echo '<p class="error-message">Invalid email address.</p>';
                    } elseif ($error === 'passwordcheck') {
                        echo '<p class="error-message">Passwords do not match.</p>';
                    } elseif ($error === 'usernametaken') {
                        echo '<p class="error-message">Username already taken. Please choose another.</p>';
                    } elseif ($error === 'sqlerror') {
                        echo '<p class="error-message">An error occurred. Please try again later.</p>';
                    }
                }
                ?>

                <!-- Link to Login Page -->
                <p>Already have an account? <a href="login.php">Login</a>.</p>
            </section>
        </main>
    </div>
</body>
</html>
<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.container {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 300px;
    text-align: center;
}

h2 {
    margin-bottom: 20px;
}

input {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #218838;
}

.error-message {
    color: red;
    margin-top: 10px;
}
</style>