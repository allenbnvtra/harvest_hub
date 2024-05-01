<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style/index.css">
    <link rel="stylesheet" href="../style/buyNow.css">
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

        <div style="padding: 7rem 6rem; display: flex; gap: 1rem; justify-content: center;">
            <div class="left_container">
                <div class="box_container">
                    <div class="box_title">
                        <h5>Shipping Address</h5>
                        <a href="">Edit</a>
                    </div>
                    <div class="box_content">
                        <h5 style="font-weight: 400; font-size: 14px;">Allen Buenaventura <span
                                style="margin-left: 2rem;">09471010766</span></h5><br>
                        <h5 style="font-weight: 400; font-size: 14px;">A. Villora St. Lapnit, San Ildefonso, Bulacan,
                            Philippines</h5>
                    </div>
                </div>

                <div class="box_container">
                    <div class="box_title">
                        <h5 style="font-weight: 600;">Package</h5>
                        <h5 style="font-size: 13px;">Shipped by <span
                                style="font-weight: 600; text-transform: uppercase;">Allen Farm</span></h5>
                    </div>
                    <div class="box_content">
                        <div class="buy_now_item">
                            <div class="image_container">
                                <img src="./../assets/fruits/strawberry.jpg" alt="">
                            </div>

                            <div style="margin-left: 10px;">
                                <h5
                                    style="font-size: 14px; font-weight: 400; width: 350px; max-width: 350px; margin-bottom: 5px;">
                                    15 pcs Strawberry fresh from Benguet,
                                    Abra - Allen
                                    Buenaventura</h5>
                                <h5 style="font-weight: 500; color: #757575;">100pcs /box</h5>
                            </div>

                            <div style="margin-left: 2rem;">
                                <h5 style="font-size: 20px; font-weight: 500;">₱15.99</h5>
                                <h5
                                    style="font-size: 13px; font-weight: 400; color: #757575; text-decoration: line-through;">
                                    ₱25.99</h5>
                                <h5 style="font-size: 13px; font-weight: 400; color: #757575;">-15%</h5>
                            </div>

                            <h5 style="margin-left: 5rem; font-size: 15px; font-weight: 500;">Qty: 1</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="right_container">
                <div class="payment_method">
                    <h3 style="font-weight: 400; font-size: 22px;">Select Payment Method</h3>
                    <div>
                        <div class="payment_option_box checked">
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-top: 0.7rem;">
                                    <div style="display: flex; gap: 4px; padding-top: 15px;">
                                        <span style="color: #85bb65;" class="material-symbols-outlined">payments</span>
                                        <p style="color: #555555;">Cash On Delivery</p>
                                    </div>
                                    <div class="custom-radio">
                                        <input type="radio" id="cashOnDelivery" name="paymentMethod" checked>
                                        <label for="cashOnDelivery"></label>
                                    </div>
                                </div>
                                <p style="margin-top: 1.2rem; font-size: 13px; color: #757575;">Pay when you receive</p>
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
                        <h3 style="font-weight: 500; font-size: 19px; margin-top: 1.7rem; color: #353535;">Order Summary
                        </h3>

                        <div>
                            <div style="display: flex; justify-content: space-between; margin-top: 0.7rem;">
                                <p style="color: #757575;">Subtotal (1 item)</p>
                                <p>₱15.99</p>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-top: 0.7rem;">
                                <p style="color: #757575;">Shipping fee</p>
                                <p>₱49.00</p>
                            </div>

                            <div
                                style="display: flex; justify-content: space-between;align-items: center; margin-top: 1.6rem; border-top: 1px solid #dedede; padding-top: 20px;">
                                <p style="color: #757575;">Total</p>
                                <p style="font-size: 19px; font-weight: 600;">₱64.99</p>
                            </div>
                        </div>
                    </div>
 
                    <button class="payment_button">PLACE YOUR ORDER NOW</button>
                </div>
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
    </script>
</body>


</html>