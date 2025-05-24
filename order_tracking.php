<?php
session_start();
include_once('./includes/db_connect.php');

// ✅ Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo '<div style="text-align: center; margin-top: 50px;">
            <h2>You must be logged in to view orders!</h2>
            <a href="login.php" class="btn" style="padding: 10px 20px; background: green; color: white; text-decoration: none; border-radius: 5px;">Login</a>
            <a href="index.php" class="btn" style="padding: 10px 20px; background: blue; color: white; text-decoration: none; border-radius: 5px;">Back</a>
          </div>';
    exit();
}

$user_id = $_SESSION['user_id']; // Get logged-in user ID

// ✅ Fetch Order Data (Fixing SQL query for correct order retrieval)
$query = "SELECT oi.order_id, oi.product_name, oi.product_image,oi.product_quantity, oi.product_topping,oi.topping_price, oi.product_total,oi.status
          FROM order_items oi
        --   JOIN orders o 
        --   ON oi.customer_id = o.user_id
          WHERE oi.customer_id = ?
          ORDER BY oi.order_id DESC";

$stmt = $conn->prepare($query);
if (!$stmt) {
    die("<div style='text-align: center; margin-top: 50px;'>
            <h3>Error Fetching Orders</h3>
            <p>SQL Error: " . $conn->error . "</p>
            <a href='index.php' class='btn' style='padding: 10px 20px; background: blue; color: white; text-decoration: none; border-radius: 5px;'>Back to Home</a>
         </div>");
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracking</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="./plugins/bootstrap-5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/header.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; }
        .container { margin-top: 100px; font-size:medium;}
        .table { background: white; border-radius: 10px; overflow: hidden; }
        .thead-dark th { background: #343a40; color: white; }
        .btn-home { background: blue; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 20px; }
        .no-orders { text-align: center; margin-top: 150px; }
        .status-pending { color: orange; font-weight: bold; }
        .status-completed { color: green; font-weight: bold; }
        .status-canceled { color: red; font-weight: bold; }
    </style>
    
</head>
<body>
<?php include 'header.php';?>
<div class="container">
    <h2 class="text-center mb-4"><i class="fas fa-box"></i> Order Summary</h2>

    <?php if ($result->num_rows > 0) { ?>
        <table class="table table-bordered text-center">
            <thead class="thead-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Item Name</th>
                    <th>Item Image</th>
                    <th>Quantity</th>
                    <th>Toppings</th>
                    <th>Toppings Price</th>
                    <th>Total Price</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['order_id']; ?></td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><img src="<?php echo $row['product_image']; ?>" alt="" height="100px" width="100px"></td>
                        <td><?php echo $row['product_quantity']; ?></td>
                        <td><?php echo ($row['product_topping']) ? $row['product_topping'] : "None"; ?></td>
                        <td><?php echo ($row['topping_price']) ? $row['topping_price'] : "None"; ?></td>
                        <td><b>₹<?php echo number_format($row['product_total'], 2); ?></b></td>
                        <td><?php echo $row['status']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <div class="no-orders">
            <h3>No orders found!</h3>
            <a href="index.php" class="btn-home">Back to Home</a>
        </div>
    <?php } ?>
</div>

<script src="./plugins/bootstrap-5.1.3/js/bootstrap.min.js"></script>
</body>
</html>
