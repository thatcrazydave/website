


<?php
// config.php
declare(strict_types=1);
session_start();

// Security headers
header("Strict-Transport-Security: max-age=31536000; includeSubDomains");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("Content-Security-Policy: default-src 'self'");

// Database configuration
const DB_HOST = 'localhost';
const DB_NAME = 'users';
const DB_USER = 'restrict';
const DB_PASS = 'strong_password_here';
const DB_CHARSET = 'utf8mb4';

// Admin credentials (should be stored in database in real implementation)
const ADMIN_USERNAME = 'admin';
const ADMIN_PASSWORD_HASH = '$2y$12$Sdsdf2sdfsdFDSfgsdgsd.4e5r6y7u8i9o0p1a2s3d4f5g6h7j8k9l0'; // bcrypt hash

// PDO connection
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    die("System maintenance in progress. Please try again later.");
}

// functions.php
require_once __DIR__ . '/functions.php';

?>

// functions.php content
<?php
declare(strict_types=1);

function sanitizeInput(string $data): string {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

function validateEmail(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function generateCSRFToken(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCSRFToken(string $token): bool {
    return hash_equals($_SESSION['csrf_token'] ?? '', $token);
}

function isBruteForce(string $ip): bool {
    $maxAttempts = 5;
    $lockoutTime = 15 * 60; // 15 minutes
    
    // Implement Redis or database-based rate limiting here
    return false; // Simplified for example
}

function checkAdminSession(): void {
    if (empty($_SESSION['admin_authenticated']) || $_SESSION['ip_address'] !== $_SERVER['REMOTE_ADDR']) {
        session_regenerate_id(true);
        session_destroy();
        header('Location: login.php');
        exit;
    }
}

// admin.php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

// Session security
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.cookie_samesite', 'Strict');

// Handle logout
if (isset($_GET['logout'])) {
    session_regenerate_id(true);
    session_destroy();
    header('Location: login.php');
    exit;
}

// Admin authentication
if (!isset($_SESSION['admin_authenticated'])) {
    header('Location: login.php');
    exit;
}

checkAdminSession();

// Get user activity logs
try {
    $stmt = $pdo->prepare("
        SELECT 
            username, 
            email, 
            login_time, 
            logout_time,
            TIMEDIFF(logout_time, login_time) AS session_duration
        FROM users 
        ORDER BY login_time DESC
    ");
    $stmt->execute();
    $users = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    die("Error retrieving user data");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - User Activity</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f8f9fa; }
        .logout { float: right; }
    </style>
</head>
<body>
    <h1>User Activity Monitor <a href="?logout" class="logout">Logout</a></h1>
    
    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Login Time</th>
                <th>Logout Time</th>
                <th>Session Duration</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= sanitizeInput($user['username']) ?></td>
                <td><?= sanitizeInput($user['email']) ?></td>
                <td><?= date('Y-m-d H:i:s', strtotime($user['login_time'])) ?></td>
                <td><?= $user['logout_time'] ? date('Y-m-d H:i:s', strtotime($user['logout_time'])) : 'Active' ?></td>
                <td><?= $user['session_duration'] ?? 'N/A' ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

<!-- login.php -->
<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrfToken = $_POST['csrf_token'] ?? '';
    $username = sanitizeInput($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (!verifyCSRFToken($csrfToken) || isBruteForce($_SERVER['REMOTE_ADDR'])) {
        error_log("Security violation detected from IP: " . $_SERVER['REMOTE_ADDR']);
        die("Invalid request");
    }

    if ($username === ADMIN_USERNAME && password_verify($password, ADMIN_PASSWORD_HASH)) {
        session_regenerate_id(true);
        $_SESSION['admin_authenticated'] = true;
        $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        header('Location: admin.php');
        exit;
    }
    
    sleep(2); // Slow down brute force attempts
    $error = "Invalid credentials";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Same headers as admin.php -->
</head>
<body>
    <h1>Admin Login</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= $error?></p>
    <?php endif; ?>
    
    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?= generateCSRFToken() ?>">
        
        <div>
            <label>Username:</label>
            <input type="text" name="username" required autocomplete="username">
        </div>
        
        <div>
            <label>Password:</label>
            <input type="password" name="password" required autocomplete="current-password">
        </div>
        
        <button type="submit">Login</button>
    </form>
</body>
</html>