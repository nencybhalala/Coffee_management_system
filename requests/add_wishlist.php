<?php 
session_start();
header('Content-Type: application/json');

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Please log in to use the wishlist."]);
    exit();
}

$user_id = $_SESSION['user_id']; // Get logged-in user ID

// Initialize wishlist session if not set
if (!isset($_SESSION['wishlist'])) {
    $_SESSION['wishlist'] = [];
}

// Add product to wishlist
if (isset($_POST['action']) && $_POST['action'] == "add_wishlist") {
    $pid = $_POST['pid'];
    $pname = $_POST['pname'];
    $pimage = $_POST['pimage'];
    $pprice = $_POST['pprice'];

    // Check if item already exists
    $exists = false;
    foreach ($_SESSION['wishlist'] as $item) {
        if ($item['product_id'] == $pid) {
            $exists = true;
            // echo json_encode(["status" => "info", "message" => "Item is already in wishlist"]);
            break;
        }
    }

    if (!$exists) {
        $_SESSION['wishlist'][] = [
            "product_id" => $pid,
            "product_name" => $pname,
            "product_image" => $pimage,
            "product_price" => $pprice
        ];
        echo json_encode(["status" => "success", "message" => "Item added to wishlist"]);
    } else {
        echo json_encode(["status" => "success", "message" => "Item is already in wishlist"]);
    }
    exit();
}

// Remove product from wishlist
if (isset($_POST['action']) && $_POST['action'] == "remove_wishlist") {
    $pid = $_POST['product_id'];

    $_SESSION['wishlist'] = array_filter($_SESSION['wishlist'], function($item) use ($pid) {
        return $item['product_id'] != $pid;
    });

    echo json_encode(["status" => "success", "message" => "Item removed from wishlist"]);
    exit();
}
?>
