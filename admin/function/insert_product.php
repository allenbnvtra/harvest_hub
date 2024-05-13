<?php
session_start();

if (isset($_POST['add_product'])) {
    if (isset($_SESSION['sellerUsername'])) {
        include_once "./../../config/dbCon.php";
        
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
        
        $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);
        $previous_price = mysqli_real_escape_string($conn, $_POST['previous_price']);
        $category = mysqli_real_escape_string($conn, $_POST['category']);
        $location = mysqli_real_escape_string($conn, $_POST['location']);
        $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);

        $targetDir = "uploads/";
        $fileName = uniqid() . '_' . basename($_FILES["image"]["name"]); 
        $targetFile = $targetDir . $fileName;

        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true); 
        }
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $image_url = $targetFile;
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit();
        }

        $sql = "INSERT INTO Products (product_name, description, price, previous_price, category, location, image_url, seller_id, quantity) VALUES ('$product_name', '$description', '$price', '$previous_price', '$category', '$location', '$image_url', '$seller_id', '$quantity')";

        if (mysqli_query($conn, $sql)) {
            echo "Product added successfully!";
            header("Location: /project/admin/products.php");
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        mysqli_close($conn);
    } else {
        header("Location: /project/client/pages/seller-login.php");
        exit();
    }
}
?>