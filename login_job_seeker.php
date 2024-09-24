<?php
// Start session
session_start();

// Retrieve form data
$email = $_POST['username'];
$password = $_POST['password'];

// Example validation (replace with actual database check)
$valid_credentials = true; // Replace with actual validation logic

if ($valid_credentials) {
    // Set session or any necessary data
    $_SESSION['user_email'] = $email;

    // Redirect to index.html
    header("Location: index.html");
    exit();
} else {
    // Handle invalid credentials
    echo "Invalid email or password.";
}
?>
