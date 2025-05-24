<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <style>
    body {
      font-family: Arial, sans-serif;
      margin-top: 80px;
      padding: 0;
      color: #5a3e36;
      background-color: #f7f3f0;
    }
    .header {
      /* background-color: rgba(62, 39, 35, 0.9); */
      color:rgba(62, 39, 35, 0.9); ;
      padding-top: 5px ;
      text-align: center;
    }
    h1 {
      margin: 0;
      font-size: 4rem;
    }
    .container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      margin: 40px auto;
      max-width: 1200px;
    }
    .image-section {
      flex: 1;
      background: url('./images/coffee/iced-cappuccino.jpg') no-repeat center center;
      background-size: cover;
      border-radius: 12px;
      min-height: 500px;
    }
    .content-section {
      flex: 1;
      padding: 40px;
      background-color: rgba(255, 255, 255, 0.95);
      border-radius: 12px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }
    h2, h3 {
      color: #8d6e63;
    }
    p {
      font-size: 16px;
      line-height: 1.8;
    }
    footer {
      background-color: rgba(62, 39, 35, 0.9);
      color: #fff;
      text-align: center;
      padding: 20px 0;
    }
    /* a {
      color: #f4a460;
      text-decoration: none;
    }
    a:hover {
      text-decoration: underline;
    } */
    @media (max-width: 768px) {
      .container {
        flex-direction: column;
      }
      .image-section {
        min-height: 300px;
      }
    }
  </style>
</head>
<body>
    <?php include 'header.php'?>

     <div class="header">
    <h1>Contact Us</h1><br>
    <p>Your daily dose of happiness, one cup at a time.</p>
</div> 

  <div class="container">
    <div class="image-section"></div>
    <div class="content-section">
      <h2>Nescafe</h2>
      <p>Have questions, suggestions, or just want to say hello? We'd love to hear from you! Connect with us using the details below or stop by our café for a fresh brew.</p>
<br><br>
      <h3>Our Contact Information</h3>
      <p><strong>Address:</strong> 123 Brew Street, Coffee City, CO 12345</p>
      <p><strong>Email:</strong> support@nescafe.com</p>
      <p><strong>Phone:</strong> +91 1234567890</p>
      <p>Follow us on social media for the latest updates and offers!</p>

      <!-- <h3>Operating Hours</h3>
      <p><strong>Monday - Friday:</strong> 7:00 AM - 8:00 PM</p>
      <p><strong>Saturday - Sunday:</strong> 8:00 AM - 9:00 PM</p> -->
    </div>
  </div>
  <?php include('./sections/footer.php'); ?> 
</body>
</html>