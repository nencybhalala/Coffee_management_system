<?php
session_start();

//  #####################################################################################################
//  This script handles adding, removing, and clearing items from the shopping cart,
//  while storing the cart items in the session. This ensures cart persistence across page refreshes.
//  #####################################################################################################

if (isset($_POST['action'])) {

    // Sanitize inputs
    $product_id = filter_input(INPUT_POST, 'pid', FILTER_SANITIZE_NUMBER_INT);
    $product_name = filter_input(INPUT_POST, 'pname', FILTER_SANITIZE_STRING);
    $product_image = filter_input(INPUT_POST, 'pimage', FILTER_SANITIZE_URL);
    $product_price = filter_input(INPUT_POST, 'pprice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $product_quantity = filter_input(INPUT_POST, 'pqty', FILTER_SANITIZE_NUMBER_INT);
    
    // ✅ Correctly sanitize toppings (array of strings)
    $product_toppings = isset($_POST['toppings']) ? filter_var_array($_POST['toppings'], FILTER_SANITIZE_STRING) : [];

    // Ensure shopping cart session exists
    if (!isset($_SESSION["shopping_cart"])) {
        $_SESSION["shopping_cart"] = [];
    }

    // 🔹 Add item to cart
    if ($_POST["action"] == "add") {
        $is_available = false;

        foreach ($_SESSION["shopping_cart"] as &$item) {
            // ✅ Check if product_id matches & toppings are the same
            if ($item['product_id'] == $product_id && empty(array_diff($item['product_toppings'], $product_toppings))) {
                $item['product_quantity'] += $product_quantity;
                $is_available = true;
                break;
            }
        }

        // ✅ If product is not available, add a new entry
        if (!$is_available) {
            $_SESSION["shopping_cart"][] = [
                'product_id' => $product_id,
                'product_name' => $product_name,
                'product_image' => $product_image,
                'product_price' => $product_price,
                'product_quantity' => $product_quantity,
                'product_toppings' => $product_toppings  // ✅ Store as an array
            ];
        }
    }

    // 🔹 Remove product from cart
    if ($_POST["action"] == "remove") {
        foreach ($_SESSION["shopping_cart"] as $key => $item) {
            if ($item["product_id"] == $_POST["product_id"]) {
                unset($_SESSION["shopping_cart"][$key]);
                break;
            }
        }

        // ✅ Reindex array to prevent gaps in session storage
        $_SESSION["shopping_cart"] = array_values($_SESSION["shopping_cart"]);
    }

    // 🔹 Clear all products from cart
    if ($_POST["action"] == "clear") {
        $_SESSION["shopping_cart"] = [];  // ✅ Directly reset session array
    }
}
?>
