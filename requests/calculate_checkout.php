<?php
session_start();
include('../includes/db_connect.php');

class Checkout {
    private $conn;

    public function __construct(mysqli $dbConnection) {
        $this->conn = $dbConnection;
    }

    private function getShippingCost() {
        $query = "SELECT delivery_cost FROM Delivery LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return $row["delivery_cost"];
        }
        return false; // Return false if no shipping cost is found
    }

    public function processCheckout() {
        if (!isset($_SESSION["shopping_cart_total"])) {
            echo "Error: Shopping cart total is missing.";
            return;
        }

        if (!isset($_SESSION['currency']['price'])) {
            echo "Error: Currency conversion factor is missing.";
            return;
        }

        // Fetch shipping cost
        $shippingCost = $this->getShippingCost();

        if ($shippingCost === false) {
            echo "Error: Failed to fetch delivery cost.";
            return;
        }

        // Convert shipping cost to selected currency
        $shipping = $shippingCost * $_SESSION['currency']['price'];

        // Save shipping cost inside session
        $_SESSION["shipping"] = $shipping;

        // Update total price with shipping
        $_SESSION["shopping_cart_total"] += $shipping;
    }
}

// Instantiate the Checkout class and execute the checkout process
if (isset($_POST["action"]) && $_POST["action"] == "checkout") {
    $checkout = new Checkout($conn);
    $checkout->processCheckout();
}
?>
