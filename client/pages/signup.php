<?php
session_start();

if (isset($_SESSION['customerUsername'])) {
    header("Location: /project/client/");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/index.css">
    <link rel="stylesheet" href="../style/login.css">
    <link rel="shortcut icon" href="../assets/favicon.webp" type="image/x-icon">

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
                        <h5 style="font-weight: 400; font-size: 16px;">Signup</h5>
                    </a>
                </div>
            </div>
        </header>

        <div class="login_container_s">

            <div class="signup_container">
                <h3 style="font-weight: 500; font-size: 20px; margin-bottom: 20px;">Register an account</h3>
                <form action="./../function/userFunction.php" method="POST">
                    <div>
                        <div style="display: flex; gap: 10px;">
                            <div class="login_items">
                                <label for="name">Name</label>
                                <input id="name" name="name" type="text">
                            </div>

                            <div class="login_items">
                                <label for="username">Username</label>
                                <input id="username" name="username" type="text">
                            </div>

                        </div>

                        <div style="display: flex; gap: 10px;">
                            <div class="login_items">
                                <label for="contactNumber">Contact Number</label>
                                <input id="contactNumber" name="contactNumber" type="text">
                            </div>

                            <div class="login_items">
                                <label for="address">Address</label>
                                <input id="address" name="address" type="text">
                            </div>
                        </div>

                        <div style="display: flex; gap: 10px;">

                            <div class="login_items">
                                <label for="password">Password</label>
                                <input id="password" name="password" type="password">
                            </div>

                            <div class="login_items">
                                <label for="confirmPassword">Confirm Password</label>
                                <input id="confirmPassword" name="confirmPassword" type="password">
                            </div>
                        </div>

                        <div>
                            <button name="register_user">Signup</button>
                        </div>

                        <div style="display: flex; gap: 6px; font-size: 15px; margin-top: 16px; color: #565656;">
                            <p>Already have an account? </p><a href="/project/client/pages/login.php"
                                style="color:#5300c0;"> Login</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>