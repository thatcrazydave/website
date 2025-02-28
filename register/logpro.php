<?php
// Configuration
require_once '../db.php';

// Start the session
session_start();

// Function to generate a CSRF token
function generateCSRFToken() {
    return bin2hex(random_bytes(32));
}

// Initialize CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = generateCSRFToken();
}

// Initialize errors array
if (!isset($_SESSION['errors'])) {
    $_SESSION['errors'] = [];
}

// Define admin credentials
$adminCredentials = [
    'username' => 'admin',
    'password' => 'password123', // Replace with a secure password
];

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate CSRF token
    if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['errors'][] = "Invalid CSRF token.";
        header("Location: login.php");
        exit;
    }

    // Sanitize user inputs
    $username = trim($_POST['uid']);
    $password = trim($_POST['pwd']);

    // Check if admin credentials are provided
    if ($username === $adminCredentials['username'] && $password === $adminCredentials['password']) {
        // Admin login successful, set session variables and redirect to admin dashboard
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['username'] = $username;
        header('Location: register/admin.php');
        exit;
    }

    // Validate inputs
    $errors = [];
    if (empty($username)) {
        $errors[] = "Username is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }
    if (!empty($username) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $errors[] = "Invalid username. Only alphanumeric characters are allowed.";
    }
    if (!empty($username) && in_array($username, ["test", "admin", "user"])) {
        $errors[] = "Username is restricted. Please choose a different username.";
    }

    // Redirect with errors if any
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: login.php");
        exit;
    }

    // Try to connect to the database
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE user_uid = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();

        // Check if the user exists
        if (!$user) {
            // User does not exist, check if password is empty
            if (empty($password)) {
                $errors[] = "Both username and password are incorrect.";
            } else {
                $errors[] = "Username does not exist.";
            }
            $_SESSION['errors'] = $errors;
            header('Location: login.php');
            exit;
        }

        // Validate password
        if (!password_verify($password, $user['user_pwd'])) {
            // Password is incorrect
            $errors[] = "Incorrect password.";
            $_SESSION['errors'] = $errors;
            header('Location: login.php');
            exit;
        }

        // If the user is valid, set the session variables and redirect to the index page
        $_SESSION['user_id'] = $user['id']; // Create a session for the user ID
        $_SESSION['username'] = $user['user_uid']; // Create a session for the username
        $_SESSION['logged_in'] = true; // Create a session variable to indicate the user is logged in

        // Clear any previous errors
        unset($_SESSION['errors']);

        header('Location: ../index.php');
        exit;

    } catch (PDOException $e) {
        $errors[] = "An error occurred. Please try again later.";
        $_SESSION['errors'] = $errors;
        header('Location: login.php');
        exit;
    }
} else {
    $errors[] = "Invalid request method.";
    $_SESSION['errors'] = $errors;
    header('Location: login.php');
    exit;
}
?>

<!-- Login Form -->
<!-- <form action="login.php" method="post">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <label for="uid">Username:</label>
    <input type="text" id="uid" name="uid"><br><br>
    <label for="pwd">Password:</label>
    <input type="password" id="pwd" name="pwd"><br><br>
    <input type="submit" value="Login">
</form> -->

<!-- Display Errors -->
<?php if (!empty($_SESSION['errors'])) : ?>
    <ul>
        <?php foreach ($_SESSION['errors'] as $error) : ?>
            <li><?php echo $error; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>