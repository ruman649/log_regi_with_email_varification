<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db_name = "uservalidation";

    $connect = mysqli_connect($host, $user, $pass, $db_name);

    if(!$connect){
        die(mysqli_connect_error());
    }

?>