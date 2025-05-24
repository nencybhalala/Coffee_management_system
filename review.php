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

<section class="review" id="review">

    <h3 class="sub-heading" > customer's review </h3>
    <h1 class="heading" > what they say </h1>


    <!-- In this section we used bootstrap for the design, and JQUERY... -->
    <div   div class="container">
    	<div class="card">
    		<div class="card-body">
    			<div class="row">

    				<div class="col-sm-4 text-center">
    					<h1 class="text-warning mt-4 mb-4">
    						<b><span id="average_rating">0.0</span> / 5</b>
    					</h1>
    					<div class="mb-3">
    						<i class="fas fa-star star-light mr-1 main_star"></i>
                            <i class="fas fa-star star-light mr-1 main_star"></i>
                            <i class="fas fa-star star-light mr-1 main_star"></i>
                            <i class="fas fa-star star-light mr-1 main_star"></i>
                            <i class="fas fa-star star-light mr-1 main_star"></i>
	    				</div>
    					<h3><span id="total_review">0</span> Reviews</h3>
    				</div>

    				<div class="col-sm-4">
                    <p>
                            <div class="progress-label-left"><b>5</b> <i class="fas fa-star text-warning"></i></div>

                            <div class="progress-label-right">(<span id="total_five_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="five_star_progress"></div>
                            </div>
                        </p>
    					<p>
                            <div class="progress-label-left"><b>4</b> <i class="fas fa-star text-warning"></i></div>
                            
                            <div class="progress-label-right">(<span id="total_four_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="four_star_progress"></div>
                            </div>               
                        </p>
    					<p>
                            <div class="progress-label-left"><b>3</b> <i class="fas fa-star text-warning"></i></div>
                            
                            <div class="progress-label-right">(<span id="total_three_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="three_star_progress"></div>
                            </div>               
                        </p>
    					<p>
                            <div class="progress-label-left"><b>2</b> <i class="fas fa-star text-warning"></i></div>
                            
                            <div class="progress-label-right">(<span id="total_two_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="two_star_progress"></div>
                            </div>               
                        </p>
    					<p>
                            <div class="progress-label-left"><b>1</b> <i class="fas fa-star text-warning"></i></div>
                            
                            <div class="progress-label-right">(<span id="total_one_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="one_star_progress"></div>
                            </div>               
                        </p>
    				</div>

    				<div class="col-sm-4 text-center">
    					<h3 class="mt-4 mb-3">Write Review Here</h3>
    					<button type="button" name="add_review" id="add_review" class="btn">Review</button>
    				</div>

    			</div>
    		</div>
    	</div>
    </div>   

    <div class="swiper-container review-slider">
            <div class="swiper-wrapper" id="reviews_swiper">

            </div>

    </div>



</section>

<!-- Pop up modal for review -->
<div id="review_modal" class="modal fade" tabindex="-1" role="dialog">
  	<div class="modal-dialog modal-dialog-centered" role="document">
    	<div class="modal-content">
	      	<div class="modal-header">
	        	<h5 class="modal-title">Submit Review</h5>
	      	</div>
	      	<div class="modal-body">
	      		<h4 class="text-center mt-2 mb-4 star_rating">
	        		<i class="fas fa-star star-light submit_star mr-1" id="submit_star_1" data-rating="1"></i>
                    <i class="fas fa-star star-light submit_star mr-1" id="submit_star_2" data-rating="2"></i>
                    <i class="fas fa-star star-light submit_star mr-1" id="submit_star_3" data-rating="3"></i>
                    <i class="fas fa-star star-light submit_star mr-1" id="submit_star_4" data-rating="4"></i>
                    <i class="fas fa-star star-light submit_star mr-1" id="submit_star_5" data-rating="5"></i>
	        	</h4>
	        	<div class="form-group review_input">
	        		<input type="text" name="user_name" id="user_name" class="form-control" placeholder="Enter Your Name" />
	        	</div>
	        	<div class="form-group review_input">
	        		<textarea name="user_review" id="user_review" class="form-control" placeholder="Type Review Here"></textarea>
	        	</div>
	        	<div class="form-group text-center mt-4">
	        		<button type="button" class="btn" id="save_review">Submit</button>
                    <button type="button" class="btn btn-default" id="cancel_review">cancel</button>
	        	</div>
	      	</div>
    	</div>
  	</div>
</div>


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




