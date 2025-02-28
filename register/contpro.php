<?php
// Set the content type to JSON
header('Content-Type: application/json');

// Initialize response array
$response = [
    'success' => false,
    'message' => ''
];

// Database connection parameters
$host = 'localhost'; // Database host
$dbname = 'user'; // Database name
$username = 'root'; // Database username
$password = ''; // Database password

// Create a new PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $response['message'] = 'Database connection failed: ' . $e->getMessage();
    echo json_encode($response);
    exit;
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    $name = isset($_POST['name']) ? trim(strip_tags($_POST['name'])) : '';
    $email = isset($_POST['email']) ? trim(strip_tags($_POST['email'])) : '';
    $message = isset($_POST['message']) ? trim(strip_tags($_POST['message'])) : '';

    // Basic validation
    if (empty($name) || empty($email) || empty($message)) {
        $response['message'] = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = 'Invalid email format.';
    } else {
        // Prepare email
        $to = 'daveharry563@gmail.com'; // Replace with your email address
        $subject = 'New Contact Form Submission';
        $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
        $headers = "From: $name <$email>\r\n";

        // Send email
        if (mail($to, $subject, $body, $headers)) {
            // Prepare SQL statement to insert data into the database
            $stmt = $pdo->prepare("INSERT INTO contact_form_submissions (name, email, message) VALUES (:name, :email, :message)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':message', $message);

            // Execute the statement
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Your message has been sent successfully!';
            } else {
                $response['message'] = 'There was an error saving your message to the database.';
            }
        } else {
            $response['message'] = 'There was an error sending your message. Please try again later.';
        }
    }
} else {
    $response['message'] = 'Invalid request method.';
}

// Return JSON response
echo json_encode($response);
?>