<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'community_db');

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize input data
$fullname = $conn->real_escape_string($_POST['fullname']);
$email = $conn->real_escape_string($_POST['email']);
$categories = $_POST['categories'];

// Validate inputs
if (empty($fullname) || empty($email) || empty($categories)) {
    die("All fields are required");
}

// Insert main user record
$sql = "INSERT INTO users (fullname, email) VALUES ('$fullname', '$email')";
if ($conn->query($sql) === TRUE) {
    $user_id = $conn->insert_id;
    
    // Insert category associations
    foreach ($categories as $category) {
        $clean_category = $conn->real_escape_string($category);
        
        // Check if category exists
        $category_check = $conn->query("SELECT id FROM categories WHERE name = '$clean_category'");
        
        if ($category_check->num_rows == 0) {
            // Create new category if it doesn't exist
            $conn->query("INSERT INTO categories (name) VALUES ('$clean_category')");
            $category_id = $conn->insert_id;
        } else {
            $category_id = $category_check->fetch_assoc()['id'];
        }
        
        // Create user-category association
        $conn->query("INSERT INTO user_categories (user_id, category_id) VALUES ($user_id, $category_id)");
        
        // Create category-specific data storage
        $category_table = "category_" . $clean_category;
        $conn->query("CREATE TABLE IF NOT EXISTS $category_table (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT(6) NOT NULL,
            join_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id)
        )");
        
        // Insert into category-specific table
        $conn->query("INSERT INTO $category_table (user_id) VALUES ($user_id)");
    }
    
    echo "Registration successful! You've been added to " . count($categories) . " categories.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

// Redirect or additional processing
header("Location: success.html");
exit();
?>