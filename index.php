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

<section class="home" id="home">

    <div class="swiper-container home-slider">

        <div class="swiper-wrapper wrapper">

            <div class="swiper-slide slide">
                <div class="content" >
                    <span>our special coffee</span>
                    <h3>Latte</h3>
                    <p>The best coffee that will change your whole morning routine!</p>
                    <a href="menu.php" class="btn">order now</a>
                </div>
                <div class="image" >
                    <img src="./images/back15.png" alt="">
                </div>
            </div>

         
            <div class="swiper-slide slide">
                <div class="content">
                    <span>our big secret</span>
                    <h3>Coffee Beans</h3>
                    <p>the secret behind these delicious coffee is that we use fresh coffee beans 100% organic with no chemicals!</p>
                    <a href="menu.php" class="btn">order now</a>
                </div>
                
                <div class="image">
                    <img src="./images/back13.png" alt="">
                </div>
            </div>

            <div class="swiper-slide slide">
                <div class="content">
                    <span>Our goal is to make our customers happy</span>
                    <h3>Extra Toppings</h3>
                    <p>You can add whatever toppings you want!</p>
                    <a href="menu.php" class="btn">order now</a>
                </div>
                <div class="image">
                    <img src="./images/back17.png" alt="">
                </div>
            </div>
        </div>
        <!-- Three buttons -->
        <div class="swiper-pagination"></div>

    </div>
</section>
<section class="offers" id="offers">  
    <!-- <div class="category">
            <?php for($i=1; $i<7; $i++){ ?>
                    <a href="#" class="cat">
                        <img src="./images/random/o<?php echo $i ?>.jpg" alt="">
                    </a>
            <?php } ?>
    </div>   -->

    <!-- Check if there is any item in offer table -->
    <!-- If we don't have any offer the offer section is not displayed at all -->

    <?php
        $query="SELECT offer_id FROM todayoffer";
        $result=mysqli_query($conn,$query);

        if($row=mysqli_fetch_assoc($result)){  ?>

    <h3 class="sub-heading" > hurry up </h3>
    <h1 class="heading" > hot offers! </h1>

    <div class="banner">
        <!-- we have two sections:
                1) For the items having max discount
                2) For the rest of the items -->
    
    
        <div class="grid-banner">

            <?php

                // Select the max discount           
                $query="SELECT max(pourcentage) AS max FROM todayoffer";
                $result=mysqli_query($conn,$query);
                $row=mysqli_fetch_assoc($result);

            ?>

            <div class="grid" >
                <img src="images/milkshakes/milkshake7.jpg" alt="">
                <div class="content">
                    <span>special offers</span>
                    <h3>upto <?php echo $row['max']; ?>% off</h3>
                    <a href="offers_list.php?section=1" class="btn">view</a>
                </div>
            </div>
          

            <?php

                // Check if there is other items having a discount different than the max discount
                $query="SELECT offer_id FROM todayoffer WHERE pourcentage != ".$row['max'];
                
                $result=mysqli_query($conn,$query);
                $row=mysqli_fetch_assoc($result);

                if($row){
            ?>
            
            <div class="grid">
                <img src="images/random/o3.jpg" alt="">
                <div class="content">
                    <span>today's offers</span>
                    <h3>hurry up</h3>
                    <a href="offers_list.php?section=2" class="btn">view</a>
                </div>
            </div>

            <?php }  ?>
        </div>      
    </div>
    <?php } ?>
</section>
<!-- <div class="loader-container">
    <img src="images/loader.gif" alt="">
</div> -->

<?php include('./sections/footer.php'); ?>
<!-- <div class="loader-container">
    <img src="images/loader.gif" alt="">
</div> -->
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
<script>
document.addEventListener("DOMContentLoaded", function () {
    var swiper = new Swiper(".home-slider", {
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        loop: true,
    });

    var reviewSwiper = new Swiper(".review-slider", {
        spaceBetween: 10,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            0: { slidesPerView: 2 },
            640: { slidesPerView: 2 },
            768: { slidesPerView: 2 },
            1024: { slidesPerView: 3 },
        },
    });

    var bookTableSwiper = new Swiper(".customer-table-img-slider", {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        speed: 1000,
        effect: "coverflow",
        coverflowEffect: {
            rotate: 3,
            stretch: 2,
            depth: 100,
            modifier: 5,
            slideShadows: false,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });

    var teamSlider = new Swiper(".team-slider", {
        slidesPerView: 3,
        spaceBetween: 10,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            0: { slidesPerView: 2 },
            640: { slidesPerView: 2 },
            768: { slidesPerView: 2 },
            1024: { slidesPerView: 3 },
        },
    });
});
</script>

</body>
</html>