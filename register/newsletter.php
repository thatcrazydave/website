<?php
session_start();
require '../data.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

    // Validate email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        try {
            // Prepare and execute the insert statement
            $stmt = $pdo->prepare("INSERT INTO users (email) VALUES (:email)");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        
            if ($stmt->execute()) {
                $_SESSION['success'] = "Email successfully added!";
            } else {
                throw new Exception("Error adding email.");
            }
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                $_SESSION['error'] = "Email address already in use.";
            } else {
                $_SESSION['error'] = "Database error: " . $e->getMessage();
            }
        }
    } // Close the if block
    header('Location: ../index.php'); // Redirect back to the form page
    exit();
} // Close the if block
?>