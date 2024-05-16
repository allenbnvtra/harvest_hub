<?php
session_start();

if (!isset($_SESSION['sellerUsername'])) {
    header("Location: /project/client/pages/seller-login.php");
    exit();
}

include_once "./../config/dbCon.php";

$sellerUsername = $_SESSION['sellerUsername'];

$query = "SELECT sellerID FROM Sellers WHERE sellerUsername = '$sellerUsername'";
$result = mysqli_query($conn, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $seller_id = $row['sellerID'];

    $query = "SELECT orders.order_id, products.product_name, order_items.quantity, customers.customerName, orders.status
                FROM orders
                INNER JOIN order_items ON orders.order_id = order_items.order_id
                INNER JOIN products ON order_items.product_id = products.product_id
                INNER JOIN customers ON orders.customer_id = customers.customerID
                WHERE products.seller_id = '$seller_id'";
    $order_result = mysqli_query($conn, $query);
} else {
    echo "Error: Seller not found";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['order_id']) && isset($_POST['order_status'])) {
        $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
        $order_status = mysqli_real_escape_string($conn, $_POST['order_status']);

        $query = "UPDATE orders SET status = '$order_status' WHERE order_id = '$order_id'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            header('Location: /project/admin/orders.php');
        } else {
            echo "Error updating status";
        }
    } else {
        echo "Error: Required fields are not set";
    }
} else {
    echo "Error: Invalid request method";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <style>
    :root {
        --bg: #f1f5ff;
        --bgSoft: #182237;
        --text: white;
        --textSoft: #b7bac1;
    }

    html,
    body {
        margin: 0;
        padding: 0;
        color: #444444;
    }
    </style>

    <script src="https://kit.fontawesome.com/e9d841c4cd.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles/index.css">
</head>

<body class="bg-[var(--bg)]">
    <!-- Sidebar nav -->
    <div class="fixed z-50 top-0 left-0 w-64 h-full bg-[var(--bgSoft)] p-4">
        <div class="flex flex-col gap-5">
            <a href="/project/admin/index.php" class="text-white text-2xl font-bold text-center py-5">
                Harvest Hub Seller Center
            </a>

            <!-- Nav Items -->
            <div class="flex flex-col gap-2">
                <h1 class="text-sm font-semibold text-white text-sm">Pages</h1>
                <ul class="text-white text-md flex flex-col">
                    <li class="px-3 py-2 rounded-md">
                        <a class="flex items-center gap-2 w-full h-full" href="/project/admin/index.php">
                            <i class="fa-solid fa-house text-md"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="px-3 py-2 rounded-md">
                        <a class="flex items-center gap-2 w-full h-full" href="/project/admin/products.php">
                            <i class="fa-solid fa-users text-md"></i>
                            <p>Products</p>
                        </a>
                    </li>
                    <li class="px-3 py-2 rounded-md bg-[#2e374a]">
                        <a class="flex items-center gap-2 w-full h-full" href="/project/admin/orders.php">
                            <i class="fa-solid fa-users text-md"></i>
                            <p>orders</p>
                        </a>
                    </li>
                    <li class="px-3 py-2 rounded-md">
                        <a class="flex items-center gap-2 w-full h-full" href="/project/client">
                            <i class="fa-solid fa-shop text-md"></i>
                            <p>Marketplace</p>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="flex flex-col gap-2">
                <h1 class="text-sm font-semibold text-white text-sm">Settings</h1>
                <ul class="text-white text-md flex flex-col">
                    <li class="px-3 py-2 rounded-md">
                        <a class="flex items-center gap-2 w-full h-full" href="/project/logout.php">
                            <i class="fa-solid fa-right-from-bracket text-md"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Main -->
    <main class="w-full h-full pl-64 text-slate-900">
        <div>
            <header
                class="fixed w-full left-0 top-0 flex pl-[17rem] justify-between bg-white border-b border-b-slate-200 shadow-sm py-4 text-gray-800 text-sm font-semibold px-5 text-indigo-900">
                <div>
                    <h1 class="text-xl font-bold">Admin Dashboard</h1>
                </div>
                <div>
                    <h1 class="text-xl font-bold">Welcome, <?php echo $sellerUsername?></h1>
                </div>
            </header>
        </div>

        <div class="pt-16 px-4">
            <div class="product_container">
                <div style="display: flex; padding: 1rem 0; font-size: 20px; font-weight: 600;">
                    orders
                </div>
                <div class="flex justify-center">
                    <table>
                        <thead>
                            <th class="px-20 py-4">ID</th>
                            <th class="px-20 py-4">Product Name</th>
                            <th class="px-20 py-4">Quantity</th>
                            <th class="px-20 py-4">Customer Name</th>
                            <th class="px-20 py-4">Action</th>
                        </thead>

                        <tbody>
                            <?php
                            if ($order_result && mysqli_num_rows($order_result) > 0) {
                                while ($row = mysqli_fetch_assoc($order_result)) {
                                    echo "<tr class='text-center'>";
                                    echo "<td class='py-2'>" . $row['order_id'] . "</td>";
                                    echo "<td class='py-2'>" . $row['product_name'] . "</td>";
                                    echo "<td class='py-2'>" . $row['quantity'] . "</td>";
                                    echo "<td class='py-2'>" . $row['customerName'] . "</td>";
                                    echo "<td class='py-2'>";
                                    echo "<form action='' method='POST'>";
                                    echo "<input type='hidden' name='order_id' value='" . $row['order_id'] . "'>";
                                    echo "<select name='order_status' class='select_box' value='" . $row['status'] ."' onchange='this.form.submit()'>";
                                    echo "<option value='pending' " . ($row['status'] == 'pending' ? 'selected
                                    ' : '') . ">Pending</option>";
                                    echo "<option value='out_for_delivery' " . ($row['status'] == 'out_for_delivery' ? 'selected' : '') . ">Out for Delivery</option>";
                                    echo "<option value='delivered' " . ($row['status'] == 'delivered' ? 'selected' : '') . ">Delivered</option>";
                                    echo "<option value='cancelled' " . ($row['status'] == 'cancelled' ? 'selected' : '') . ">Cancelled</option>";
                                    echo "</select>";
                                    echo "</form>";
                                    echo "</td>";
                                    echo "</tr>";
                                    }
                                    } else {
                                    echo "<tr><td rowspan='5'>No Order/s found</td></tr>";
                                    }
                                    ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <footer class="flex justify-center py-5">
            <p class="text-slate-500">©All Rights Reserved - A's Technology</p>
        </footer>
    </main>


</body>

</html>