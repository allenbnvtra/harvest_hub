<?php
session_start();

if (!isset($_SESSION['sellerUsername'])) {
    header("Location: /project/client/pages/seller-login.php");
    exit();
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
                    <li class="px-3 py-2 rounded-md bg-[#2e374a]">
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
                    <h1 class="text-xl font-bold">Welcome, Adminprog</h1>
                </div>
            </header>
        </div>

        <div class="flex justify-center pt-16 px-4">
            <div class="add_product_container">
                <form action="./function/insert_product.php" method="post" enctype="multipart/form-data">
                    <h1 style="font-size: 20px; font-weight: 700; margin-bottom: 10px;">
                        Add Product
                    </h1>
                    <div style="display: flex; gap: 20px;">
                        <div class="form_items">
                            <label for="product_name">Product Name</label>
                            <input id="product_name" name="product_name" type="text">
                        </div>

                        <div class="form_items">
                            <label for="image_url">Image</label>
                            <input type="file" name="image" id="image">
                        </div>
                    </div>

                    <div style="display: flex; gap: 20px;">
                        <div class="form_items">
                            <label for="price">Price</label>
                            <input id="price" name="price" type="text">
                        </div>

                        <div class="form_items">
                            <label for="previous_price">Previous Price</label>
                            <input id="previous_price" name="previous_price" type="text">
                        </div>
                    </div>

                    <div style="display: flex; gap: 20px;">
                        <div class="form_items">
                            <label for="category">Category</label>
                            <select id="category" name="category">
                                <option value="others">Others</option>
                                <option value="fruits">Fruits</option>
                                <option value="vegetables">Vegetables</option>
                                <option value="seedlings">Seedlings</option>
                                <option value="meats">Meats</option>
                                <option value="poultry">Poultry</option>
                                <option value="fish">Fish</option>
                            </select>
                        </div>

                        <div class="form_items">
                            <label for="location">Location</label>
                            <input id="location" name="location" type="text">
                        </div>
                    </div>

                    <div style="display: flex; gap: 20px;">
                        <div class="form_items">
                            <label for="quantity">Quantity</label>
                            <input id="quantity" name="quantity" type="text">
                        </div>



                        <div class="form_items">
                            <label for="description">Description</label>
                            <textarea id="description" name="description"
                                placeholder="Your product description..."></textarea>
                        </div>
                    </div>
                    <button name="add_product">Submit</button>
                </form>

            </div>
        </div>

        <footer class="flex justify-center py-5">
            <p class="text-slate-500">©All Rights Reserved - A's Technology</p>
        </footer>
    </main>


</body>

</html>