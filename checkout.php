<?php 
      session_start();
      var_dump($_SESSION);
    //   if(!isset($_SESSION["cart_page"])){
    //       header("location:index.php");
    //       exit();
    //   }
   
    include 'db_config.php'; // Ensure this file contains your database connection
    
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('Please log in to access billing details.'); window.location.href='login.php';</script>";
        exit();
    }
    
    // Fetch user ID from session
    $user_id = $_SESSION['user_id'];
    
    // Fetch user details from database
    $query = "SELECT id,first_name, last_name, email, mobile, address,city, zipcode, state, country FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "<script>alert('User not found.'); window.location.href='index.php';</script>";
        exit();
    }
    ?>
    




<!DOCTYPE html>
<html>
 <head>
 <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,minimum-scale=1, maximum-scale=1">
    <title>Checkout</title>

  <!-- bootstrap css file -->
  <link rel="stylesheet" href="./plugins/bootstrap-5.1.3/css/bootstrap.min.css">

  <!-- font awesome css cdn link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


  <!-- custom css file link  -->
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="./css/header.css">
  <link rel="stylesheet" href="./css/checkout.css">

 </head>
 <body>

    <!-- Database connection -->
    <?php include_once('./includes/db_connect.php');
            include 'header.php';
    ?>   

    <!-- <header>
        <a href="./index.php" class="logo"><i class="fas fa-utensils"></i>Coffee Shop.</a>

        <div class="icons"> 
           <a href="./wishlist.php" class="fas fa-heart"></a>
           <a href="./cart.php" class="fas fa-shopping-cart"></a>
        </div>
    </header>   -->


    <div class="checkout">

        <div class="container1">
            <!-- <form id="billingForm"> -->

             <!-- BILLING DETAILS -->
            <div class="billing_details">
                <h1 align="center">Billing Details</h1>

                <!-- customer name -->
                <input type="hidden" name="customer_id" id="customer_id" class="form-control" value="<?php echo htmlspecialchars($user['id']); ?>" />
                           
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label><b>First Name <span class="text-danger">*</span></b></label>
                            <input type="text" name="customer_first_name" id="customer_first_name" class="form-control" value="<?php echo htmlspecialchars($user['first_name']); ?>" />
                            <span id="error_customer_first_name" class="text-danger"></span>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label><b>Last Name <span class="text-danger">*</span></b></label>
                            <input type="text" name="customer_last_name" id="customer_last_name" class="form-control" value="<?php echo htmlspecialchars($user['last_name']); ?>" />
                            <span id="error_customer_last_name" class="text-danger"></span>
                        </div>
                    </div>
                </div>

                <!-- customer email and phone number -->
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label><b>Email Address <span class="text-danger">*</span></b></label>
                            <input type="text" name="email_address" id="email_address" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" />
                            <span id="error_email_address" class="text-danger"></span>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label><b>Mobile Number <span class="text-danger">*</span></b></label>
                            <input type="number" name="mobile_number" id="mobile_number" class="form-control" value="<?php echo htmlspecialchars($user['mobile']); ?>" pattern="\d{10}" 
                            title="Enter a valid 10-digit mobile number" required/>
                            <span id="error_mobile_number" class="text-danger"></span>
                        </div>
                    </div>
                </div>

                <!-- customer address -->
                <div class="form-group">
                    <label><b>Address <span class="text-danger">*</span></b></label>
                    <input name="customer_address" id="customer_address" class="form-control" value="<?php echo htmlspecialchars($user['address']); ?>"/>
                    <span id="error_customer_address" class="text-danger"></span>
                </div>

                <!-- customer city & zip code -->
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label><b>City <span class="text-danger">*</span></b></label>
                            <input type="text" name="customer_city" id="customer_city" class="form-control" value="<?php echo htmlspecialchars($user['city']); ?>" />
                            <span id="error_customer_city" class="text-danger"></span>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label><b>Zip <span class="text-danger">*</span></b></label>
                            <input type="number" name="customer_zip" id="customer_zip" class="form-control" onwheel="this.blur()" value="<?php echo htmlspecialchars($user['zipcode']); ?>" pattern="\d{6}" 
       title="Enter a valid 6-digit ZIP code" 
       required/>
                            <span id="error_customer_zip" class="text-danger"></span>
                        </div>
                    </div>
                </div>


                <!-- customer state & country -->
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label><b>State <span class="text-danger">*</span></b></label>
                            <input type="text" name="customer_state" id="customer_state" class="form-control" value="<?php echo htmlspecialchars($user['state']); ?>" />
                            <span id="error_customer_state" class="text-danger"></span>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label><b>Country <span class="text-danger">*</span></b></label>
                            <input type="text" name="customer_country" id="customer_country" class="form-control" value="<?php echo htmlspecialchars($user['country']); ?>" />
                            <span id="error_customer_country" class="text-danger"></span>
                        </div>
                    </div>
                </div>

                <hr style="margin-top:1.5em;" />

            </div>

            
            <!-- ORDER DETAILS -->
            <div class="order_details">
                <h1 align="center">Order Details</h1>
                <div class="table-responsive" id="order_table">
                    <table class="table table-bordered table-striped">
                        <tr align="center">  
                            <th>Product Name</th>  
                            <th>Price</th>  
                            <th>Total</th>  
                        </tr>

                        <?php

                        foreach($_SESSION["shopping_cart"] as $keys => $values){?>

                        <tr>
                            <td class="product_name"> 
                                <div class="image">
                                    <img src="<?php echo $values['product_image'] ?>" >
                                </div>

                                <?php 
                                
                                if($values['product_toppings'] != '' )
                                    echo $values['product_name']."  (x".trim($values['product_quantity']).")  + toppings";
                                else
                                    echo $values['product_name']."  (x".$values['product_quantity'].")"?>
                            </td>
                            <td align="right">₹ <?php echo $values["product_price"] ?></td>
                            <td align="right"> <b>₹ <?php echo $values["product_total"] ?> </b></td>
                        </tr>

                        <?php  }  ?>

                        <!-- <tr>  
                            <td colspan="2" align="right"><i class="fas fa-shipping-fast"></i> <b>Shipping</td>  
                            <td align="right"><b>₹ <?php echo $_SESSION['shipping'] ?></b></td>
                        </tr> -->

                        <tr>  
                            <td colspan="2" align="right"><b>Total</b></td>  
                            <td align="right" style="color:red;"><b>₹ <?php echo $_SESSION['shopping_cart_total'] ?></b></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

 <div class="container2">

            <!-- PAYMENT DETAILS -->
            <div class="payment_details">
                <h1 align="center">Payment Details</h1>
                <div class="form-group">
    <label><b>Payment Method: </b></label><br>
    <input type="radio" name="payment_method" value="cod" checked>
    <label style="margin-right:20px;">Cash on Delivery</label>

    <input type="radio" name="payment_method" value="online">
    <label>Online Payment</label>
