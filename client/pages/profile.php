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
        SELECT orders.order_id, orders.order_date, products.product_name, order_items.quantity, order_items.item_price
        FROM orders
        JOIN order_items ON orders.order_id = order_items.order_id
        JOIN products ON order_items.product_id = products.product_id
        WHERE orders.customer_id = '$customerID'
        ORDER BY orders.order_date DESC
        LIMIT 5";
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | Harvest Hub</title>
    <link rel="stylesheet" href="./../style/index.css">
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
                            <li><a href="#"><span class="material-symbols-outlined">
                                        help
                                    </span>About us</a></li>
                        </ul>
                    </div>
                </div>

                <div class="middle">
                    <a href="/project/client/" class="logo">
                        <h1>Harvest</h1>
                        <span>hub</span>
                    </a>
                    <form action="/project/client/" method="POST" class="search">
                        <input placeholder="Search..." type="search" name="search" id="search">
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
                                    <li><a style="display: flex; gap: 5px;"
                                            href="/project/client/pages/orders.php"><span
                                                class="material-symbols-outlined">shopping_bag</span>Orders</a></li>
                                    <li><a style="display: flex; gap: 5px; color: red; font-weight: 600;"
                                            href="/project/logout.php"><span
                                                class="material-symbols-outlined">logout</span>Logout</a>
                                    </li>
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
            <div class="pt-[1rem] px-3 md:px-[5rem]">
                <p class="text-2xl text-slate-800 mb-4">Manage My Account</p>

                <div class="flex gap-6 w-full text-slate-700">
                    <div class="bg-white px-4 py-3 w-[500px] h-[240px]">
                        <div class="flex gap-2 mb-3">
                            <h2 class="text-slate-900">Personal Profile</h2>
                            <span class="text-slate-300">|</span>
                            <h2 class="text-blue-500 cursor-pointer">Edit</h2>
                        </div>

                        <div class="h-[154px] overflow-y-auto">
                            <p><?php echo htmlspecialchars($customer['customerName']); ?></p>
                            <p><?php echo htmlspecialchars($customer['customerUsername']); ?></p>
                        </div>
                    </div>

                    <div class="bg-white px-4 py-3 w-[1000px] h-[240px]">
                        <div class="flex gap-2 mb-3">
                            <h2 class="text-slate-900">Address Book</h2>
                            <span class="text-slate-300">|</span>
                            <h2 class="text-blue-500 cursor-pointer">Edit</h2>
                        </div>

                        <div class="h-[154px] overflow-y-auto">
                            <p class="text-slate-400 mb-2">Default Shipping Address</p>
                            <p class="font-bold"><?php echo htmlspecialchars($shipping['ship_name']); ?></p>
                            <p><?php echo htmlspecialchars($shipping['ship_contact']); ?></p>
                            <p><?php echo htmlspecialchars($shipping['ship_address']); ?></p>
                        </div>
                    </div>
                </div>

                <!-- ORDER TABLE -->
                <p class="text-2xl text-slate-800 mt-5 mb-3">Recent Order/s</p>

                <div class="bg-white w-full mt-5 overflow-y-hidden">
                    <table class="w-full">
                        <colgroup>
                            <col style="width: 20%;">
                            <col style="width: 20%;">
                            <col style="width: 30%;">
                            <col style="width: 20%;">
                            <col style="width: 20%;">
                        </colgroup>

                        <thead class="border-b border-b-slate-300">
                            <tr>
                                <th rowspan="1" class="py-4 bg-slate-200">Order #</th>
                                <th rowspan="1" class="py-4 bg-slate-200">Placed On</th>
                                <th rowspan="1" class="py-4 bg-slate-200">Items</th>
                                <th rowspan="1" class="py-4 bg-slate-200">Total</th>
                                <th rowspan="1" class="py-4 bg-slate-200">Quantity</th>
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
                                <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-4">No recent orders found.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var profileIcon = document.querySelector(".profile-icon");
        var dropdownMenu = document.querySelector(".dropdown-menu");

        profileIcon.addEventListener("click", function() {
            dropdownMenu.classList.toggle("show");
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", function(event) {
            if (!dropdownMenu.contains(event.target) && !profileIcon.contains(event.target)) {
                dropdownMenu.classList.remove("show");
            }
        });
    });
    </script>
</body>

</html>