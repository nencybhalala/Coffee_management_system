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

<section class="menu" id="menu">
    <h3 class="sub-heading" data-aos="fade-up"> Our Menu </h3>
    <h1 class="heading" data-aos="fade-up"> Today's Speciality </h1>
  
    <div class="menu-tabs" data-aos="fade-up">
<?php 

//fetch list of menues from database 
$query="SELECT * FROM menu";
$result=mysqli_query($conn,$query);

if($result){
    while($row = mysqli_fetch_assoc($result)){ 
?>
        
    <!-- apply class show on the first menu -->
    <!-- set data-target=#name_of_menu so later we can target the items having the id=#menu_name  -->
    <div class="tabs">
        <img src="./images/menu/<?php echo $row['menu_logo'] ?>" alt="">
       
        <button  type="button" class="menu-tab-item <?php if($row['menu_id'] == 1){echo 'show';} ?>" 
                              data-target="#<?php echo $row['menu_name'] ?>">
                <?php echo $row['menu_name'] ?>
        </button>
    </div>

<?php }} ?> 

    </div>   

<!---------------------------------------------------------------------------------------------->

    <div class="box-container">

<?php 

// Select all items in all menues
// we want to check first if the item have an offer
// then we don't display it in the menu section, we display it in the offer section 

$query="SELECT m1.item_id,item_name,item_price,item_image,item_description,m1.menu_id,menu_name 
        FROM menuitem m1,menu m2
        WHERE m1.menu_id=m2.menu_id 
        AND item_id NOT IN (SELECT item_id FROM todayoffer)";

$result=mysqli_query($conn,$query);

if($result){
    while($row = mysqli_fetch_assoc($result)){ 

        // convert price to the selected currency
        $price =  $row["item_price"];
?>

        <!-- all items in the beginning are hidden -->
        <!-- if the item is in menu1 -> apply class show -->
        <!-- set id = #menu_name to target them in js-->

        <div class="box menu-tab-content <?php if($row['menu_id'] == 1){echo 'show';} ?>" data-aos="fade-up"  id="<?php  echo $row['menu_name']; ?>" >

            <!-- we added to each of the product name, price, quantity, image fields and addToCart button a unique id so that
                 when we click addToCart we know which item in jquery-->    

            <!-- item image -->
            <div class="image">
                <i class="fas fa-heart AddWishlist" id="<?php echo $row['item_id'] ?>" aria-hidden="true"></i>
                <i class="fas fa-eye" aria-hidden="true"></i>
                <img id="image_<?php echo $row['item_id'] ?>" src="./<?php echo $row['item_image'] ?>" alt=""  >
            </div>

            
            <div class="content">

                <!-- item name -->
                <h3 id="name_<?php echo $row['item_id'] ?>">
                    <?php echo $row['item_name'] ?>
                </h3>

                <!-- Description info -->
                <div class="description" id="description">
                    <div>
                        <i class="fas fa-arrow-left" aria-hidden="true"></i>
                        <h3>Description</h3>
                    </div>
                                
                    <p><?php echo $row['item_description'] ?></p>
                </div>

                <!-- item price and quantity -->
                <div class="priceInfo">
                    <span class="price"> 
                        <span id="price_<?php echo $row['item_id'] ?>"> 
                            <?php echo $price ?> 
                        </span> ₹
                    </span>

                    <div class="separator"></div>

                    <div class="qtybtns">
                        <div class="QTY" id="sus" ><i class="fas fa-minus"></i></div>
                        <span class="counter" id="quantity_<?php echo $row['item_id'] ?>" > 1 </span>
                        <div class="QTY" id="addq"><i class="fas fa-plus"></i></div>
                    </div>  
                </div>
      
                <!-- add to cart button -->
                <button class="btn addItemToCart" id="<?php echo $row['item_id'] ?>">
                    <i class="fas fa-cart-plus"></i> Add To Cart</button>  

            </div>
        </div>
<?php 
}} 
?>
       

    </div>
</section>
<?php include('./sections/toppings_modal.php'); ?>
<?php include('./sections/footer.php'); ?>
<!-- 🔹 Login Popup -->
<div id="loginPopup" class="popup-overlay" style="display: none;">
    <div class="popup-box">
        <h2>Login Required</h2>
        <p>You need to log in first to add items to your cart.</p>
        <a href="login.php" class="btn">Login Now</a>
        <button class="btn close-popup">Close</button>
    </div>
</div>

<!-- 🔹 JavaScript for Login Check & Modal -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const addToCartButtons = document.querySelectorAll(".addItemToCart");

    function showLoginPopup() {
        document.getElementById("loginPopup").style.display = "flex";
    }

    document.querySelector(".close-popup").addEventListener("click", function () {
        document.getElementById("loginPopup").style.display = "none";
    });

    function checkLogin(event) {
        event.preventDefault();

        let isLoggedIn = <?php echo json_encode(isset($_SESSION['user_id'])); ?>;

        if (!isLoggedIn) {
            showLoginPopup();
            return;
        }

        let itemId = this.getAttribute("id");
        let productName = document.getElementById("name_" + itemId)?.innerText.trim() || "Unknown Product";
        let productImage = document.getElementById("image_" + itemId)?.src || "";
        let productPrice = document.getElementById("price_" + itemId)?.innerText.trim() || "0";

        $('#ITEM_NAME').text(productName + " - " + productPrice + "₹");
        $('#ITEM_QUANTITY').text("Quantity: 1");
        $('#ITEM_IMAGE').attr("src", productImage);
        $('#addToCart_modal').modal('show');
    }

    addToCartButtons.forEach(btn => btn.addEventListener("click", checkLogin));
});
</script>

<!-- 🔹 Popup Styling -->
<style>
.popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    justify-content: center;
    align-items: center;
}

.popup-box {
    background: white;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    width: 300px;
}

.popup-box h2 {
    margin-bottom: 10px;
}

.popup-box .btn {
    display: inline-block;
    margin-top: 10px;
    padding: 8px 15px;
    background: #ff6600;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

.popup-box .btn.close-popup {
    background: red;
}
</style>
 
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
 
    
<script src="./js/script.js"></script>
<script src="./js/currency.js"></script>
<script src="./js/addToCart.js"></script>
<script src="./js/wishlist.js"></script>
<script src="./js/reviews.js"></script>
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




