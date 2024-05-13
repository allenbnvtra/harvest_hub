<?php
 require "./../../config/dbCon.php";

 if(isset($_POST['register_user'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $contactNumber = mysqli_real_escape_string($conn, $_POST['contactNumber']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if($name !== '' || $username !== '' || $contactNumber !== '' || $address !== '' || $password !== ''){

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO customers (customerName, customerUsername, customerContact, customerAddress, customerPassword) VALUES ('$name','$username', '$contactNumber', '$address', '$hashed_password')";
        $result = mysqli_query($conn, $query);
        if($result){
            header("Location: /project/client/pages/login.php");
            exit(0);
        }else {
            echo "Error: " . mysqli_error($conn);
        }
    }
 }elseif(isset($_POST['login_user'])){
    session_start();
    if(empty($_POST['username']) || empty($_POST['password'])){
        $_SESSION['error'] = "Please enter both username and password.";
        header("Location: /project/client/pages/login.php");
        exit(0);
    }

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM customers WHERE customerUsername = '$username'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);
        $stored_password = $row['customerPassword'];

        if(password_verify($password, $stored_password)){
            $_SESSION['customerUsername'] = $username;
            if(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            }
        } else {
            $_SESSION['error'] = "Incorrect username or password.";
            header("Location: /project/client/pages/login.php");
        }
    } else {
        $_SESSION['error'] = "Incorrect username or password.";
        header("Location: /project/client/pages/login.php");
    }
    exit(0);
}
?>