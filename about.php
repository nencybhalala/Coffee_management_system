<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1, maximum-scale=1">
    <title></title>

    <!-- swiper css file -->
    <!-- <link rel="stylesheet" href="./plugins/swiper-8.0.7/css/swiper.min.css"> -->
    <!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">


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

<!-- Database connection -->
<?php include_once('./includes/db_connect.php'); ?>    

    
<!-- header section -->
<?php include('header.php'); ?> 

<section class="about" id="about">

    <h3 class="sub-heading" > about us </h3>
    <h1 class="heading" > why choose us? </h1>

    <div class="about-info">
        <div class="image">
            <img src="./images/new.jpg" alt="">
        </div>

        <div class="content" >
            <h3>best tasty juices in the country</h3>
            <p>Our team is on a mission to create create tasting and nutritious juices, smoothies, bowls and bites. Our menu is full of fresh offers that are eqully craveable and  guilt-free. We take a lot of pride in serving products that are hight in nutritional value.</p>
            <p>Our juices are made fresh to order, and our smoothies are made with fruites instead of ice - which is commonly used bu other companies.</p>
            <div class="icons-container">
                <div class="icons">
                    <i class="fas fa-shipping-fast"></i>
                    <span>fast delivery</span>
                </div>
                <div class="icons">
                    <i class="fas fa-dollar-sign"></i>
                    <span>easy payments</span>
                </div>
                <div class="icons">
                    <i class="fas fa-headset"></i>
                    <span>24/7 service</span>
                </div>
            </div>
        </div>
    </div>

    <h3 class="sub-heading"> Customers </h3>
    <h1 class="heading" > Happy Customers! </h1>

    <div class="row" id="gallery" >
        <div class="col-lg-8 m-auto">
            <!-- <div class="customer-table-img-slider" id="icon">-->
                <div class="swiper-container customer-table-img-slider" id="icon"> 

                <div class="swiper-wrapper">

                <?php for($i=1; $i<8;$i++){ ?>
                    <img src="./images/customers/c<?php echo $i ?>.jpg" data-fancybox="table-slider"
                        class="customer-table-img swiper-slide"></img>  
                <?php } ?>       
                 
                </div>
        
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>

    <h3 class="sub-heading" > Team </h3>
    <h1 class="heading" > Our Beautiful Team! </h1>


    <!-- <div class="row team-slider" > -->
    <div class="swiper-container team-slider">

        <div class="swiper-wrapper">

<!-- get all team member informations from table TEAM  -->
<?php
    $query="SELECT member_name, member_image, member_role FROM team";
    $result=mysqli_query($conn,$query);
    
    if($result){
        while($row=mysqli_fetch_assoc($result)){  ?>       

            <div class="col-lg-4 swiper-slide">
                <div class="team-box text-center">
                    <img src="./images/team/<?php echo $row['member_image'] ?>" class="team-img">

                    <h3 class="h3-title"><?php echo $row['member_name'] ?></h3>
                    <p> <?php echo $row['member_role'] ?> </p>
                    <div class="social-icon">
                        <ul>
                            <li>
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

<?php }} ?>

        </div>

        <div class="swiper-pagination"></div>
    </div>



        </section>
<?php include('./sections/footer.php'); ?> 
<!-- jquery js file  -->
<script src="./plugins/jquery-3.6.0/jquery.min.js"></script>

<!-- bootstrap js file-->
<script src="./plugins/bootstrap-5.1.3/js/bootstrap.min.js"></script>

<!-- swiper js file -->
<!-- <script src="./plugins/swiper-8.0.7/js/swiper.min.js"></script> -->
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>


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