<?php
session_start();
require_once './../../config/dbCon.php';

if (!isset($_SESSION['customerUsername'])) {
    header("Location: /project/client/pages/login.php");
    exit(0);
}

$customer_username = $_SESSION['customerUsername'];
$search_username_query = "SELECT customerUsername, customerName, customerID FROM customers WHERE customerUsername = '$customer_username'";
$customer_result = mysqli_query($conn, $search_username_query);

if ($customer_result && mysqli_num_rows($customer_result) > 0) {
    $customer = mysqli_fetch_assoc($customer_result);
    $customerID = $customer['customerID'];

    // Shipping INFO
    $billing_address_query = "SELECT ship_name, ship_contact, ship_address FROM shipping_info WHERE customer_id = '$customerID'";
    $shipping_result = mysqli_query($conn, $billing_address_query);

    if ($shipping_result && mysqli_num_rows($shipping_result) > 0) {
        $shipping = mysqli_fetch_assoc($shipping_result);
    }

    // Recent Orders
    $orders_query = "
        SELECT orders.order_id, orders.order_date, orders.status, products.product_id, products.product_name, order_items.quantity, order_items.item_price
        FROM orders
        JOIN order_items ON orders.order_id = order_items.order_id
        JOIN products ON order_items.product_id = products.product_id
        WHERE orders.customer_id = '$customerID'
        ORDER BY orders.order_date";
    $orders_result = mysqli_query($conn, $orders_query);

    $orders = [];
    if ($orders_result && mysqli_num_rows($orders_result) > 0) {
        while ($order = mysqli_fetch_assoc($orders_result)) {
            $orders[] = $order;
        }
    }
} else {
    header("Location: /project/client/pages/login.php");
    exit(0);
}

