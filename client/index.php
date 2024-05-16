<?php 
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harvest Hub</title>
    <link rel="stylesheet" href="./style/index.css">
    <link rel="stylesheet" href="./style/filter.css">
    <link rel="stylesheet" href="./style/product_card.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,300,0,0" />
    <link rel="shortcut icon" href="./assets/favicon.webp" type="image/x-icon">
    <script src="https://kit.fontawesome.com/e9d841c4cd.js" crossorigin="anonymous"></script>

    <!-- <script src="index.js"></script> -->
</head>

<body>
    <div class="container">
        <?php include './components/header.php'?>

        <!-- MAIN AREA -->
        <main>
            <div class="main-container">
                <?php include './components/filter.php'?>
                <div class="left_container">
                    <h6>Just for you</h6>
                    <div class="product-container">
                        <?php include './components/product_card.php'?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    const checkboxes = document.querySelectorAll(
        '.shipped-from-filter input[type="checkbox"]'
    );

    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", function() {
            checkboxes.forEach((cb) => {
                if (cb !== this) {
                    cb.checked = false;
                }
            });
        });
    });
    </script>
</body>

</html>