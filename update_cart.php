<?php
session_start();
include_once('./includes/db_connect.php'); // Ensure this file correctly connects to your database

if (isset($_POST["product_id"]) && isset($_POST["action"])) {
    $product_id = $_POST["product_id"];
    $action = $_POST["action"];

    foreach ($_SESSION["shopping_cart"] as $keys => $values) {
        if ($values["product_id"] == $product_id) {
            if ($action == "increase") {
                $_SESSION["shopping_cart"][$keys]["product_quantity"] += 1;
            } elseif ($action == "decrease" && $_SESSION["shopping_cart"][$keys]["product_quantity"] > 1) {
                $_SESSION["shopping_cart"][$keys]["product_quantity"] -= 1;
            }

            // Get updated quantity
            $quantity = $_SESSION["shopping_cart"][$keys]["product_quantity"];

            // Calculate total for this product
            $base_price = floatval($_SESSION["shopping_cart"][$keys]["product_price"]);
            $toppings_price = floatval($_SESSION["shopping_cart"][$keys]["toppings_price"]);
            $total_item_price = ($base_price * $quantity) + $toppings_price;

            // Update the session total for this product
            $_SESSION["shopping_cart"][$keys]["product_total"] = $total_item_price;

            // Calculate new cart total
            $cart_total = array_sum(array_column($_SESSION["shopping_cart"], "product_total"));
            $_SESSION["shopping_cart_total"] = $cart_total;

            // Return updated data as JSON
            echo json_encode([
                "quantity" => $quantity,
                "total_price" => number_format($total_item_price, 2),
                "cart_total" => number_format($cart_total, 2)
            ]);
            exit();
        }
    }
}
?>
