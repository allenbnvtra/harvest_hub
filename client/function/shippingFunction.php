<?php 
    include './../../config/dbCon.php';

    session_start();
 
    if(isset($_SESSION['customerUsername'])){
        $customerUsername = $_SESSION['customerUsername'];
        $sql = "SELECT customerID FROM customers WHERE customerUsername = '$customerUsername'";
        $result = mysqli_query($conn, $sql);

        if($result) {
            $row = mysqli_fetch_assoc($result);
            $customerID = $row['customerID'];

            if(isset($_POST['addShipping'])){
                $error = 'Error while adding shipping info';
                $name = mysqli_real_escape_string($conn, $_POST['name']);
                $phone = mysqli_real_escape_string($conn, $_POST['phone']);
                $address = mysqli_real_escape_string($conn, $_POST['address']);

                if($name == '' || $phone == '' || $address == ''){
                    $error = "All fields are required.";
                } else{
                    $query = "INSERT INTO shipping_info (ship_name, customer_id, ship_contact, ship_address) VALUES ('$name', '$customerID','$phone','$address')";
                    $result = mysqli_query($conn, $query);

                    if($result){
                        header("Location: /project/client/pages/buyNow.php");
                        exit(0);
                    } else {
                        $error = "An error occurred. Please try again later.";
                    }
                }
            }
        } else {
            // Error in retrieving customer ID
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        header("Location: /project/client/pages/login.php");
        exit;
    }
?>