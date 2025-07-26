<?php
session_start(); // Start the session to store login status

// Define the correct credentials (FOR DEMONSTRATION ONLY - NOT SECURE FOR PRODUCTION)
$correctUsername = "Admin";
$correctPassword = "Admin12"; // In a real application, this would be a hashed password

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Simple authentication
    if ($username === $correctUsername && $password === $correctPassword) {
        // Authentication successful
        $_SESSION['admin_logged_in'] = true; // Set a session variable
        $_SESSION['admin_username'] = $username; // Store username in session

        // Redirect to the admin home page
        header("Location: AdminHome.html");
        exit();
    } else {
        // Authentication failed
        // Redirect back to the login page with an error flag
        header("Location: AdminLogin.html?error=1");
        exit();
    }
} else {
    // If someone tries to access AdminLogin.php directly without a POST request
    header("Location: AdminLogin.html");
    exit();
}
?>