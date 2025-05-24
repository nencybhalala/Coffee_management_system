<!--################################################################################################# 
        when user selects the desired currency:
            -> send an ajax request to php script 'currency.php'.
            -> change the values of the $_SESSION["currency"]["logo"] and $_SESSION["currency"]["price"].
            -> refresh the page to get the changes.

    #################################################################################################-->

    <header>
    <a href="index.php" class="logo"><i class="fas fa-coffee"></i> Nescafe</a>

    <nav class="navbar">
        <a href="index.php">Home</a>
        <!-- <a href="./offer.php">Offers</a> -->
        <a href="about.php">About</a>
        <a href="menu.php">Menu</a> <!-- This ensures it opens menu.php as a separate page -->
        <a href="extras.php">Toppings</a>
        <a href="review.php">Reviews</a>
        <a href="contactus.php">Contact Us</a>
        <!-- <a href="profile.php">Profile</a> -->
        <a href="order_tracking.php">My Order</a>
    </nav>

    <div class="icons">
        <a href="./profile.php" class="fas fa-user"></a>
        <a href="./wishlist.php" class="fas fa-heart"></a>
        <a href="./cart.php" class="fas fa-shopping-cart"></a>
        <i class="fas fa-bars" id="menu-bars"></i>
    </div>
</header>





    
