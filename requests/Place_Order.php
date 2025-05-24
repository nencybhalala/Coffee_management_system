<?php
session_start();
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

include '../db_config.php';

// Razorpay API Credentials
$api_key = "rzp_test_uW6tUb1GaXcayZ"; // Replace with your Test Key ID
$api_secret = "7Rtb1ml4059a8uD5z88m2lgi"; // Replace with your Secret Key

// Validate Shopping Cart
if (empty($_SESSION['shopping_cart'])) {
    echo json_encode(["status" => "error", "message" => "Shopping cart is empty."]);
    exit();
}

// Validate Database Connection
if (!$conn instanceof mysqli) {
    echo json_encode(["status" => "error", "message" => "Database connection failed."]);
    exit();
}

// Validate Request
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || ($_POST['action'] ?? '') !== 'place_order') {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
    exit();
}

// Ensure User is Logged In
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in."]);
    exit();
}

// Retrieve and Sanitize User Data
$user_id = (int) $_SESSION['user_id'];
$first_name = trim($_POST['customer_first_name'] ?? '');
$last_name = trim($_POST['customer_last_name'] ?? '');
$email = trim($_POST['email_address'] ?? '');
$mobile = trim($_POST['mobile_number'] ?? '');
$address = trim($_POST['customer_address'] ?? '');
$city = trim($_POST['customer_city'] ?? '');
$zip = trim($_POST['customer_zip'] ?? '');
$state = trim($_POST['customer_state'] ?? '');
$country = trim($_POST['customer_country'] ?? '');
$total_price = (float) ($_SESSION['shopping_cart_total'] ?? 0); // Convert to paise
$current_time = time();
$payment_method = trim($_POST['payment_method'] ?? 'cod'); // Default to Cash on Delivery

$customer_name = $first_name . " " . $last_name;

// Insert Order Into Database
$order_query = "INSERT INTO orders (user_id, customer_name, email_address, mobile_number, customer_address, customer_city, customer_zip, customer_state, customer_country, total_price, payment_method) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($order_query);
if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "SQL Prepare Error: " . $conn->error]);
    exit();
}

$stmt->bind_param("issississis", $user_id, $customer_name, $email, $mobile, $address, $city, $zip, $state, $country, $total_price,$payment_method);

if (!$stmt->execute()) {
    echo json_encode(["status" => "error", "message" => "Execution Error: " . $stmt->error]);
    exit();
}

$order_id = $stmt->insert_id;
$stmt->close();

if (!$order_id) {
    echo json_encode(["status" => "error", "message" => "Order ID not generated."]);
    exit();
}

// Insert Order Items Into order_items Table
$order_items_query = "INSERT INTO order_items (customer_id, order_id, product_id, product_name, product_price, product_quantity, product_topping, topping_price, product_total, product_image, status) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";

$stmt_items = $conn->prepare($order_items_query);
if (!$stmt_items) {
    echo json_encode(["status" => "error", "message" => "SQL Prepare Error: " . $conn->error]);
    exit();
}

foreach ($_SESSION['shopping_cart'] as $item) {
    $product_id = trim($item['product_id']);
    $product_name = trim($item['product_name']);
    $product_price = (float) $item['product_price'];
    $product_quantity = (int) $item['product_quantity'];
    $product_topping = implode(", ", $item['product_toppings'] ? $item['product_toppings'] : []);
    $topping_price = (int) $item['toppings_price'];
    // $product_total = (float) $product_price * $product_quantity;
    $product_total= (float) $item['product_total'];
    $product_image = trim($item['product_image']);
    $product_status = 'Pending';

    $stmt_items->bind_param("iiisdisidss", $user_id, $order_id, $product_id, $product_name, $product_price, $product_quantity, $product_topping,$topping_price, $product_total, $product_image,  $product_status);

    if (!$stmt_items->execute()) {
        echo json_encode(["status" => "error", "message" => "SQL Execution Error: " . $stmt_items->error]);
        exit();
    }
}
$stmt_items->close();

unset($_SESSION['shopping_cart'], $_SESSION['shopping_cart_total'], $_SESSION['shipping']);


// If Payment Method is Online, Create Razorpay Order
if ($payment_method === "online") {
    $razorpay_order_data = [
        'amount' => $total_price * 100,
        'currency' => 'INR',
        'receipt' => "order_" . $order_id,
        'payment_capture' => 1
    ];

    $ch = curl_init("https://api.razorpay.com/v1/orders");
    curl_setopt($ch, CURLOPT_USERPWD, $api_key . ":" . $api_secret);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($razorpay_order_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $response = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_status !== 200) {
        $razorpay_response = json_decode($response, true);
        echo json_encode(["data"=>$razorpay_response,"status" => "error", "message" => "Razorpay Order Creation Failed"]);
        exit();
    }

    $razorpay_response = json_decode($response, true);
    $razorpay_order_id = $razorpay_response['id'] ?? null;

    if (!$razorpay_order_id) {
        echo json_encode(["status" => "error", "message" => "Failed to generate Razorpay order ID"]);
        exit();
    }

    echo json_encode([
        "status" => "success",
        "message" => "Order placed successfully!",
        "order_id" => $order_id,
        "razorpay_order_id" => $razorpay_order_id,
        "amount" => $total_price,
        "payment_method" => $payment_method,
    ]);
    exit();
}

// If Payment Method is COD, Return Success Immediately
echo json_encode([
    "status" => "success",
    "message" => "Order placed successfully with Cash on Delivery!",
    "order_id" => $order_id,
    "payment_method" => $payment_method,
]);
exit();
?>