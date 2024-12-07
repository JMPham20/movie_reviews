<?php
// Include database connection
require 'db_connection.php';

// Start session to manage user login state
session_start();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Validate data (basic example)
    if (empty($username) || empty($password)) {
        die("Username and password are required.");
    }

    // Prepare the SQL statement to prevent SQL injection
    $sql = "SELECT id, username, password_hash FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("MySQL prepare error: " . $conn->error); // Check for preparation errors
    }

    // Bind the parameters and execute the query
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Check if the username exists
    if ($stmt->num_rows === 0) {
        die("Invalid username or password.");
    }

    // Fetch the user's details
    $stmt->bind_result($user_id, $db_username, $db_password_hash);
    $stmt->fetch();

    // Verify the password
    if (password_verify($password, $db_password_hash)) {
        // Password is correct, login successful
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;

        // Redirect to the user dashboard or homepage after login
        header("Location: homepage.html");
        exit;
    } else {
        // Incorrect password
        echo "Invalid username or password.";
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
