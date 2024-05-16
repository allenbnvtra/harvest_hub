<?php
session_start();

if (!isset($_SESSION['sellerUsername'])) {
    header("Location: /project/client/pages/seller-login.php");
    exit();
}

require_once './../config/dbCon.php'; 

$sellerUsername = $_SESSION['sellerUsername'];

$query = "SELECT sellerID FROM Sellers WHERE sellerUsername = '$sellerUsername'";
$result = mysqli_query($conn, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $seller_id = $row['sellerID'];
} else {
    echo "Error: Seller not found";
    exit();
}

$productsCountQuery = "SELECT COUNT(*) as count FROM products WHERE seller_id = '$seller_id'";
$pendingOrdersCountQuery = "SELECT COUNT(*) as count FROM orders WHERE status = 'pending' AND order_id IN 
                            (SELECT order_id FROM order_items WHERE product_id IN 
                            (SELECT product_id FROM products WHERE seller_id = '$seller_id'))";
$paidOrdersCountQuery = "SELECT COUNT(*) as count FROM orders WHERE status = 'delivered' AND order_id IN 
                            (SELECT order_id FROM order_items WHERE product_id IN 
                            (SELECT product_id FROM products WHERE seller_id = '$seller_id'))";

$productsCountResult = mysqli_query($conn, $productsCountQuery);
$pendingOrdersCountResult = mysqli_query($conn, $pendingOrdersCountQuery);
$paidOrdersCountResult = mysqli_query($conn, $paidOrdersCountQuery);

$productsCount = mysqli_fetch_assoc($productsCountResult)['count'];
$pendingOrdersCount = mysqli_fetch_assoc($pendingOrdersCountResult)['count'];
$paidOrdersCount = mysqli_fetch_assoc($paidOrdersCountResult)['count'];

$recentProductsQuery = "SELECT * FROM products WHERE seller_id = '$seller_id' ORDER BY created_at DESC LIMIT 5";
$recentProductsResult = mysqli_query($conn, $recentProductsQuery);

$recentOrdersQuery = "SELECT o.order_id, c.customerName, o.total_amount, o.order_date, o.status 
                      FROM orders o 
                      JOIN customers c ON o.customer_id = c.customerID 
                      WHERE o.order_id IN 
                      (SELECT order_id FROM order_items WHERE product_id IN 
                      (SELECT product_id FROM products WHERE seller_id = '$seller_id'))
                      ORDER BY o.order_date DESC 
                      LIMIT 5";
$recentOrdersResult = mysqli_query($conn, $recentOrdersQuery);
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
</head>

