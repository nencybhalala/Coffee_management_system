<?php
$servername = "localhost";
$username = "root";  // Default XAMPP MySQL username
$password = "";      // Default XAMPP MySQL password (empty)
$database = "coffeeshop"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_errno) {  // Correct way to use mysqli_connect_errno()
    die("Connection failed: " . $conn->connect_error);
}
?>

