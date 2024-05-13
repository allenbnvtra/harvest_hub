<?php
 require "./../../config/dbCon.php";

 
 if(isset($_POST['register_user'])){
    $error = 'Error while register';
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $contactNumber = mysqli_real_escape_string($conn, $_POST['contactNumber']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if($name == '' || $username == '' || $contactNumber == '' || $address == '' || $password == ''){
        $error = "All fields are required.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO sellers (sellerName, sellerUsername, sellerContact, sellerAddress, sellerPassword) VALUES ('$name','$username', '$contactNumber', '$address', '$hashed_password')";
        $result = mysqli_query($conn, $query);
        
        if($result){
            header("Location: /project/client/pages/seller-login.php");
            exit(0);
        } else {
            $error = "An error occurred. Please try again later.";
        }
    }
}elseif(isset($_POST['login_user'])){
    session_start();
    if(empty($_POST['username']) || empty($_POST['password'])){
        $_SESSION['error'] = "Please enter both username and password.";
        header("Location: /project/client/pages/seller-login.php");
        exit(0);
    }

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM sellers WHERE sellerUsername = '$username'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);
        $stored_password = $row['sellerPassword'];

        if(password_verify($password, $stored_password)){
            $_SESSION['sellerUsername'] = $username;
            header("Location: /project/admin/");
            exit(0);
        } else {
            $_SESSION['error'] = "Incorrect username or password.";
            header("Location: /project/client/pages/seller-login.php");
        }
    } else {
        $_SESSION['error'] = "Incorrect username or password.";
        header("Location: /project/client/pages/seller-login.php");
    }
    exit(0);
}
?>