<?php
session_start();
include_once('./includes/db_connect.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1, maximum-scale=1">
    <title></title>

    <!-- swiper css file -->
     <!-- Swiper CSS -->
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

   
</head>
<body>
<?php include('header.php'); ?> 


<section class="extra" id="extra">

    <h3 class="sub-heading" > <i class="fas fa-plus"></i> </h3>
    <h1 class="heading"> extra </h1>

<?php

// fetch from database the toppings categories
$query="SELECT * FROM toppingscategory";
$result=mysqli_query($conn,$query);

while($row=mysqli_fetch_assoc($result)){    ?>

    <div class="topping-box">

            <h3 class="topping-category">
                <i class="fas fa-cookie-bite" ></i>
                <?php echo $row["topping_category_name"] ?>
            </h3>

            <div class="topping-item-box">

                <?php

                // fetch all items in this category
                $query2="SELECT topping_name,topping_image,topping_price FROM toppings WHERE topping_category_id=?";
                $stmt2=mysqli_prepare($conn,$query2);
                mysqli_stmt_bind_param($stmt2,"i",$row['topping_category_id']);
                mysqli_stmt_execute($stmt2);
                $result2=mysqli_stmt_get_result($stmt2);
                
                while($row2 = mysqli_fetch_assoc($result2)){    

                    // $topping_price=$row2["topping_price"]*$currency_price;                                    ?>

                    <div class="topping-item" >
                        
                        <div class="topping-item-title">
                            <div class="image">
                                <img src="./<?php echo $row2['topping_image'] ?>" alt="" />
                            </div>
                            <h3><?php echo $row2['topping_name'] ?></h3>
                        </div>
                        
                        <div class="topping-item-price">
                             <?php echo $row2["topping_price"] ?> ₹
                        </div>
                    </div>

                <?php } ?>
            </div>  
    </div>

    <?php } ?>

</section>
<?php include('./sections/footer.php'); ?> 
<!-- jquery js file  -->
<script src="./plugins/jquery-3.6.0/jquery.min.js"></script>

<!-- bootstrap js file-->
<script src="./plugins/bootstrap-5.1.3/js/bootstrap.min.js"></script>

<!-- swiper js file -->
<script src="./plugins/swiper-8.0.7/js/swiper.min.js"></script>

<!-- aos js file -->
<script src="./plugins/aos-2.3.4/js/aos.js"></script>

<!-- sweetalert2 js file -->
<script src="./plugins/sweetalert2/sweetalert2.js"></script>
 
    
<script src="js/script.js"></script>
<script src="js/currency.js"></script>
<script src="js/addToCart.js"></script>
<script src="js/wishlist.js"></script>
<script src="js/reviews.js"></script>
</body>
</html>