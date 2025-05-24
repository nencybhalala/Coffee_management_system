<?php
include 'db_config.php';
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $address = trim($_POST['address']);
    $mobile = trim($_POST['mobile']);
    $city = trim($_POST['city']);
    $state = trim($_POST['state']);
    $country = trim($_POST['country']);
    $zipcode = trim($_POST['zipcode']);
    // $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $errors = [];

    // Validation
    if (empty($first_name) || empty($last_name) || empty($address) ||empty($city)|| empty($mobile) || empty($state) || empty($country) || empty($zipcode) || empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $errors[] = "All fields are required.";
    }
    if (!preg_match("/^[a-zA-Z\s]+$/", $first_name) || !preg_match("/^[a-zA-Z\s]+$/", $last_name)) {
        $errors[] = "First and Last Name should only contain letters.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (!preg_match("/^[0-9]{10}$/", $mobile)) {
        $errors[] = "Mobile number must be 10 digits.";
    }
    if (!preg_match("/^[0-9]{5,10}$/", $zipcode)) {
        $errors[] = "Zipcode must be between 5-10 digits.";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Passwords and confirm password do not match.";
    }
    if (strlen($password) < 6) {
        $errors[] = "Password must be have at least 6 characters.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR mobile = ?");
        $stmt->bind_param("ss", $email, $mobile);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors[] = "Email or Mobile number already registered. Try with a new one.";
        } else {
            // Hash password before storing
            // $password_hash = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert user into database
            $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, address, mobile, city, state, country, zipcode, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssssss", $first_name, $last_name, $address, $mobile, $city, $state, $country, $zipcode, $email, $password);

            if ($stmt->execute()) {
                echo "<div class='success'>Registration successful! Redirecting to login...</div>";
                header("refresh:2;url=login.php");
                exit;
            } else {
                $errors[] = "Error: " . $stmt->error;
            }
        }
        $stmt->close();
    }
     // Display errors
     foreach ($errors as $error) {
        echo "<p class='error'>$error</p>";
    }
}

    // Display errors
        // $password_hash = password_hash($password, PASSWORD_DEFAULT);
//         $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, address, mobile ,city, state, country, zipcode, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?)");
//         $stmt->bind_param("ssssssssss", $first_name, $last_name, $address, $mobile ,$city, $state, $country, $zipcode, $email, $password);

//         if ($stmt->execute()) {
//             echo "<div class='success'>Registration successful! Redirecting to login...</div>";
//             header("refresh:2;url=login.php");
//         } else {
//             echo "<div class='error'>Error: " . $stmt->error . "</div>";
//         }
//         $stmt->close();
//     } else{
//         foreach ($errors as $error) {
//             echo "<div class='error'>$error</div>";
//         }
//     }
// }
// $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Coffee Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/header.css">
    <style>
        body {
            background-color: #f8f1e5;
            font-family: 'Poppins', sans-serif;
        }
        .error{
            color:red;
            margin-top:90px;
            font-size:15px;
        }
        .container {
            max-width: 500px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 100px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #6a4f4b;
            font-size:29px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label{
            font-size:small;
        }
        .btn-register {
            background: #6a4f4b;
            color: white;
            width: 100%;
        }
        .btn-register:hover {
            background: #543c36;
        }
        .container p {
            font-size: 14px;
        }
        .container a {
            color: #6a4f4b;
            text-decoration: none;
        }
        .container a:hover {
            text-decoration: underline;
        }
        p{
            text-align:center;
        }
    </style>
</head>
<body>
   
    <div class="container">
        <h2><i class="fas fa-coffee"></i> Register</h2>
        <form action="register.php" method="post">
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>First Name</label>
                    <input type="text" name="first_name" class="form-control" required>
                </div>
                <div class="col-md-6 form-group">
                    <label>Last Name</label>
                    <input type="text" name="last_name" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" style="text-transform:lowercase;" required>
                </div> 
                 </div>
                 <div class="row">
                <div class="col-md-12 form-group">
                    <label>City</label>
                    <input type="text" name="city" class="form-control" required>
                </div> 
                 </div>
                 <div class="row">
                <div class="col-md-6 form-group"> 
                    <label>Mobile Number</label>
                    <input type="text" name="mobile" class="form-control"  placeholder="10-digit number" required>
                </div>
            
                <div class="col-md-6 form-group">
                    <label>State</label>
                    <input type="text" name="state" class="form-control" required>
                </div>
                </div>
                <div class="row">
                <div class="col-md-6 form-group">
                    <label>Country</label>
                    <input type="text" name="country" class="form-control" required>
                </div>
            
            
                <div class="col-md-6 form-group">
                    <label>Zip Code</label>
                    <input type="text" name="zipcode" class="form-control" pattern="\d{6}" placeholder="6-digit ZIP" required>
                </div>
                </div>
               
            <div class="row">
            <div class="col-md-12 form-group">
                     <label>Address</label>
                    <input type="text" name="address" class="form-control" required>
                    </div>
                </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="col-md-6 form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>
            </div>
            <button type="submit" class="btn btn-register mt-3">Register</button>
        </form>
        <br>
    <p>Already have an account? <a href="login.php">Log In</a></p>
    </div>
</body>
</html>