<body class="bg-[var(--bg)]">
    <!-- Sidebar nav -->
    <div class="fixed z-50 top-0 left-0 w-64 h-full bg-[var(--bgSoft)] p-4">
        <div class="flex flex-col gap-5">
            <a href="/index.html" class="text-white text-2xl font-bold text-center py-5">
                Harvest Hub Seller Center
            </a>

            <!-- Nav Items -->
            <div class="flex flex-col gap-2">
                <h1 class="text-sm font-semibold text-white text-sm">Pages</h1>
                <ul class="text-white text-md flex flex-col">
                    <li class="px-3 py-2 rounded-md bg-[#2e374a]">
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
                    <li class="px-3 py-2 rounded-md">
                        <a class="flex items-center gap-2 w-full h-full" href="/project/admin/orders.php">
                            <i class="fa-solid fa-users text-md"></i>
                            <p>Orders</p>
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

            <div class="pt-16">
                <div class="px-4 py-2">
                    <!-- Main dashboard items -->
                    <div>
                        <h1 class="text-2xl font-semibold text-slate-900">Dashboard</h1>
                        <a href="#" class="text-xs text-slate-600">
                            <i class="fa-solid fa-house"></i> / Dashboard
                        </a>
                    </div>
                    <div class="pt-5">
                        <!--Top card -->
                        <div>
                            <div class="flex gap-4">
                                <!-- Products -->
                                <div
                                    class="flex flex-col border-slate-100 rounded-md bg-white shadow-md py-2 px-5 w-full">
                                    <div class="flex justify-between">
                                        <h1 class="text-lg text-slate-700 font-bold">
                                            Products
                                            <span class="font-normal text-xs text-slate-400">/ all products</span>
                                        </h1>
                                        <button>
                                            <i class="fa-solid fa-ellipsis text-md text-slate-800"></i>
                                        </button>
                                    </div>

                                    <div class="flex gap-2 items-center px-2 py-6">
                                        <div class="flex p-3 bg-indigo-100 rounded-full">
                                            <i class="fa-solid fa-boxes-stacked text-indigo-900 text-2xl"></i>
                                        </div>
                                        <div>
                                            <h1 class="font-bold text-3xl text-slate-800"><?php echo $productsCount; ?>
                                            </h1>
                                            <p class="text-sm text-slate-600 font-semibold">
                                                All products
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pending Orders -->
                                <div
                                    class="flex flex-col border-slate-100 rounded-md bg-white shadow-md py-2 px-5 w-full">
                                    <div class="flex justify-between">
                                        <h1 class="text-lg text-slate-700 font-bold">
                                            Pending Orders
                                            <span class="font-normal text-xs text-slate-400">/ this month</span>
                                        </h1>
                                        <button>
                                            <i class="fa-solid fa-ellipsis text-md text-slate-800"></i>
                                        </button>
                                    </div>

                                    <div class="flex gap-2 items-center px-2 py-6">
                                        <div class="py-3 px-4 bg-indigo-100 rounded-full">
                                            <i class="fa-solid fa-hourglass-half text-indigo-900 text-2xl"></i>
                                        </div>
                                        <div>
                                            <h1 class="font-bold text-3xl text-slate-800">
                                                <?php echo $pendingOrdersCount; ?></h1>
                                            <p class="text-sm text-slate-600 font-semibold">
                                                Pending Orders
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Paid Orders -->
                                <div
                                    class="flex flex-col border-slate-100 rounded-md bg-white shadow-md py-2 px-5 w-full">
                                    <div class="flex justify-between">
                                        <h1 class="text-lg text-slate-700 font-bold">
                                            Paid Orders
                                            <span class="font-normal text-xs text-slate-400">/ this month</span>
                                        </h1>
                                        <button>
                                            <i class="fa-solid fa-ellipsis text-md text-slate-800"></i>
                                        </button>
                                    </div>

                                    <div class="flex gap-2 items-center px-2 py-6">
                                        <div class="py-3 px-4 bg-indigo-100 rounded-full">
                                            <i class="fa-solid fa-file-invoice-dollar text-indigo-900 text-2xl"></i>
                                        </div>
                                        <div>
                                            <h1 class="font-bold text-3xl text-slate-800">
                                                <?php echo $paidOrdersCount; ?></h1>
                                            <p class="text-sm text-slate-600 font-semibold">
                                                Paid Orders
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--Tables -->
                            <div class="grid grid-cols-2 gap-4 pt-4 pb-8">
                                <div class="bg-white shadow-md px-4 py-2 rounded-md">
                                    <div class="flex justify-between">
                                        <h1 class="text-lg text-slate-700 font-bold">Recently Added Products</h1>
                                        <button>
                                            <i class="fa-solid fa-ellipsis text-md text-slate-800"></i>
                                        </button>
                                    </div>

                                    <div>
                                        <table class="table-auto w-full mt-4">
                                            <colgroup>
                                                <col style="width: 50%;">
                                                <col style="width: 15%;">
                                                <col style="width: 15%;">
                                                <col style="width: 15%;">
                                            </colgroup>
                                            <thead class="border-b bg-slate-100">
                                                <tr>
                                                    <th rowspan="1" class="py-4 text-gray-800 text-sm font-semibold">
                                                        Product Name
                                                    </th>
                                                    <th rowspan="1" class="py-4 text-gray-800 text-sm font-semibold">
                                                        Price
                                                    </th>
                                                    <th rowspan="1" class="py-4 text-gray-800 text-sm font-semibold">
                                                        Stock
                                                    </th>
                                                    <th rowspan="1" class="py-4 text-gray-800 text-sm font-semibold">
                                                        Date Added
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while($product = mysqli_fetch_assoc($recentProductsResult)) { ?>
                                                <tr class="text-center border-b">
                                                    <td
                                                        class="text-sm font-semibold text-slate-900 h-[3.5rem] text-xs text-gray-800">
                                                        <?php echo $product['product_name']; ?>
                                                    </td>
                                                    <td
                                                        class="text-sm font-semibold text-slate-900 h-[3.5rem] text-xs text-gray-800">
                                                        <?php echo $product['price']; ?>
                                                    </td>
                                                    <td
                                                        class="text-sm font-semibold text-slate-900 h-[3.5rem] text-xs text-gray-800">
                                                        <?php echo $product['quantity']; ?>
                                                    </td>
                                                    <td
                                                        class="text-sm font-semibold text-slate-900 h-[3.5rem] text-xs text-gray-800">
                                                        <?php echo $product['created_at']; ?>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="bg-white shadow-md px-4 py-2 rounded-md">
                                    <div class="flex justify-between">
                                        <h1 class="text-lg text-slate-700 font-bold">Recent Orders</h1>
                                        <button>
                                            <i class="fa-solid fa-ellipsis text-md text-slate-800"></i>
                                        </button>
                                    </div>

                                    <div>
                                        <table class="table-auto w-full mt-4">
                                            <colgroup>
                                                <col style="width: 5%;">
                                                <col style="width: 25%;">
                                                <col style="width: 15%;">
                                                <col style="width: 25%;">
                                                <col style="width: 15%;">
                                            </colgroup>
                                            <thead class="bg-slate-100 border-b border-b-slate-200">
                                                <tr>
                                                    <th class="py-4 text-gray-800 text-sm font-semibold">
                                                        Order ID
                                                    </th>
                                                    <th class="py-4 text-gray-800 text-sm font-semibold">
                                                        Customer Name
                                                    </th>
                                                    <th class="py-4 text-gray-800 text-sm font-semibold">
                                                        Total Amount
                                                    </th>
                                                    <th class="py-4 text-gray-800 text-sm font-semibold">
                                                        Order Date
                                                    </th>
                                                    <th class="py-4 text-gray-800 text-sm font-semibold">
                                                        Status
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while($order = mysqli_fetch_assoc($recentOrdersResult)) { ?>
                                                <tr class="text-center border-b">
                                                    <td
                                                        class="text-sm font-semibold text-slate-900 h-[3.5rem] text-xs text-gray-800">
                                                        <?php echo $order['order_id']; ?>
                                                    </td>
                                                    <td
                                                        class="text-sm font-semibold text-slate-900 h-[3.5rem] text-xs text-gray-800">
                                                        <?php echo $order['customerName']; ?>
                                                    </td>
                                                    <td
                                                        class="text-sm font-semibold text-slate-900 h-[3.5rem] text-xs text-gray-800">
                                                        <?php echo $order['total_amount']; ?>
                                                    </td>
                                                    <td
                                                        class="text-sm font-semibold text-slate-900 h-[3.5rem] text-xs text-gray-800">
                                                        <?php echo $order['order_date']; ?>
                                                    </td>
                                                    <td
                                                        class="text-sm font-semibold text-slate-900 h-[3.5rem] text-xs text-gray-800">
                                                        <?php echo $order['status']; ?>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>