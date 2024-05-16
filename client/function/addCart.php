<?php
session_start();
include_once "./../../config/dbCon.php";

if(isset($_POST['add_to_cart'])){
    $customer_username = $_SESSION['customerUsername'];

    $customer_query = "SELECT customerID FROM customers WHERE customerUsername = '$customer_username'";
    $customer_result = mysqli_query($conn, $customer_query);
    
    if($customer_result && mysqli_num_rows($customer_result) > 0) {
        $customer_row = mysqli_fetch_assoc($customer_result);
        $customer_id = $customer_row['customerID'];

        $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
        $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);

        if($product_id == '' || $quantity == '' || $customer_id == ''){
            echo "Please fill all fields";
        } else {
            $existing_cart_query = "SELECT * FROM carts WHERE customer_id = $customer_id AND product_id = $product_id";
            $existing_cart_result = mysqli_query($conn, $existing_cart_query);
            
            if(mysqli_num_rows($existing_cart_result) > 0) {
                echo '<script>alert("This product is already in your cart."); window.location.href = "/project/client/";</script>';
            } else {
                $query = "INSERT INTO carts (customer_id, product_id, quantity) VALUES ($customer_id, $product_id, $quantity)";
                $result = mysqli_query($conn, $query);

                if(!$result){
                    echo "Failed to add in cart";
                } else {
                    echo '<script>alert("Product added to cart successfully!"); window.location.href = "/project/client/";</script>';
                }
            }
        }
    } else {
        header("Location: /project/client/pages/login.php");
        exit(0);
    }
}
?>