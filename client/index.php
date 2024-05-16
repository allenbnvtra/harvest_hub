<?php session_start(); ?>

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
</head>

<body>
    <div class="container">
        <?php include './components/header.php'?>

        <!-- MAIN AREA -->
        <main>
            <div class="main-container">
                <!-- Filter Section -->
                <div class="filter">
                    <h4>Filter</h4>
                    <div class="filter-items">
                        <div>
                            <h4 class="filter-title">Price</h4>
                            <div class="price-range">
                                <input type="number" placeholder="Min" id="minPrice">
                                <input type="number" placeholder="Max" id="maxPrice">
                            </div>
                        </div>

                        <div>
                            <h4 class="filter-title">Shipped from</h4>
                            <div class="shipped-from-filter">
                                <input type="checkbox" id="bulacan" name="shippedFrom" value="Bulacan">
                                <label for="bulacan">Bulacan</label><br>
                                <input type="checkbox" id="metroManila" name="shippedFrom" value="Metro Manila">
                                <label for="metroManila">Metro Manila</label><br>
                                <input type="checkbox" id="laguna" name="shippedFrom" value="Laguna">
                                <label for="laguna">Laguna</label><br>
                                <input type="checkbox" id="nuevaEcija" name="shippedFrom" value="Nueva Ecija">
                                <label for="nuevaEcija">Nueva Ecija</label><br>
                                <input type="checkbox" id="pampanga" name="shippedFrom" value="Pampanga">
                                <label for="pampanga">Pampanga</label><br>
                                <input type="checkbox" id="cavite" name="shippedFrom" value="Cavite
                ">
                                <label for="cavite">Cavite</label><br>
                            </div>
                        </div>
                        <button id="applyFiltersButton" class="filter-button">Apply Filter</button>
                    </div>
                </div>

                <!-- Product Container -->
                <div class="left_container" id="productContainer">
                    <h6>Just for you</h6>
                    <div class="product-container">
                        <?php include './components/product_card.php'?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const applyFiltersButton = document.getElementById("applyFiltersButton");

        applyFiltersButton.addEventListener("click", function() {
            const minPrice = document.getElementById("minPrice").value;
            const maxPrice = document.getElementById("maxPrice").value;
            const shippedFrom = Array.from(document.querySelectorAll(
                '.shipped-from-filter input[type="checkbox"]:checked')).map(cb => cb.value);

            console.log("Min Price:", minPrice);
            console.log("Max Price:", maxPrice);
            console.log("Shipped From:", shippedFrom);

            const queryString = `?min=${minPrice}&max=${maxPrice}&shipped=${shippedFrom.join(',')}`;
            console.log("Query String:", queryString);

            // Update the URL with the new query string
            window.location.href = `/project/client/index.php${queryString}`;
        });
    });
    </script>

</body>

</html>