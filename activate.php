<?php

session_start();
include 'connection.php';

if(isset($_GET['token'])){
    $token = $_GET['token'];

    $select_token = "select * from usertable where token='$token'";
    $selected = mysqli_query($connect, $select_token);

    // $user_array_data = mysqli_fetch_assoc($selected);
    $update_active = " update usertable set active='active' where token='$token' ";
    $updated = mysqli_query($connect, $update_active);

    if($updated){
        if(isset($_SESSION['msg'])){
            $_SESSION['msg'] = "Account activated! Now You can loged in";
            header('location: login.php?activate=active');
        }
        else{
            $_SESSION['msg'] = 'You are loged out';
        }
    }
    else{
        $_SESSION['msg'] = 'Account not activated';
        header('location: index.php');
    }
}


?>