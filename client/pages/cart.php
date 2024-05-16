<?php
session_start();
include_once "./../../config/dbCon.php";

if(!isset($_SESSION['customerUsername'])){
    header("Location: /project/client/pages/login.php");
    exit(0);
}

$customer_username = $_SESSION['customerUsername'];
$customer_query = "SELECT customerID FROM customers WHERE customerUsername = '$customer_username'";
$customer_result = mysqli_query($conn, $customer_query);

if($customer_result && mysqli_num_rows($customer_result) > 0) {
    $customer_row = mysqli_fetch_assoc($customer_result);
    $customer_id = $customer_row['customerID'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_selected'])) {
        $selected_items = $_POST['cart_item'];
        if (!empty($selected_items)) {
            foreach ($selected_items as $item_id) {
                $delete_query = "DELETE FROM carts WHERE product_id = $item_id AND customer_id = $customer_id";
                mysqli_query($conn, $delete_query);
            }
        }
    }

    $cart_query = "SELECT carts.product_id, carts.quantity, products.product_name, products.price, products.image_url, sellers.store_name
                   FROM carts
                   INNER JOIN products ON carts.product_id = products.product_id
                   INNER JOIN sellers ON products.seller_id = sellers.sellerID
                   WHERE carts.customer_id = $customer_id";
    $cart_result = mysqli_query($conn, $cart_query);

    // Group items by seller
    $cart_items = [];
    while($row = mysqli_fetch_assoc($cart_result)) {
        $store_name = $row['store_name'];
        if(!isset($cart_items[$store_name])) {
            $cart_items[$store_name] = [];
        }
        $cart_items[$store_name][] = $row;
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
    <link rel="stylesheet" href="./../style/index.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,300,0,0" />
    <link rel="shortcut icon" href="../assets/favicon.webp" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Shopping Cart</title>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const selectAllCheckbox = document.getElementById("select_all");
        const itemCheckboxes = document.querySelectorAll('input[name="cart_item[]"]');

        selectAllCheckbox.addEventListener("change", function() {
            itemCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });

        itemCheckboxes.forEach(checkbox => {
            checkbox.addEventListener("change", function() {
                if (!this.checked) {
                    selectAllCheckbox.checked = false;
                } else if (Array.from(itemCheckboxes).every(item => item.checked)) {
                    selectAllCheckbox.checked = true;
                }
            });
        });
    });

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
</head>

<body>
    <header>
        <div class="header-container">
            <div class="upper">
                <div>
                    <ul class="upper-part-nav">
                        <li><a href="/project/client/pages/seller-login.php"><span
                                    class="material-symbols-outlined">storefront</span>Seller Center</a></li>
                        <li><a href="#"><span class="material-symbols-outlined">
                                    help
                                </span>About us</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="middle">
                <a href="/project/client/" class="logo">
                    <h1>Harverst</h1>
                    <span>hub</span>
                </a>
                <form action="/project/client/" method="POST" class="search">
                    <input placeholder="Search..." type="search" name="search" id="search">
                    <button type="submit"><span class="material-symbols-outlined">search</span></button>
                </form>

                <?php
            if(isset($_SESSION['customerUsername'])){
            ?>
                <div style="display: flex; gap: 10px; justify-content: center; align-items: center;">
                    <a href="/project/client/pages/cart.php">
                        <span style="font-size: 35px; font-weight: 500; cursor: pointer;"
                            class="material-symbols-outlined">
                            shopping_cart
                        </span>
                    </a>
                    <div class="profile-container">
                        <span style="font-size: 35px; font-weight: 500; cursor: pointer;"
                            class="material-symbols-outlined profile-icon">
                            account_circle
                        </span>
                        <div class="dropdown-menu">
                            <ul>
                                <li><a style="display: flex; gap: 5px;" href="/project/client/pages/profile.php"><span
                                            class="material-symbols-outlined">
                                            person
                                        </span>Profile</a></li>
                                <li><a style="display: flex; gap: 5px;" href="/project/client/pages/orders.php"><span
                                            class="material-symbols-outlined">
                                            shopping_bag
                                        </span>Orders</a></li>
                                <li><a style="display: flex; gap: 5px; color: red; font-weight: 600;"
                                        href="/project/logout.php"><span class="material-symbols-outlined">
                                            logout
                                        </span>Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php
                }else{
                ?>
                <div class="login-status">
                    <a class="signup-button" href="/project/client/pages/signup.php">Sign Up</a>
                    <a class="login-button" href="/project/client/pages/login.php">Login</a>
                </div>
                <?php } ?>
            </div>
        </div>
    </header>

    <main class="w-full px-3 xl:px-[15rem]">
        <form class="mt-[-3rem] w-full" method="post" action="">
            <div class="flex w-full overflow-x-auto justify-between bg-white px-5 py-2 mt-3 text-[#757575]">
                <div style="display: flex; gap: 5px;">
                    <input type="checkbox" id="select_all">
                    <h1
                        style="font-size: 15px; font-weight: 400; display: flex; align-items: center; text-align: center;">
                        Select All
                    </h1>
                </div>
                <div>
                    <button type="submit" name="delete_selected"
                        style="font-size: 15px; font-weight: 400; display: flex; align-items: center; text-align: center; background: none; border: none; cursor: pointer;">
                        <span class="material-symbols-outlined">delete</span>Delete
                    </button>
                </div>
            </div>

            <?php if(!empty($cart_items)): ?>
            <?php foreach($cart_items as $store_name => $items): ?>
            <div class="bg-white px-5 py-2 mt-3 text-[#757575] overflow-x-auto">
                <h1 class="flex items-center gap-1 border-b border-b-slate-300 pb-1">
                    <span class="material-symbols-outlined">storefront</span><?php echo $store_name; ?>
                </h1>
                <?php foreach($items as $item): ?>
                <div class="flex mt-3">
                    <input type="checkbox" name="cart_item[]" value="<?php echo $item['product_id']; ?>">
                    <div class="pl-10 w-[100px] h-[100px] overflow-hidden"> <img class="w-full h-full object-cover"
                            src="<?php echo "../../admin/function/" . $item['image_url']; ?>" alt="">
                    </div>
                    <h4 class="pl-10 text-slate-700 text-lg w-[18rem] max-w-[18rem]">
                        <?php echo $item['product_name']; ?>
                    </h4>
                    <h4 class="pl-20 text-slate-800 text-xl font-semibold">
                        ₱<?php echo number_format($item['price'], 2); ?></h4>
                    <h4 class="pl-20 text-slate-800 text-xl">Quantity:
                        <?php echo $item['quantity']; ?></h4>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p class="flex justify-center items-center h-[25rem] bg-white px-5 py-2 mt-3 text-[#757575]">Your cart is
                empty.</p>
            <?php endif; ?>
        </form>
    </main>
</body>

</html>