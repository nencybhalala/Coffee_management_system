<?php
session_start();
include_once('./includes/db_connect.php');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];

// Debug: Check if database connection is working
if (!$conn) {
    die(json_encode(['error' => 'Database connection failed']));
}

// Prepare SQL query
$query = "SELECT first_name, last_name, email, mobile, address, zipcode, state, country FROM users WHERE id = ?";

// Check if prepare() failed
if (!$stmt = $conn->prepare($query)) {
    die(json_encode(['error' => 'SQL Prepare Failed: ' . $conn->error]));
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    header('Content-Type: application/json');
    echo json_encode($user);
} else {
    echo json_encode(['error' => 'No user data found']);
}
?>