</div>


                <h4>Your personal data will be used to process your order and support your experience throughout this website.</h4>

                <div class="form-group">   
                    <input type="checkbox" name="agree_checkbox" id="agree_checkbox" >
                    <label><b>I have read and agree to the website terms and conditions *</b> <a href="privacy.php">Privacy&Policy</a></label>
                    <br>
                    <span id="error_agree_checkbox" class="text-danger"></span>
                </div>
            </div>
        </div>
 

        <div class="place_order">
            <input type="button" id="place_order" class="btn-success" value="Place Order" />
        </div>
    
    </div>



<!-- jquery js file  -->
<script src="./plugins/jquery-3.6.0/jquery.min.js"></script>

<!-- bootstrap js file-->
<script src="./plugins/bootstrap-5.1.3/js/bootstrap.min.js"></script> 

<!-- sweetalert2 js file -->
<script src="./plugins/sweetalert2/sweetalert2.js"></script>
<script src="./js/form_validation.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
$(document).ready(function () {
    $("#place_order").click(function () {
        var result = validate_form();
        console.log("Validation Result:", result); // Debugging line
        if (result) {
            console.log("Validation Passed. Sending AJAX request...");
            // Place order logic
        } else {
            console.log("Validation Failed. Fix errors first.");
        }
    });
});

