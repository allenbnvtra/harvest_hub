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

    $query = "SELECT * FROM Products WHERE seller_id = '$seller_id'";
    $products_result = mysqli_query($conn, $query);
} else {
    echo "Error: Seller not found";
    exit();
}

if(isset($_POST['edit_product'])) {
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $stocks = $_POST['product_stocks'];
    $price = $_POST['product_price'];

    $query = "UPDATE Products SET product_name = '$productName', quantity = '$stocks', price = '$price' WHERE product_id = '$productId'";
    $result = mysqli_query($conn, $query);
    
    if($result) {
        header("Location: /project/admin/products.php");
        exit();
    } else {
        echo "Error updating product: " . mysqli_error($conn);
    }
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

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        width: 20rem;
        padding: 20px;
        border: 1px solid #888;
        border-radius: 5px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    /* Add animation */
    @keyframes modal {
        from {
            opacity: 0
        }

        to {
            opacity: 1
        }
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
                    <h1 class="text-xl font-bold">Welcome, <?php echo $sellerUsername?></h1>
                </div>
            </header>
        </div>

        <div class="pt-16 px-4">
            <div class="product_container">
                <div style="display: flex; justify-content: end; padding: 1rem 0;">
                    <a href="/project/admin/add-product.php" class="green_button">Add
                        Product</a>
                </div>
                <div class="flex justify-center">
                    <table>
                        <thead>
                            <th class="px-20 py-4">ID</th>
                            <th class="px-20 py-4">Product Name</th>
                            <th class="px-20 py-4">Stocks</th>
                            <th class="px-20 py-4">Price</th>
                            <th class="px-20 py-4">Action</th>
                        <tbody>
                            <?php
                        while ($row = mysqli_fetch_assoc($products_result)) {
                            echo "<tr class='text-center'>";
                            echo "<td class='py-2'>" . $row['product_id'] . "</td>";
                            echo "<td class='py-2'>" . $row['product_name'] . "</td>";
                            echo "<td class='py-2'>" . $row['quantity'] . "</td>";
                            echo "<td class='py-2'>" . $row['price'] . "</td>";
                            echo "<td class='flex gap-1 px-10 py-2'>";
                            echo "<button class='blue_button edit_button' data-id='" . $row['product_id'] . "'>Edit</button>"; // Add edit_button class
                            echo "<a href='/project/admin/function/editData.php?action=delete&product_id=". $row['product_id'] ."' class='text-white red_button delete_button cursor-pointer' >Delete</a>"; // Add delete_button class
                            echo "</td>";
                            echo "</tr>";
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
    <!-- Modals -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Product</h2>
            <form method="post" action="./function/editData.php">
                <input type="hidden" id="product_id" name="product_id">
                <div>
                    <label for="product_name">Product Name</label>
                    <input class="w-full border rounded-md p-2" type="text" id="product_name" name="product_name">
                </div>
                <div>
                    <label for="product_stocks">Stocks</label>
                    <input class="w-full border rounded-md p-2" type="text" id="product_stocks" name="product_stocks">
                </div>
                <div>
                    <label for="product_price">Price</label>
                    <input class="w-full border rounded-md p-2" type="text" id="product_price" name="product_price">
                </div>
                <button class="w-full bg-indigo-500 text-white mt-5 py-3 rounded-md" name="edit_product">Submit</button>
            </form>
        </div>
    </div>

    <!-- <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Delete Product</h2>
            <p>Are you sure you want to delete this product?</p>
            <form id="deleteForm" method="post">
                <div class="flex justify-center">
                    <input type="hidden" id="product_id" name="product_id">
                    <button type="button" id="confirmDelete"
                        class="red_button text-white px-8 py-2 rounded-md">Delete</button>
                </div>
            </form>
        </div>
    </div> -->

    <script>
    var editModal = document.getElementById('editModal');
    var deleteModal = document.getElementById('deleteModal');

    var editButtons = document.querySelectorAll('.edit_button');
    var deleteButtons = document.querySelectorAll('.delete_button');

    var closeButtons = document.querySelectorAll('.close');

    editButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var productId = this.getAttribute('data-id');
            document.getElementById('product_id').value = productId;
            editModal.style.display = 'block';
        });
    });

    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var productId = this.getAttribute('data-id');
            document.getElementById('product_id').value = productId;

            deleteModal.style.display = 'block';
        });
    });

    closeButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            editModal.style.display = 'none';
            deleteModal.style.display = 'none';
        });
    });
    </script>
    </thead>
</body>

</html>