<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
require 'db_connection.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate data (basic example)
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        die("All fields are required!");
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        die("Passwords do not match!");
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL statement to prevent SQL injection
    $sql = "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("MySQL prepare error: " . $conn->error); // Check for preparation errors
    }

    // Bind the parameters and execute the query
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "Registration successful! <a href='login.html'>Click here to login</a>";
    } else {
        echo "Error: " . $stmt->error; // Show specific error from MySQL
    }

    $stmt->close();
}

// Close the connection
$conn->close();
?>
