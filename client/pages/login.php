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

    <title>Login | Harvest hub</title>
</head>

<body>
    <div class="container" style="height: 100vh;">
        <header>
            <div class="header-container">
                <div class="middle">
                    <a href="/project/client/" class="logo">
                        <h1>Harverst</h1>
                        <span>hub</span>
                        <h5 style="font-weight: 400; font-size: 16px;">Login</h5>
                    </a>
                </div>
            </div>
        </header>

        <div class="login_container">
            <div style="display: flex; flex-direction: column; justify-content: center; color: #fff;">
                <h1 style="font-size: 80px; font-weight: 600;">Harvest hub</h1>
                <p style="font-size: 20px; font-weight: 400;">We deliver your farm products in fastest and most
                    reliable
                    way!</p>

                <p style="font-size: 20px; font-weight: 400;">The fastest growing and leading e-commerse website in the
                    Philippines.
                </p>
            </div>
            <div class="form_container">
                <h3 style="font-weight: 500; font-size: 20px; margin-bottom: 20px;">Login</h3>
                <form action="./../function/userFunction.php" method="POST">
                    <div>
                        <div class="login_items">
                            <label for="username">Username</label>
                            <input required id="username" name="username" type="text">
                        </div>

                        <div class="login_items">
                            <label for="password">Password</label>
                            <input required id="password" name="password" type="password">
                        </div>

                        <div>
                            <?php
                            if(isset($_SESSION['error'])){
                                echo "<p style='color: red;'>".$_SESSION['error']."</p>";
                                unset($_SESSION['error']); 
                            }
                            ?>
                        </div>

                        <div style="display: flex; justify-content: space-between;">
                            <div style="display: flex; gap: 5px;">
                                <input type="checkbox">
                                <label style="color: #565656;" for="remember">Remember me?</label>
                            </div>

                            <div>
                                <a style="color: #565656; text-decoration: underline;" href="">Forgot password?</a>
                            </div>
                        </div>


                        <div>
                            <button name="login_user">Login</button>
                        </div>

                        <div style="display: flex; gap: 6px; font-size: 15px; margin-top: 16px; color: #565656;">
                            <p>Don't have an account yet? </p><a href="/project/client/pages/signup.php"
                                style="color:#5300c0;"> Signup</a>
                        </div>


                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>