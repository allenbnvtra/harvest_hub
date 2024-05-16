<?php
session_start();

if (!isset($_SESSION['sellerUsername'])) {
    header("Location: /project/client/pages/seller-login.php");
    exit();
}

include_once "./../../config/dbCon.php";

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

if(isset($_GET['product_id']) && isset($_GET['action']) && $_GET['action'] === 'delete'){
    $product_id = mysqli_real_escape_string($conn, $_GET['product_id']);
    $query = "DELETE FROM products WHERE product_id = '$product_id'";

    $deleteResult = mysqli_query($conn, $query);

    if($deleteResult){
        header('Location: /project/admin/products.php');
    }
}
?>