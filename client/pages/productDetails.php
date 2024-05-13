<?php
include_once "./../../config/dbCon.php";

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $sql_product = "SELECT * FROM products WHERE product_id = $product_id";
    $result_product = mysqli_query($conn, $sql_product);

    if ($result_product && mysqli_num_rows($result_product) > 0) {
        // Fetch product details
        $product = mysqli_fetch_assoc($result_product);

        // Query to calculate average rating for the product
        $sql_rating = "SELECT AVG(rating) AS avg_rating FROM Ratings WHERE product_id = $product_id";
        $result_rating = mysqli_query($conn, $sql_rating);
        $avg_rating_row = mysqli_fetch_assoc($result_rating);
        $avg_rating = round($avg_rating_row['avg_rating']);

        mysqli_free_result($result_product);
      
        $less_price = round((1 - ($product['previous_price'] / $product['price'])) * 100);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['product_name']; ?> | Harvest Hub</title>
    <link rel="stylesheet" href="./../style/index.css">
    <link rel="stylesheet" href="./../style/productDetails.css">
    <link rel="stylesheet" href="./../style/product_card.css">
    <link rel="shortcut icon" href="../assets/favicon.webp" type="image/x-icon">


    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,300,0,0" />
</head>

<body>
    <div class="container">
        <!-- HEADER AREA -->
        <?php include "./../components/header.php"?>

        <!-- MAIN AREA -->
        <main>
            <div class="product_details_container">
                <div class="product_details_upper">
                    <div class="product_details_upper_image">
                        <img src="<?php echo "../../admin/function/" . $product['image_url']; ?>" alt="">
                    </div>

                    <div
                        style="padding: 2.5rem 0; display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <h5 class="product_details_upper_title"><?php echo $product['product_name']; ?></h5>

                            <div style="font-size: 24px;" class="ratings_container">
                                <div class="ratings">
                                    <?php
                                    for ($i = 0; $i < 5; $i++) {
                                        if ($i < $avg_rating) {
                                            echo '<span class="filled-star">&#9733;</span>';
                                        } else {
                                            echo '<span class="empty-star">&#9733;</span>';
                                        }
                                    }
                                    ?>
                                </div>
                                <h5>(<?php echo $avg_rating; ?>)</h5>
                            </div>

                            <div>
                                <h5 class="product_details_upper_price">₱<?php echo $product['price']; ?></h5>
                                <div class="product_details_upper_discount">
                                    <h5 style="text-decoration: line-through; font-size: 16px; font-weight: 400;">
                                        ₱<?php echo $product['previous_price']; ?>
                                    </h5>
                                    <span
                                        style="text-decoration: none; font-size: 15px; color: #535353;"><?php echo $less_price?>%</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="quantity">
                                <h5>Quantity</h5>
                                <div class="quantity_count">
                                    <div class="quantity_button minus disabled"><span
                                            class="material-symbols-outlined">remove</span></div>
                                    <div class="count">1</div>
                                    <div class="quantity_button add"><span class="material-symbols-outlined">add</span>
                                    </div>
                                </div>
                                <p>max. of 10</p>
                            </div>
                            <div class="product_details_upper_button">
                                <a href="#" id="buy_now_link">Buy now</a>
                                <button>Add to cart</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="product_details_middle">
                    <h1>Product details of <?php echo $product['product_name']; ?> - <?php
                      $seller_id = $product['seller_id'];

                      $sql_sname = "SELECT * FROM sellers WHERE sellerID = $seller_id";
                      $seller_name = mysqli_query($conn, $sql_sname);

                      if ($seller_name && mysqli_num_rows($seller_name) > 0) {
                        // Fetch product details
                        $seller = mysqli_fetch_assoc($seller_name);
                
                    echo $seller['store_name']; 
                    
                    ?></h1>

                    <div class="product_description">
                        <h6><?php echo $product['description']; ?>
                        </h6>
                    </div>
                </div>

                <div class="product_details_middle">
                    <h1>Ratings & Reviews of <?php echo $product['product_name']; ?> -
                        <?php echo $seller['store_name']; ?></h1>

                    <div class="product_ratings">
                        <div>
                            <div class="product_rating_container">
                                <div class="rating_score"><?php echo $avg_rating; ?><span>/5</span></div>
                                <div>
                                    <div class="ratings_container">
                                        <div class="ratings">
                                            <?php
                                    for ($i = 0; $i < 5; $i++) {
                                        if ($i < $avg_rating) {
                                            echo '<span class="filled-star">&#9733;</span>';
                                        } else {
                                            echo '<span class="empty-star">&#9733;</span>';
                                        }
                                    }
                                    ?>
                                        </div>
                                        <h5>(<?php echo $avg_rating; ?>)</h5>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="border_up_down bold">
                                    Product Reviews
                                </div>

                                <div class="product_customer_review">
                                    <div class="upper_review">
                                        <div class="ratings_container">
                                            <div class="ratings">
                                                <span class="filled-star">&#9733;</span>
                                                <span class="filled-star">&#9733;</span>
                                                <span class="filled-star">&#9733;</span>
                                                <span class="filled-star">&#9733;</span>
                                                <span class="empty-star">&#9733;</span>
                                            </div>
                                        </div>
                                        <h5>2 weeks ago</h5>
                                    </div>

                                    <div class="costumer_review">
                                        <h5>Harold V.</h5>
                                        <h4>received all the seeds, but paanu malalaman kung Alin o anung seeds to Wala
                                            man lang label.</h4>
                                        <h6>Variant: <span>100pcs /box</span></h6>
                                    </div>
                                </div>

                                <div class="product_customer_review">
                                    <div class="upper_review">
                                        <div class="ratings_container">
                                            <div class="ratings">
                                                <span class="filled-star">&#9733;</span>
                                                <span class="filled-star">&#9733;</span>
                                                <span class="filled-star">&#9733;</span>
                                                <span class="filled-star">&#9733;</span>
                                                <span class="filled-star">&#9733;</span>
                                            </div>
                                        </div>
                                        <h5>2 weeks ago</h5>
                                    </div>

                                    <div class="costumer_review">
                                        <h5>Kim Carlo J.</h5>
                                        <h4>Mabilis na deliver yung order ko and sana lagyan na nila ng pangalan yung
                                            mga seeds na binili ko para hindi na ako magtanong paisa isa.
                                            Thank you.</h4>
                                        <h6>Variant: <span>100pcs /box</span></h6>
                                    </div>
                                </div>

                                <div class="product_customer_review">
                                    <div class="upper_review">
                                        <div class="ratings_container">
                                            <div class="ratings">
                                                <span class="filled-star">&#9733;</span>
                                                <span class="filled-star">&#9733;</span>
                                                <span class="filled-star">&#9733;</span>
                                                <span class="filled-star">&#9733;</span>
                                                <span class="filled-star">&#9733;</span>
                                            </div>
                                        </div>
                                        <h5>1 month ago</h5>
                                    </div>

                                    <div class="costumer_review">
                                        <h5>Allen B.</h5>
                                        <h4>Nag start lang ako 2 day ago. Sinunod ko yung instructions na kasama. Wala
                                            kong ibang tray kundi egg tray lang at 1st time ko lang kaya eto na muna
                                            ginamit ko. Sa ibang seeds nag experiment ako at na-amazed ako sa results.
                                            Thanks po sa free labanos seed, nag sprout na sya</h4>
                                        <h6>Variant: <span>100pcs /box</span></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="related_products">
                    <h2>Related Products</h2>


                    <div class="related_product_container">
                        <?php
                        }
                        include_once "./../../config/dbCon.php";

                        $sql = "SELECT p.*, AVG(r.rating) AS avg_rating FROM products p LEFT JOIN Ratings r ON p.product_id = r.product_id GROUP BY p.product_id";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $image_url = "../../admin/function/" . $row['image_url'];
                                ?>
                        <a href="/project/client/pages/productDetails.php?product_id=<?php echo $row['product_id']; ?>"
                            class="product-card">
                            <div class="image_container">
                                <img src="<?php echo $image_url; ?>" alt="">
                            </div>
                            <div class="product_details">
                                <h5 class="product_title"><?php echo $row['product_name']; ?></h5>
                                <h5 class="product_price"><?php echo '₱' . $row['price']; ?></h5>
                                <h5
                                    style="font-size: 13px; color: #838383; margin-top: -10px; text-decoration: line-through;">
                                    <?php echo '₱' . $row['previous_price']; ?></h5>
                                <h5 class="product_location">
                                    <span class="material-symbols-outlined">
                                        location_on
                                    </span>
                                    <?php echo $row['location']; ?>
                                </h5>
                                <div class="ratings_container">
                                    <div class="ratings">
                                        <?php
                                        $avg_rating = round($row['avg_rating']);
                                        for ($i = 0; $i < 5; $i++) {
                                        if ($i < $avg_rating) {
                                            echo '<span class="filled-star">&#9733;</span>';
                                        } else {
                                            echo '<span class="empty-star">&#9733;</span>';
                                        }
                                        }
                                        ?>
                                    </div>
                                    <h5>(<?php echo $avg_rating; ?>)</h5>
                                </div>
                            </div>
                        </a>
                        <?php
                            }
                        } else {
                            echo "No products found.";
                        }
                        ?>

                        <span class="material-symbols-outlined">
                            arrow_right_alt
                        </span>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const countElement = document.querySelector('.count');
        const addButton = document.querySelector('.add');
        const minusButton = document.querySelector('.minus');
        const buyNowLink = document.getElementById('buy_now_link');

        let count = parseInt(countElement.textContent);

        addButton.addEventListener('click', function() {
            if (count < 10) {
                count++;
                countElement.textContent = count;
                minusButton.removeAttribute('disabled');
                minusButton.classList.remove('disabled');
            }
            if (count > 9) {
                addButton.setAttribute('disabled', 'disabled');
                addButton.classList.add('disabled');
            }

            updateBuyNowLink(count);
        });

        minusButton.addEventListener('click', function() {
            if (count > 1) {
                count--;
                countElement.textContent = count;
                addButton.removeAttribute('disabled');
                addButton.classList.remove('disabled');
            }
            if (count < 2) {
                minusButton.setAttribute('disabled', 'disabled');
                minusButton.classList.add('disabled');
            }

            updateBuyNowLink(count);
        });

        function updateBuyNowLink(quantity) {
            var url = '/project/client/pages/buyNow.php';
            var productId = getParameterByName('product_id');
            if (productId) {
                url += '?product_id=' + productId;
            }
            url += '&quantity=' + quantity;
            buyNowLink.href = url;
        }

        function getParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, '\\$&');
            var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }

        buyNowLink.addEventListener('click', function() {
            if (count === 1) {
                updateBuyNowLink(1);
            }
            window.location.href = buyNowLink.href;
        });
    });

    const variantItems = document.querySelectorAll('.variant_items');

    variantItems.forEach(item => {
        item.addEventListener('click', function() {
            variantItems.forEach(item => {
                item.classList.remove('active_variant');
            });

            this.classList.add('active_variant');
        });
    });
    </script>





</body>

</html>
<?php
    } else {
        echo "Product not found.";
    }

    mysqli_close($conn);
} else {
    echo "Product ID not provided.";
}
?>