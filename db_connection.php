<?php
// Database Connection
$servername = "localhost"; // Database server (usually "localhost" for local setup)
$dbusername = "root";      // Default MySQL username for XAMPP is "root"
$dbpassword = "";          // Default MySQL password for XAMPP is empty
$dbname = "movie_review";  // Name of your database
$port = 5222;              // MySQL custom port

// Create a connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname, $port);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully!";
}
?>
