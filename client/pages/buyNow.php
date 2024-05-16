<?php 
include_once './../../config/dbCon.php';

session_start();

if(isset($_SESSION['customerUsername'])){
    $customerUsername = $_SESSION['customerUsername'];

    $sql = "SELECT customerID FROM customers WHERE customerUsername = '$customerUsername'";
    $result = mysqli_query($conn, $sql);

    if($result){
        $row = mysqli_fetch_assoc($result);
        $session_id = $row['customerID'];

        $shipping_info_sql = "SELECT * FROM shipping_info WHERE customer_id = $session_id";
        $shipping_info_result = mysqli_query($conn, $shipping_info_sql);

        if($shipping_info_result){
            if(mysqli_num_rows($shipping_info_result) > 0){
                $shipping_info_row = mysqli_fetch_assoc($shipping_info_result);
                $shipping_info_exists = true;
            } else {
                $shipping_info_exists = false;
            }
        } else {
            echo "Error: " . $shipping_info_sql . "<br>" . mysqli_error($conn);
        }
        
        $product_id = mysqli_real_escape_string($conn, $_GET['product_id']);
        $quantity = mysqli_real_escape_string($conn, $_GET['quantity']);
        
        $product_query = "SELECT * FROM products WHERE product_id = $product_id";
        $product_result = mysqli_query($conn, $product_query);
        
        if($product_result && mysqli_num_rows($product_result) > 0) {
            $product_row = mysqli_fetch_assoc($product_result);
            $less_price = round((1 - ($product_row['previous_price'] / $product_row['price'])) * 100);
            $subtotal = $product_row['price'] * $quantity;
            $computed_subtotal = number_format($subtotal, 2);
            $compute = $computed_subtotal + 49;

            $total_price = number_format($compute, 2);

             $seller_id = $product_row['seller_id'];

             $sql_sname = "SELECT * FROM sellers WHERE sellerID = $seller_id";
             $seller_name = mysqli_query($conn, $sql_sname);

             if ($seller_name && mysqli_num_rows($seller_name) > 0) {
                 $seller = mysqli_fetch_assoc($seller_name);
            }
        } else {
            echo "No product found with ID: $product_id";
        }

        if(isset($_POST['placeOrder'])) {
            $insert_order_query = "INSERT INTO orders (customer_id, total_amount, status) VALUES ($session_id, $total_price, 'Pending')";
            $insert_order_result = mysqli_query($conn, $insert_order_query);

            if($insert_order_result) {
                $order_id = mysqli_insert_id($conn);

                $insert_order_items_query = "INSERT INTO order_items (order_id, product_id, quantity, item_price) VALUES ($order_id, $product_id, $quantity, $total_price)";
                $insert_order_items_result = mysqli_query($conn, $insert_order_items_query);

                if($insert_order_items_result) {
                    $new_quantity = $product_row['quantity'] - $quantity;
                    $update_inventory_query = "UPDATE products SET quantity = $new_quantity WHERE product_id = $product_id";
                    $update_inventory_result = mysqli_query($conn, $update_inventory_query);

                    if($update_inventory_result) {
                        header("Location: /project/client/pages/orderConfirmation.php?order_id=$order_id");
                        exit();
                    } else {
                        echo "Error updating product inventory: " . mysqli_error($conn);
                    }
                } else {
                    echo "Error inserting order items: " . mysqli_error($conn);
                }
            } else {
                echo "Error inserting order: " . mysqli_error($conn);
            }
        }
    } else {
        echo "No customer found with the username: $customerUsername";
    }

    mysqli_close($conn);    
} else {
    header("Location: /project/client/pages/login.php");
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | <?php echo $product_row['product_name']?></title>
    <link rel="stylesheet" href="../style/index.css">
    <link rel="stylesheet" href="../style/buyNow.css">
    <link rel="shortcut icon" href="../assets/favicon.webp" type="image/x-icon">
    <script src="https://kit.fontawesome.com/e9d841c4cd.js" crossorigin="anonymous"></script>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>

<body>
    <div class="container">
        <header>
            <div class="header-container">
                <div class="middle">
                    <a href="/project/client/" class="logo">
                        <!-- <img src="../assets/plant.webp" alt="l"> -->
                        <h1>Harverst</h1>
                        <span>hub</span>
                    </a>
                </div>
            </div>
        </header>

        <div class="buy_container">
            <div id="editModal" class="modal">
                <div class="modal-content">
                    <div style="display: flex; justify-content: space-between;">
                        <h4>Edit Shipping Information</h4>
                        <i class="fa-solid fa-x close" id="close"></i>
                    </div>
                    <form id="editShippingForm" action="../function/editShipping.php" method="post">
                        <input type="hidden" name="shipping_id" value="<?php echo $shipping_info_row['ship_id']; ?>">
                        <label for="edit_name">Name</label>
                        <input type="text" id="edit_name" name="edit_name"
                            value="<?php echo $shipping_info_row['ship_name']; ?>">

                        <label for="edit_phone">Phone</label>
                        <input type="text" id="edit_phone" name="edit_phone"
                            value="<?php echo $shipping_info_row['ship_contact']; ?>">

                        <label for="edit_address">Address</label>
                        <textarea id="edit_address"
                            name="edit_address"><?php echo $shipping_info_row['ship_address']; ?></textarea>

                        <button type="submit" id="saveChangesBtn" name="editShipping">Save Changes</button>
                    </form>
                </div>
            </div>

            <div id="addShipping" class="modal">
                <div class="modal-content">
                    <div style="display: flex; justify-content: space-between;">
                        <h4>Add Shipping Information</h4>
                        <i class="fa-solid fa-x close" id="closeShippingBtn"></i>
                    </div>

                    <form action="../function/shippingFunction.php" method="post">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter your name">

                        <label for="phone">Phone</label>
                        <input type="text" id="phone" name="phone" placeholder="Enter your phone number">

                        <label for="address">Address</label>
                        <textarea id="address" name="address" placeholder="Enter your address"></textarea>

                        <button id="saveChangesBtn" name="addShipping" onclick="saveChanges()">Save</button>
                    </form>
                </div>
            </div>

            <div class="left_container">
                <div class="box_container">
                    <div class="box_title">
                        <h5>Shipping Address</h5>
                        <a href="" id="edit">Edit</a>
                    </div>
                    <div class="box_content">
                        <?php if ($shipping_info_exists) { ?>
                        <h5 style="font-weight: 400; font-size: 14px;"><?php echo $shipping_info_row['ship_name']; ?>
                            <span style="margin-left: 2rem;"><?php echo $shipping_info_row['ship_contact']; ?></span>
                        </h5><br>
                        <h5 style="font-weight: 400; font-size: 14px;"><?php echo $shipping_info_row['ship_address']; ?>
                        </h5>
                        <?php } else { ?>
                        <p style="color: #555555;">No shipping info. Click <span
                                style="color: blue; text-decoration: underline; cursor: pointer;"
                                id="addShippingBtn">here</span>
                            to add your shipping info.</p>
                        <?php } ?>
                    </div>
                </div>

                <div class="box_container">
                    <div class="box_title">
                        <h5 style="font-weight: 600;">Package</h5>
                        <h5 style="font-size: 13px;">Shipped by <span
                                style="font-weight: 600; text-transform: uppercase;"><?php echo $seller['store_name']; ?></span>
                        </h5>
                    </div>
                    <div class="box_content">
                        <div class="buy_now_item">
                            <a href="/project/client/pages/productDetails.php?product_id=<?php echo $product_row['product_id']?>"
                                class="image_container">
                                <img src="<?php echo "../../admin/function/" . $product_row['image_url']; ?>" alt="">
                            </a>

                            <div style="margin-left: 10px;">
                                <h5
                                    style="font-size: 14px; font-weight: 400; width: 350px; max-width: 350px; margin-bottom: 5px;">
                                    <?php echo $product_row['product_name']?></h5>
                            </div>

                            <div style="margin-left: 2rem;">
                                <h5 style="font-size: 20px; font-weight: 500;">₱<?php echo $product_row['price']?></h5>
                                <h5
                                    style="font-size: 13px; font-weight: 400; color: #757575; text-decoration: line-through;">
                                    ₱<?php echo $product_row['previous_price']?></h5>
                                <h5 style="font-size: 13px; font-weight: 400; color: #757575;"><?php echo $less_price?>%
                                </h5>
                            </div>

                            <h5 style="margin-left: 5rem; font-size: 15px; font-weight: 500;">Qty:
                                <?php echo $quantity?></h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="right_container">
                <form action="" method="post">
                    <div class="payment_method">
                        <h3 style="font-weight: 400; font-size: 22px;">Select Payment Method</h3>
                        <div>
                            <div class="payment_option_box checked">
                                <div>
                                    <div style="display: flex; justify-content: space-between; margin-top: 0.7rem;">
                                        <div style="display: flex; gap: 4px; padding-top: 15px;">
                                            <span style="color: #85bb65;"
                                                class="material-symbols-outlined">payments</span>
                                            <p style="color: #555555;">Cash On Delivery</p>
                                        </div>
                                        <div class="custom-radio">
                                            <input type="radio" id="cashOnDelivery" name="paymentMethod" checked>
                                            <label for="cashOnDelivery"></label>
                                        </div>
                                    </div>
                                    <p style="margin-top: 1.2rem; font-size: 13px; color: #757575;">Pay when you receive
                                    </p>
                                </div>
                            </div>

                            <div class="payment_option_box disabled">
                                <div>
                                    <div style="display: flex; justify-content: space-between; margin-top: 0.7rem;">
                                        <div style="display: flex; gap: 4px; padding-top: 15px;">
                                            <img style="height: 40px; width: 40px;"
                                                src="https://img.lazcdn.com/g/tps/tfs/TB1CxFjmkY2gK0jSZFgXXc5OFXa-1025-1025.png_2200x2200q80.png_.webp"
                                                alt="">
                                            <div>
                                                <p style="color: #555555;">Gcash e-Wallet</p>
                                                <p style="font-size: 13px; color: #757575;">Available soon!</p>
                                            </div>
                                        </div>
                                        <div class="custom-radio">
                                            <input type="radio" id="gcashPayment" name="paymentMethod">
                                            <label for="gcashPayment"></label>
                                        </div>
                                    </div>
                                    <p style="margin-top: 1.2rem; font-size: 13px; color: #757575;">Gcash e-Wallet</p>
                                </div>
                            </div>
                        </div>


                        <div class="order_summary">
                            <h3 style="font-weight: 500; font-size: 19px; margin-top: 1.7rem; color: #353535;">Order
                                Summary
                            </h3>

                            <div>
                                <div style="display: flex; justify-content: space-between; margin-top: 0.7rem;">
                                    <p style="color: #757575;">Subtotal (1 item)</p>
                                    <p>₱<?php echo $computed_subtotal?></p>
                                </div>
                                <div style="display: flex; justify-content: space-between; margin-top: 0.7rem;">
                                    <p style="color: #757575;">Shipping fee</p>
                                    <p>₱49.00</p>
                                </div>

                                <div
                                    style="display: flex; justify-content: space-between;align-items: center; margin-top: 1.6rem; border-top: 1px solid #dedede; padding-top: 20px;">
                                    <p style="color: #757575;">Total</p>
                                    <p style="font-size: 19px; font-weight: 600;">₱<?php echo $total_price?></p>
                                </div>
                            </div>
                        </div>

                        <button class="payment_button" name="placeOrder">PLACE YOUR ORDER NOW</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
    document.querySelectorAll('.custom-radio input[type="radio"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.payment_option_box').forEach(function(box) {
                box.classList.remove('checked');
            });
            if (this.checked) {
                this.closest('.payment_option_box').classList.add('checked');
            }
        });
    });

    var modal = document.getElementById("editModal");
    var editLink = document.getElementById('edit');
    var closeBtn = document.getElementById("close");

    editLink.onclick = function(event) {
        event.preventDefault();
        modal.style.display = "block";
    }

    closeBtn.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    var addShipping = document.getElementById('addShipping');
    var addShippingBtn = document.getElementById('addShippingBtn');
    var closeShippingBtn = document.getElementById('closeShippingBtn');

    addShippingBtn.onclick = function(e) {
        e.preventDefault();
        addShipping.style.display = 'block';
    }

    closeShippingBtn.onclick = function() {
        addShipping.style.display = 'none';
    }

    window.onclick = function(e) {
        if (e.target == addShipping) {
            addShipping.style.display = 'none';
        }
    }
    </script>
</body>


</html>