<?php
session_start();

include_once "./../../config/dbCon.php";

if (isset($_GET['product_id'])) {
$product_id = $_GET['product_id'];

$sql_product = "SELECT * FROM products WHERE product_id = $product_id";
$result_product = mysqli_query($conn, $sql_product);

if ($result_product && mysqli_num_rows($result_product) > 0) {
$product = mysqli_fetch_assoc($result_product);


mysqli_free_result($result_product);

$less_price = round((1 - ($product['previous_price'] / $product['price'])) * 100);

 $sql_reviews = "SELECT r.review_text   , r.created_at, c.customerName FROM reviews r JOIN customers c ON r.customer_id = c.customerID WHERE r.product_id = $product_id";
 $result_reviews = mysqli_query($conn, $sql_reviews);
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

                            <!-- <div style="font-size: 24px;" class="ratings_container">
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
                            </div> -->

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
                                <form method="post" action="./../function/addCart.php">
                                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                    <input type="hidden" name="quantity" id="quantity_input" value="1">
                                    <button type="add_to_cart" name="add_to_cart">Add to cart</button>
                                </form>
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
                        $seller = mysqli_fetch_assoc($seller_name);
                
                    echo $seller['store_name']; 
                    
                    ?></h1>

                    <div class="product_description">
                        <h6><?php echo $product['description']; ?>
                        </h6>
                    </div>
                </div>

                <div class="product_details_middle">
                    <h1>Reviews of <?php echo $product['product_name']; ?> -
                        <?php echo $seller['store_name']; ?></h1>

                    <div class="product_ratings">
                        <div>


                            <div>
                                <div class="border_up_down bold">
                                    Product Reviews
                                </div>

                                <?php
                                if ($result_reviews && mysqli_num_rows($result_reviews) > 0) {
                                    while ($review = mysqli_fetch_assoc($result_reviews)) {
                                        ?>
                                <div class="product_customer_review">
                                    <div class="upper_review">
                                        <div class="ratings_container">
                                        </div>
                                        <h5><?php echo date('F j, Y', strtotime($review['created_at'])); ?></h5>
                                    </div>

                                    <div class="costumer_review">
                                        <?php
                                        $name_parts = explode(' ', $review['customerName']);
                                        $first_name = $name_parts[0];
                                        $last_initial = isset($name_parts[1]) ? substr($name_parts[1], 0, 1) . '.' : '';

                                        $formatted_name = $first_name . ' ' . $last_initial;
                                        ?>
                                        <h5><?php echo $formatted_name; ?></h5>
                                        <h4><?php echo $review['review_text']; ?></h4>
                                    </div>

                                </div>
                                <?php
                                    }
                                    mysqli_free_result($result_reviews);
                                } else {
                                    echo "<div style='height: 5rem; align-items: center; display: flex; justify-content: center;'>No reviews found.</div>";
                                }
                                ?>
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

                        $sql = "SELECT * FROM products";
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
        const quantityInput = document.getElementById('quantity_input');

        let count = parseInt(countElement.textContent);

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

        addButton.addEventListener('click', function() {
            if (count < 10) {
                count++;
                countElement.textContent = count;
                minusButton.removeAttribute('disabled');
                minusButton.classList.remove('disabled');
            }
            if (count >= 10) {
                addButton.setAttribute('disabled', 'disabled');
                addButton.classList.add('disabled');
            }
            updateBuyNowLink(count);
            updateQuantityInput(count);
        });

        minusButton.addEventListener('click', function() {
            if (count > 1) {
                count--;
                countElement.textContent = count;
                addButton.removeAttribute('disabled');
                addButton.classList.remove('disabled');
            }
            if (count <= 1) {
                minusButton.setAttribute('disabled', 'disabled');
                minusButton.classList.add('disabled');
            }
            updateBuyNowLink(count);
            updateQuantityInput(count);
        });

        function updateQuantityInput(quantity) {
            quantityInput.value = quantity;
        }

        buyNowLink.addEventListener('click', function(event) {
            event.preventDefault();
            if (count === 1) {
                updateBuyNowLink(1);
            }
            window.location.href = buyNowLink.href;
        });

        updateBuyNowLink(count);
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