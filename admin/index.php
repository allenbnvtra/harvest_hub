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
                        <a class="flex items-center gap-2 w-full h-full" href="/project/client">
                            <i class="fa-solid fa-shop text-md"></i>
                            <p>Marketplace</p>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="flex flex-col gap-2">
                <h1 class="text-sm font-semibold text-white text-sm">Orders</h1>
                <ul class="text-white text-md flex flex-col">
                    <li class="px-3 py-2 rounded-md">
                        <a class="flex items-center gap-2 w-full h-full" href="#">
                            <i class="fa-solid fa-money-bills text-md"></i>
                            <p>Pending Orders</p>
                        </a>
                    </li>
                    <li class="px-3 py-2 rounded-md">
                        <a class="flex items-center gap-2 w-full h-full" href="#">
                            <i class="fa-solid fa-file-invoice text-md"></i>
                            <p>Success Orders</p>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="flex flex-col gap-2">
                <h1 class="text-sm font-semibold text-white text-sm">Settings</h1>
                <ul class="text-white text-md flex flex-col">
                    <li class="px-3 py-2 rounded-md">
                        <a class="flex items-center gap-2 w-full h-full" href="#">
                            <i class="fa-solid fa-clock-rotate-left text-md"></i>
                            <p>Activity Logs</p>
                        </a>
                    </li>

                    <li class="px-3 py-2 rounded-md">
                        <a class="flex items-center gap-2 w-full h-full" href="#">
                            <i class="fa-solid fa-box-archive text-md"></i>
                            <p>Archived</p>
                        </a>
                    </li>

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
                                            <span class="font-normal text-xs text-slate-400">/ this day</span>
                                        </h1>
                                        <button>
                                            <i class="fa-solid fa-ellipsis text-md text-slate-800"></i>
                                        </button>
                                    </div>

                                    <div class="flex gap-2 items-center px-2 py-6">
                                        <div class="flex p-3 bg-indigo-100 rounded-full">
                                            <i class="fa-solid fa-users text-indigo-900 text-2xl"></i>
                                        </div>
                                        <div>
                                            <h1 class="font-bold text-3xl text-slate-800">143</h1>
                                            <p class="text-sm text-slate-600 font-semibold">
                                                All products
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Paid Bills -->
                                <div
                                    class="flex flex-col border-slate-100 rounded-md bg-white shadow-md py-2 px-5 w-full">
                                    <div class="flex justify-between">
                                        <h1 class="text-lg text-slate-700 font-bold">
                                            Paid Bills
                                            <span class="font-normal text-xs text-slate-400">/ this month</span>
                                        </h1>
                                        <button>
                                            <i class="fa-solid fa-ellipsis text-md text-slate-800"></i>
                                        </button>
                                    </div>

                                    <div class="flex gap-2 items-center px-2 py-6">
                                        <div class="py-3 px-4 bg-indigo-100 rounded-full">
                                            <i class="fa-solid fa-money-bill-trend-up text-indigo-900 text-2xl"></i>
                                        </div>
                                        <div>
                                            <h1 class="font-bold text-3xl text-slate-800">
                                                ₱ 1,435,345
                                            </h1>
                                            <p class="text-sm text-slate-600 font-semibold">
                                                <span class="font-bold text-green-600">12%</span>
                                                increase
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Unpaid Bills -->
                                <div
                                    class="flex flex-col border-slate-100 rounded-md bg-white shadow-md py-4 px-5 w-full">
                                    <div class="flex justify-between">
                                        <h1 class="text-lg text-slate-700 font-bold">
                                            Unpaid Bills
                                            <span class="font-normal text-xs text-slate-400">/ this month</span>
                                        </h1>
                                        <button>
                                            <i class="fa-solid fa-ellipsis text-md text-slate-800"></i>
                                        </button>
                                    </div>

                                    <div class="flex gap-2 items-center px-2 py-6">
                                        <div class="py-3 px-4 bg-indigo-100 rounded-full">
                                            <i class="fa-solid fa-money-bill-trend-up text-indigo-900 text-2xl"></i>
                                        </div>
                                        <div>
                                            <h1 class="font-bold text-3xl text-slate-800">
                                                ₱ 427,392.55
                                            </h1>
                                            <p class="text-sm text-slate-600 font-semibold">
                                                <span class="font-bold text-red-600">6%</span>
                                                decrease
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Buttom cards -->
                        <div class="flex gap-4 mt-6">
                            <!-- Recent Payment Table -->
                            <div
                                class="flex flex-col gap-2 border-slate-100 rounded-md bg-white shadow-md py-4 px-5 w-full">
                                <div class="flex justify-between">
                                    <h1 class="text-lg text-slate-700 font-bold">
                                        Recent Payment/s
                                    </h1>
                                    <button>
                                        <i class="fa-solid fa-ellipsis text-md text-slate-800"></i>
                                    </button>
                                </div>

                                <table class="mb-4">
                                    <thead class="border-b bg-slate-100">
                                        <th class="py-4 text-gray-800 text-sm font-semibold">
                                            Reciept No.
                                        </th>
                                        <th class="py-4 text-gray-800 text-sm font-semibold">
                                            Payment Date
                                        </th>
                                        <th class="py-4 text-gray-800 text-sm font-semibold">
                                            Billing Date
                                        </th>
                                        <th class="py-4 text-gray-800 text-sm font-semibold">
                                            Payment Amount
                                        </th>
                                        <th class="py-4 text-gray-800 text-sm font-semibold">
                                            Tenant Name
                                        </th>
                                    </thead>

                                    <tbody>
                                        <tr class="border-b">
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                5940261
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                Jan. 25, 2023
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                Jan. 25, 2023
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                P 1,543
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                Allen Buenaventura
                                            </td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                5940261
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                Jan. 25, 2023
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                Jan. 25, 2023
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                P 1,543
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                Allen Buenaventura
                                            </td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                5940261
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                Jan. 25, 2023
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                Jan. 25, 2023
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                P 1,543
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                Allen Buenaventura
                                            </td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                5940261
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                Jan. 25, 2023
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                Jan. 25, 2023
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                P 1,543
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                Allen Buenaventura
                                            </td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                5940261
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                Jan. 25, 2023
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                Jan. 25, 2023
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                P 1,543
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                Allen Buenaventura
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div
                                class="flex flex-col gap-2 border-slate-100 rounded-md bg-white shadow-md py-4 px-5 w-full">
                                <div class="flex justify-between">
                                    <h1 class="text-lg text-slate-700 font-bold">
                                        Recent Bill Added
                                    </h1>
                                    <button>
                                        <i class="fa-solid fa-ellipsis text-md text-slate-800"></i>
                                    </button>
                                </div>

                                <!-- RECENT BILL TABLE -->
                                <table class="mb-4">
                                    <thead class="border-b bg-slate-100">
                                        <th class="py-4 text-gray-800 text-sm font-semibold">
                                            Reciept No.
                                        </th>
                                        <th class="py-4 text-gray-800 text-sm font-semibold">
                                            Payment Date
                                        </th>
                                        <th class="py-4 text-gray-800 text-sm font-semibold">
                                            Billing Date
                                        </th>
                                        <th class="py-4 text-gray-800 text-sm font-semibold">
                                            Payment Amount
                                        </th>
                                        <th class="py-4 text-gray-800 text-sm font-semibold">
                                            Tenant Name
                                        </th>
                                    </thead>

                                    <tbody>
                                        <tr class="border-b">
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                5940261
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                Jan. 25, 2023
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                Jan. 25, 2023
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                P 1,543
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                Allen Buenaventura
                                            </td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                5940261
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                Jan. 25, 2023
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                Jan. 25, 2023
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                P 1,543
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                Allen Buenaventura
                                            </td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                5940261
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                Jan. 25, 2023
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                Jan. 25, 2023
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                P 1,543
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                Allen Buenaventura
                                            </td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                5940261
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                Jan. 25, 2023
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                Jan. 25, 2023
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                P 1,543
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                Allen Buenaventura
                                            </td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                5940261
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                Jan. 25, 2023
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                Jan. 25, 2023
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                P 1,543
                                            </td>
                                            <td class="py-3 text-center text-xs text-gray-800">
                                                Allen Buenaventura
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="flex justify-center py-5">
            <p class="text-slate-500">©All Rights Reserved - A's Technology</p>
        </footer>
    </main>
</body>

</html>