// Handle review submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["review"])) {
    $product_id = $_POST['product_id'];
    $review_text = $_POST['review'];

    $insert_review_query = "INSERT INTO reviews (product_id, customer_id, review_text) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insert_review_query);
    mysqli_stmt_bind_param($stmt, 'iis', $product_id, $customerID, $review_text);

    if (mysqli_stmt_execute($stmt)) {
        echo "Review submitted successfully!";
    } else {
        echo "Error submitting review: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | Harvest Hub</title>
    <link rel="stylesheet" href="./../style/index.css">
    <link rel="stylesheet" href="./../style/orders.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,300,0,0" />
    <link rel="shortcut icon" href="../assets/favicon.webp" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div>
        <header>
            <div class="header-container">
                <div class="upper">
                    <div>
                        <ul class="upper-part-nav">
                            <li><a href="/project/client/pages/seller-login.php"><span
                                        class="material-symbols-outlined">storefront</span>Seller Center</a></li>
                            <li><a href="#"><span class="material-symbols-outlined">help</span>About us</a></li>
                        </ul>
                    </div>
                </div>

                <div class="middle">
                    <a href="/project/client/" class="logo">
                        <h1>Harvest</h1>
                        <span>hub</span>
                    </a>
                    <form action="/project/client/search_results.php" method="GET" class="search">
                        <input placeholder="Search..." type="search" name="query" id="search">
                        <button type="submit"><span class="material-symbols-outlined">search</span></button>
                    </form>

                    <?php if (isset($_SESSION['customerUsername'])): ?>
                    <div style="display: flex; gap: 10px; justify-content: center; align-items: center;">
                        <a href="/project/client/pages/cart.php">
                            <span style="font-size: 35px; font-weight: 500; cursor: pointer;"
                                class="material-symbols-outlined">shopping_cart</span>
                        </a>
                        <div class="profile-container">
                            <span style="font-size: 35px; font-weight: 500; cursor: pointer;"
                                class="material-symbols-outlined profile-icon">account_circle</span>
                            <div class="dropdown-menu">
                                <ul>
                                    <li><a style="display: flex; gap: 5px;"
                                            href="/project/client/pages/profile.php"><span
                                                class="material-symbols-outlined">person</span>Profile</a></li>
                                    <li><a style="display: flex; gap: 5px;" href="#"><span
                                                class="material-symbols-outlined">shopping_bag</span>Orders</a></li>
                                    <li><a style="display: flex; gap: 5px; color: red; font-weight: 600;"
                                            href="/project/logout.php"><span
                                                class="material-symbols-outlined">logout</span>Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="login-status">
                        <a class="signup-button" href="/project/client/pages/signup.php">Sign Up</a>
                        <a class="login-button" href="/project/client/pages/login.php">Login</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </header>

        <main class="py-[8rem] w-full">
            <div class="pt-[1rem] px-2 sm:px-[5rem]">
                <!-- ORDER TABLE -->
                <p class="text-2xl text-slate-800 mb-3">Recent Order/s</p>

                <div class="bg-white w-full mt-5 overflow-y-auto md:max-h-[30rem]">
                    <table class="w-full overflow-x-auto">
                        <colgroup>
                            <col style="width: 5rem;">
                            <col style="width: 30rem;">
                            <col style="width: 40rem;">
                            <col style="width: 9rem;">
                            <col style="width: 10rem;">
                            <col style="width: 20%;">
                        </colgroup>

                        <thead class="border-b border-b-slate-300">
                            <tr>
                                <th class="py-4 bg-slate-200">Order #</th>
                                <th rowspan="1" class="py-4 bg-slate-200">Placed On</th>
                                <th rowspan="1" class="py-4 bg-slate-200">Items</th>
                                <th rowspan="1" class="py-4 bg-slate-200">Total</th>
                                <th rowspan="1" class="py-4 bg-slate-200">Status</th>
                                <th rowspan="1" class="py-4 bg-slate-200"></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($orders)): ?>
                            <?php foreach ($orders as $order): ?>
                            <tr class="text-center border-b border-b-slate-200 h-[4rem] max-h-[4rem]">
                                <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                                <td><?php echo htmlspecialchars(date('m/d/Y', strtotime($order['order_date']))); ?></td>
                                <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                                <td>₱<?php echo number_format($order['item_price'] * $order['quantity'], 2); ?></td>
                                <td><?php echo htmlspecialchars($order['status']); ?></td>
                                <?php
                                if(($order['status']) == 'delivered' || ($order['status']) == 'Delivered'){
                                    echo "<td class='bg-indigo-500 text-white cursor-pointer' data-product-id='{$order['product_id']}'>Add review</td>";
                                } else{
                                    echo "<td></td>";
                                }
                                ?>

                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4">No recent orders found.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Add Review</h2>
            <form id="reviewForm" method="POST" action="">
                <input type="hidden" name="product_id" id="product_id">
                <textarea name="review" id="review" placeholder="Write your review here..."
                    style="width: 100%; border: 1px solid gray; padding: 10px; height: 10rem; margin-bottom: 10px;"
                    required></textarea>
                <div style="display: flex; justify-content: center;">
                    <button type="submit"
                        style="background-color: blue; color: white; padding: 10px 25px; border-radius: 5px;">Submit
                        Review</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var profileIcon = document.querySelector(".profile-icon");
        var dropdownMenu = document.querySelector(".dropdown-menu");

        profileIcon.addEventListener("click", function() {
            dropdownMenu.classList.toggle("show");
        });

        document.addEventListener("click", function(event) {
            if (!dropdownMenu.contains(event.target) && !profileIcon.contains(event.target)) {
                dropdownMenu.classList.remove("show");
            }
        });

        var reviewLinks = document.querySelectorAll(".bg-indigo-500.text-white.cursor-pointer");
        reviewLinks.forEach(function(link) {
            link.addEventListener("click", function() {
                var productId = this.getAttribute("data-product-id");
                var modal = document.getElementById("myModal");
                document.getElementById("product_id").value = productId;
                modal.style.display = "block";
            });
        });

        var closeBtn = document.querySelector(".close");
        closeBtn.addEventListener("click", function() {
            var modal = document.getElementById("myModal");
            modal.style.display = "none";
        });

        window.addEventListener("click", function(event) {
            var modal = document.getElementById("myModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        });

        document.getElementById("reviewForm").addEventListener("submit", function(event) {
            event.preventDefault();
            var form = this;
            var formData = new FormData(form);
            fetch("", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    alert("Review submitted successfully!");
                    form.reset();
                    document.getElementById("myModal").style.display = "none";
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("There was an error submitting your review.");
                });
        });
    });
    </script>

</body>

</html>