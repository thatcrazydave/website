<?php
// **Database Configuration**
$host = 'localhost'; // Database host (e.g., localhost)
$dbname = 'user'; // Name of the database
$username = 'root'; // Database username
$password = ''; // Database password

try {
    // **Create PDO Connection**
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // **Set PDO Attributes**
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exceptions for errors
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Set default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // Disable emulated prepared statements
} catch (PDOException $e) {
    // **Handle Connection Errors**
    die("Database connection failed: " . $e->getMessage());
}
?>