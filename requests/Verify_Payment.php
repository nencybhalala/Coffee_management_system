<?php
session_start();
include '../db_config.php';

header('Content-Type: application/json');

// Razorpay API Secret
$razorpay_secret = "7Rtb1ml4059a8uD5z88m2lgi"; // Replace with your actual secret key

// Get Payment Data from AJAX Request
$razorpay_payment_id = $_POST['razorpay_payment_id'] ?? null;
$razorpay_order_id = $_POST['razorpay_order_id'] ?? null;
$razorpay_signature = $_POST['razorpay_signature'] ?? null;
$order_id = $_POST['order_id'] ?? null;

if (!$razorpay_payment_id || !$razorpay_order_id || !$razorpay_signature || !$order_id) {
    echo json_encode(["status" => "error", "message" => "Missing payment details."]);
    exit();
}

// Verify Signature
$generated_signature = hash_hmac('sha256', $razorpay_order_id . "|" . $razorpay_payment_id, $razorpay_secret);

if ($generated_signature !== $razorpay_signature) {
    echo json_encode(["status" => "error", "message" => "Payment verification failed."]);
    exit();
}

// Insert Payment Record into Database
$payment_query = "INSERT INTO payments (order_id, razorpay_payment_id, razorpay_order_id, razorpay_signature, status, created_at) 
                  VALUES (?, ?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($payment_query);
if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "SQL Prepare Error: " . $conn->error]);
    exit();
}

$status = "Success";
$stmt->bind_param("issss", $order_id, $razorpay_payment_id, $razorpay_order_id, $razorpay_signature, $status);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Payment verified and recorded."]);
} else {
    echo json_encode(["status" => "error", "message" => "Database insertion failed."]);
}

$stmt->close();
$conn->close();
?>