</script>
<script>
$(document).ready(function () {
    $("#place_order").click(function () {
        console.log("Place Order button clicked!"); // Debugging

        var result = validate_form();
        console.log("Validation Result:", result); // Debugging

        if (result) {
            console.log("Validation Passed. Sending AJAX request...");

            $.ajax({
                url: "./requests/Place_Order.php",
                method: "POST",
                data: {
                    customer_id: $("#customer_id").val(),
                    customer_first_name: $("#customer_first_name").val(),
                    customer_last_name: $("#customer_last_name").val(),
                    email_address: $("#email_address").val(),
                    mobile_number: $("#mobile_number").val(),
                    customer_address: $("#customer_address").val(),
                    customer_city: $("#customer_city").val(),
                    customer_state: $("#customer_state").val(),
                    customer_zip: $("#customer_zip").val(),
                    customer_country: $("#customer_country").val(),
                    payment_method: $("input[name='payment_method']:checked").val(),
                    action: "place_order"
                },
                success: function (response) {
                    console.log("Server Response:", response); // Debugging

                    try {
                        const data = response;
                        if (data.status == "success") {
                            if (data.payment_method === "online") {
                                var options = {
                                    "key": "rzp_test_uW6tUb1GaXcayZ", // Replace with your Razorpay Key
                                    "amount": response.amount,
                                    "currency": "INR",
                                    "name": "Coffe Shop",
                                    "description": "Order Payment",
                                    "order_id": response.razorpay_order_id,
                                    "handler": function (paymentResponse) {
                                        $.ajax({
                                            url: "./requests/Verify_Payment.php", // Backend script to verify payment
                                            method: "POST",
                                            data: {
                                                ...paymentResponse,
                                                order_id:response.order_id
                                            },
                                            success: function (verifyResponse) {
                                                if (verifyResponse.status === "success") {
                                                    Swal.fire({
                                                        title: "Online : Order Placed Successfully!",
                                                        text: "Thank you for your purchase! Your order has been placed successfully. with Prepaid",
                                                        icon: "success",
                                                        confirmButtonText: "OK",
                                                        allowOutsideClick: false,// Prevents closing by clicking outside
                                                        allowEscapeKey: false // Prevents closing by pressing ESC
                                                    }).then(() => {
                                                        console.log("User clicked OK. Redirecting...");
                                                        window.location.href = "index.php"; // Redirect after confirmation
                                                    });
                                                } else {
                                                    Swal.fire({
                                                        title: "Error",
                                                        text: data.message,
                                                        icon: "error",
                                                        confirmButtonText: "OK"
                                                    });
                                                }
                                            }
                                        });
                                    }
                                };
    
                                var rzp = new Razorpay(options);
                                rzp.open();
                            } else {
                                    Swal.fire({
                                    title: "COD : Order Placed Successfully!",
                                    text: "Thank you for your purchase! Your order has been placed successfully. with COD",
                                    icon: "success",
                                    confirmButtonText: "OK",
                                    allowOutsideClick: false, // Prevents closing by clicking outside
                                    allowEscapeKey: false // Prevents closing by pressing ESC
                                }).then(() => {
                                    console.log("User clicked OK. Redirecting...");
                                    window.location.href = "index.php"; // Redirect after confirmation
                                });
                            }
                            

                        } else {
                            Swal.fire({
                                title: "Error",
                                text: data.message,
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        }

                    } catch (e) {
                        
                        Swal.fire({
                            title: "Error",
                            text: "Invalid response from server. Please try again."+e,
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", xhr.responseText); // Debugging
                    Swal.fire({
                        title: "Error!",
                        text: "There was an issue placing your order. Please try again.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                }
            });
        } else {
            console.log("Validation Failed. Fix errors first.");
        }
    });
});
</script>

<script>
console.log("Checking if form_validation.js is loaded..."); // Debugging
</script>

</body>
</html>