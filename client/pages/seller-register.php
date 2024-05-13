<?php
require "./../../config/dbCon.php";

session_start();

if (isset($_SESSION['sellerUsername'])) {
    header("Location: /project/admin/");
    exit();

}
$error = '';

if(isset($_POST['register_user'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $contactNumber = mysqli_real_escape_string($conn, $_POST['contactNumber']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $store_name = mysqli_real_escape_string($conn, $_POST['store_name']);

    if($name == '' || $username == '' || $contactNumber == '' || $address == '' || $password == '' || $store_name == ''){
        $error = "All fields are required.";
    }  else {
        $check_query = "SELECT * FROM sellers WHERE sellerUsername = '$username'";
        $check_result = mysqli_query($conn, $check_query);
        if(mysqli_num_rows($check_result) > 0){
            $error = "Username already exists. Please choose a different one.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO sellers (sellerName, sellerUsername, sellerContact, sellerAddress, sellerPassword, store_name) VALUES ('$name','$username', '$contactNumber', '$address', '$hashed_password','$store_name')";
        $result = mysqli_query($conn, $query);
        
        if($result){
            header("Location: /project/client/pages/seller-login.php");
            exit(0);
        } else {
            $error = "An error occurred. Please try again later.";
        }
    }
}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/index.css">
    <link rel="stylesheet" href="../style/login.css">
    <title>Sign Up | Harvest hub</title>
</head>

<body>
    <div class="container" style="height: 100vh;">
        <header>
            <div class="header-container">
                <div class="middle">
                    <a href="/project/client/" class="logo">
                        <h1>Harverst</h1>
                        <span>hub</span>
                        <h5 style="font-weight: 400; font-size: 16px;">Seller Center</h5>
                    </a>
                </div>
            </div>
        </header>

        <div style="justify-content: center; align-items: center;" class="seller_login_container">
            <div style="z-index: 1000;" class="signup_container">
                <h3 style="font-weight: 500; font-size: 20px; margin-bottom: 20px;">Register an account</h3>
                <form action="" method="post">
                    <div>
                        <div style="display: flex; gap: 10px;">
                            <div class="login_items">
                                <label for="name">Name</label>
                                <input required id="name" name="name" type="text">
                            </div>

                            <div class="login_items">
                                <label for="username">Username</label>
                                <input required id="username" name="username" type="text">
                            </div>

                        </div>

                        <div style="display: flex; gap: 10px;">
                            <div class="login_items">
                                <label for="store_name">Store Name</label>
                                <input required id="store_name" name="store_name" type="text">
                            </div>

                            <div class="login_items">
                                <label for="contactNumber">Contact Number</label>
                                <input required id="contactNumber" name="contactNumber" type="text">
                            </div>
                        </div>

                        <div style="display: flex; gap: 10px;">
                            <div class="login_items">
                                <label for="address">Address</label>
                                <input required id="address" name="address" type="text">
                            </div>

                            <div class="login_items">
                                <label for="password">Password</label>
                                <input required id="password" name="password" type="password">
                            </div>
                        </div>

                        <div>
                            <button name="register_user">Signup</button>
                        </div>

                        <!-- Display error message -->
                        <div style="font-size: 15px; color: red; margin-top: 5px;" class="error-message">
                            <?php echo $error; ?></div>

                        <div style="display: flex; gap: 6px; font-size: 15px; margin-top: 16px; color: #565656;">
                            <p>Already have an account? </p><a href="/project/client/pages/seller-login.php"
                                style="color:#5300c0;"> Login</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>