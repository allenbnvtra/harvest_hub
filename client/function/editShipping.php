<?php
include_once './../../config/dbCon.php';

session_start();

if(isset($_SESSION['customerUsername'])){
    if(isset($_POST['editShipping'])) {
        $ship_id = mysqli_real_escape_string($conn, $_POST['shipping_id']);
        $name = mysqli_real_escape_string($conn, $_POST['edit_name']);
        $phone = mysqli_real_escape_string($conn, $_POST['edit_phone']);
        $address = mysqli_real_escape_string($conn, $_POST['edit_address']);

        $update_query = "UPDATE shipping_info SET ship_name='$name', ship_contact='$phone', ship_address='$address' WHERE ship_id='$ship_id'";
        $update_result = mysqli_query($conn, $update_query);

        if($update_result) {
            if(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
                header("Location: " . $_SERVER['HTTP_REFERER']);
                    exit();
            }
        } else {
            echo "Error updating shipping information: " . mysqli_error($conn);
        }
    } else {
        echo "Incomplete form data received.";
    }
} else {
    header("Location: /project/client/pages/login.php");
    exit;
}
?>