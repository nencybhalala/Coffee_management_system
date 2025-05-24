<?php
include 'db_config.php';
session_start();

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $identifier = trim($_POST['identifier']);
    $password = $_POST['password'];

    if (empty($identifier) || empty($password)) {
        $error = "All fields are required!";
    } else {
        // First check if the email exists
        $sql = "SELECT id, password, first_name, last_name FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Query Failed: " . $conn->error);
        }

        $stmt->bind_param("s", $identifier);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Email found, now check password
            $stmt->bind_result($id, $stored_password, $first_name, $last_name);
            $stmt->fetch();

            if ($password === $stored_password) {
                $_SESSION['user_id'] = $id;
                $_SESSION['name'] = $first_name . " " . $last_name;
                header("Location: index.php");
                exit;
            } else {
                $error = "Incorrect password!";
            }
        } else {
            $error = "No user found with this email!";
        }

        $stmt->close();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Shop Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="./plugins/bootstrap-5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/header.css">
    <style>
        body {
            background: #f8f1e5;
            font-family: 'Poppins', sans-serif;
        }
        .login-container {
            width: 350px;
            background: white;
            padding: 20px;
            margin: 0px auto;
            margin-top:160px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        .login-container h2 {
            margin-bottom: 15px;
            color: #6a4f4b;
            font-size:29px;
        }
        .form-group {
            text-align: left;
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            color: #6a4f4b;
            font-size:15px;
        }
        .form-control {
            border: 1px solid #c3a38a;
            border-radius: 5px;
            height: 40px;
            font-size: 14px;
        }
        .form-control:focus {
            border-color: #a67b5b;
            box-shadow: none;
        }
        .login-btn {
            background: #6a4f4b;
            color: white;
            border: none;
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .login-btn:hover {
            background: #503e3b;
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
        .login-container p {
            font-size: 14px;
        }
        .login-container a {
            color: #6a4f4b;
            text-decoration: none;
        }
        .login-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<?php include 'header.php';?>
<div class="login-container">
    <h2><i class="fas fa-coffee"></i> Login</h2>
    <?php if (!empty($error)) echo "<p class='error-message'>$error</p>"; ?>
    
    <form action="login.php" method="post">
        <div class="form-group">
            <label for="identifier">Email</label>
            <input type="text" name="identifier" class="form-control" style="text-transform:lowercase;" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control"  required>
        </div>

        <button type="submit" class="login-btn">Login</button>
    </form>
<br>
    <p>Don't have an account? <a href="register.php">Sign up</a></p>
</div>

</body>
</html>
