<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    // echo '<div style="text-align: center; margin-top: 50px;">
    //         <h2>You are not log In</h2>
    //         <a href="index.php" class="btn" style="padding: 10px 20px; background: blue; color: white; text-decoration: none; border-radius: 5px;">Home</a>
    //         <a href="login.php" class="btn" style="padding: 10px 20px; background: green; color: white; text-decoration: none; border-radius: 5px;">Login</a>
    //       </div>';
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$editing = false;

// Fetch user details
$stmt = $conn->prepare("SELECT first_name, last_name, address, city, mobile, state, country, zipcode, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $editing = true;
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
    $update_fields = [];
    $params = [];
    $types = "";

    foreach ($_POST as $key => $value) {
        if (!empty(trim($value)) && $key !== 'email' && $key !== 'save') {
            $update_fields[] = "$key = ?";
            $params[] = trim($value);
            $types .= "s";
        }
    }
    
    if (!empty($update_fields)) {
        $params[] = $user_id;
        $types .= "i";
        $query = "UPDATE users SET " . implode(", ", $update_fields) . " WHERE id = ?";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param($types, ...$params);
        
        if ($stmt->execute()) {
            echo "<div class='success'>Profile updated successfully!</div>";
            header("Refresh: 1");
        } else {
            echo "<div class='error'>Error updating profile.</div>";
        }
        $stmt->close();
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <link rel="stylesheet" href="./plugins/swiper-8.0.7/css/swiper.min.css">
<!-- Swiper JS -->
<script src="./plugins/swiper-8.0.7/js/swiper.min.js"></script>

    <!-- <link rel="stylesheet" href="./plugins/swiper-8.0.7/css/swiper.min.css"> -->

    <!-- font awesome css cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- bootstrap css file -->
    <link rel="stylesheet" href="./plugins/bootstrap-5.1.3/css/bootstrap.min.css">

    <!-- aos css file -->
    <link rel="stylesheet" href="./plugins/aos-2.3.4/css/aos.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/home.css">
    <link rel="stylesheet" href="./css/offer.css">
    <link rel="stylesheet" href="./css/about.css">
    <link rel="stylesheet" href="./css/menu.css">
    <link rel="stylesheet" href="./css/toppings_modal.css">
    <link rel="stylesheet" href="./css/extra.css">
    <link rel="stylesheet" href="./css/review.css">
    <!-- <link rel="stylesheet" href="./css/order.css"> -->


    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: beige;
            text-align: center;
            padding: 20px;
            background:white;
            color: white;
        }
        h2{
            color: #4e342e;
            margin-top:70px;
            font-size:50px;
        }
        .container {
            background: #eee;;
            width: 50%;
            margin: auto;
            margin-top:60px;
            margin-bottom:100px;
            padding: 20px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            background: #4e342e ;
            font-size:15px;
        }
        label {
            font-weight: bold;
            color: #795548;
        }
        .form-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .form-group div {
            width: 48%;
        }
        input {
            width: 100%;
            padding: 8px;
            border: 1px solid #795548;
            border-radius: 5px;
            background: #f5f5dc;
            color: #4e342e;
        }
        button {
            margin-top:20px;
            background-color: #fff;
            color: #4e342e;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #8d6e63;
        }
        .links a {
            display: inline-block;
            margin: 10px;
            text-decoration: none;
            color: #4e342e;
            background: white;
            padding: 10px 15px;
            border-radius: 5px;
        }
        .links a:hover {
            background: #8d6e63;
        }
        .success {
            color: #4e342e;
            font-weight: bold;
        }
        .error {
            color: #d84315;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php
    include('header.php');
   ?>
        <h2>Welcome, <?php echo htmlspecialchars($user['first_name']); ?>!</h2>
    <div class="container">
        
        <?php if (!$editing) { ?>
            <p><strong>First Name:</strong> <?php echo htmlspecialchars($user['first_name']); ?></p>
            <p><strong>Last Name:</strong> <?php echo htmlspecialchars($user['last_name']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
            <p><strong>Mobile:</strong> <?php echo htmlspecialchars($user['mobile']); ?></p>
            <p><strong>City:</strong> <?php echo htmlspecialchars($user['city']); ?></p>
            <p><strong>State:</strong> <?php echo htmlspecialchars($user['state']); ?></p>
            <p><strong>Country:</strong> <?php echo htmlspecialchars($user['country']); ?></p>
            <p><strong>Zipcode:</strong> <?php echo htmlspecialchars($user['zipcode']); ?></p>
            <form method="post">
                <button type="submit" name="update">Update Profile</button>
            </form>
        <?php } else { ?>
            <form method="post">
                <div class="form-group">
                    <div>
                        <label>First Name:</label>
                        <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>">
                    </div>
                    <div>
                        <label>Last Name:</label>
                        <input type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label>Address:</label>
                        <input type="text" name="address" value="<?php echo htmlspecialchars($user['address']); ?>">
                    </div>
                    <div>
                        <label>Mobile:</label>
                        <input type="text" name="mobile" value="<?php echo htmlspecialchars($user['mobile']); ?>" pattern="\d{10}" 
                        title="Enter a valid 10-digit mobile number" required>
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label>State:</label>
                        <input type="text" name="state" value="<?php echo htmlspecialchars($user['state']); ?>">
                    </div>
                    <div>
                        <label>Country:</label>
                        <input type="text" name="country" value="<?php echo htmlspecialchars($user['country']); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <label>Zipcode:</label>
                        <input type="text" name="zipcode" value="<?php echo htmlspecialchars($user['zipcode']); ?>" pattern="\d{6}" 
       title="Enter a valid 6-digit ZIP code" 
       required>
                    </div>
                </div>
                <button type="submit" name="save">Save Changes</button>
            </form>
        <?php } ?>
        <br>
        <div class="links">
            <!-- <a href="index.php">Explore</a> -->
            <a href="logout.php">Logout</a>
        </div>
    </div>
    <?php
    include('./sections/footer.php');?>
</body>
</html>