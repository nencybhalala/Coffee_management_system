<?php 
session_start();
include_once('./includes/db_connect.php');

// Get currency details from session
// $currency_logo = isset($_SESSION["currency"]["logo"]) ? $_SESSION["currency"]["logo"] : "$";
// $currency_price = isset($_SESSION["currency"]["price"]) ? $_SESSION["currency"]["price"] : 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,minimum-scale=1, maximum-scale=1">
    <title>Wishlist</title>

    <!-- font awesome css cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <!-- bootstrap css file -->
    <link rel="stylesheet" href="./plugins/bootstrap-5.1.3/css/bootstrap.min.css">

    <!-- aos css file -->
    <link rel="stylesheet" href="./plugins/aos-2.3.4/css/aos.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/toppings_modal.css">
    <link rel="stylesheet" href="./css/wishlist.css">
</head>

<body>

    <input type="hidden" id="currency_list" value="₹" >
    <input type="hidden" id="wishlist_section" value="wishlist" >

    <!-- <header>
        <a href="./index.php" class="logo"><i class="fas fa-utensils"></i>Coffee Shop.</a>

        <div class="icons">
            <a href="#" class="fas fa-heart"></a>
            <a href="./cart.php" class="fas fa-shopping-cart"></a>
        </div>
    </header>   -->
    <?php include('header.php'); ?> 

    <?php 
    // if (!isset($_SESSION['user_id'])) {
    //     echo "<h2>Please log in to view your wishlist</h2>";
    //     exit();
    // }


    ?>

   
        <section class="wishlist">
            <div class="products-container">
                <h3 class="title"><a href="./index.php"><i class="fas fa-arrow-left"></i></a> Wishlist</h3>
                <div class="box-container">
                <?php if (!empty($_SESSION['wishlist'])) { ?>
                    <?php foreach ($_SESSION['wishlist'] as $item) { ?>
                   
                        <div class="box">
                            <i class="fas fa-times remove_wishlist" id="<?php echo $item['product_id'] ?>"></i>
                            <img src="<?php echo $item['product_image']; ?>" id="image_<?php echo $item['product_image']; ?>" alt="">

                            <div class="content">
                                <h3 id="name_<?php echo $item['product_id'] ?>"><?php echo $item['product_name']; ?></h3>
                                <span> Quantity: </span>
                                <input type="number" value="1" id="quantity_<?php echo $item['product_id'] ?>" min="1">
                                <br>
                                <span> Price: </span>
                                <span class="price"> 
                                ₹
                                    <span class="price" id="price_<?php echo $item['product_id']; ?>"> 
                                        <?php echo $item['product_price'] ?> 
                                    </span> 
                                </span><br>
                                <button class="btn addItemToCart add" id="<?php echo $item['product_id'] ?>">
                                    <i class="fas fa-cart-plus"></i> Add To Cart
                                </button>
                            </div>  
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>

        <?php } else { ?>
            <!-- If wishlist is empty -->
            <div class="empty_wishlist">
                <!-- <i class="fas fa-heart"></i> -->
                <h1>
                    <!-- <a href="index.php"><i class="fas fa-arrow-left"></i></a> Your Wishlist is Empty! -->
                </h1>
            </div>
        <?php }
     ?>

    <!-- Include PopUp toppings modal section -->
    <?php include('./sections/toppings_modal.php'); ?>

    <!-- Scripts -->
    <script src="./plugins/jquery-3.6.0/jquery.min.js"></script>
    <script src="./plugins/bootstrap-5.1.3/js/bootstrap.min.js"></script>
    <script src="./plugins/sweetalert2/sweetalert2.js"></script>
    <script src="./plugins/aos-2.3.4/js/aos.js"></script>
    <script src="js/addToCart.js"></script>
    <script src="js/wishlist.js"></script>

</body>
</html>
