<?php
session_start();


include "connection.php";

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $pass = mysqli_real_escape_string($connect, $_POST['pass']);
    $check_btn = $_POST['check'];

    $select = " select * from usertable where email='$email' and active='active' ";
    $select_email = mysqli_query($connect, $select);
    $count_mail = mysqli_num_rows($select_email);

    if ($count_mail) {
        $user_data_array = mysqli_fetch_assoc($select_email);

        $pass_validation = password_verify($pass, $user_data_array['pass']);
        if ($pass_validation) {
            if($check_btn){
                setcookie('user_email', $email, time()+86400);
                setcookie('user_pass', $pass, time()+86400);
                setcookie('check_btn', $check_btn, time()+86400);
            }else{
                setcookie('user_email', $email, time()-86400);
                setcookie('user_pass', $pass, time()-86400);
                setcookie('check_btn', $check_btn, time()-86400);
            }
            header('location: home.php');
        } else {
            echo "password is not match";
        }
    } else {
    }
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->


    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/89726b4d6a.js" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">


    <link rel="stylesheet" href="./style.css">

</head>

<body>

    <div class="container mt-3">
        <div class="card bg-light">
            <article class="card-body mx-auto" style="max-width: 400px;">
                <h4 class="card-title mt-3 text-center">Create Account</h4>
                <p class="text-center ">Create Account</p>
                <p>
                    <a href="" class="btn btn-block bg-danger text-white"><i class="fab fa-google "></i> Google</a>
                    <a href="" class="btn btn-block btn-facebook"> <i class="fab fa-facebook-f"></i> Login via facebook</a>
                </p>
                <p class="divider-text">
                    <span class="bg-light">OR</span>
                </p>

                <div class="">
                    <?php
                    if (isset($_SESSION['msg'])) {
                    ?>
                        <p style="background:green; color:white; padding:10px;">
                            <?php echo $_SESSION['msg']; ?>
                        </p>
                    <?php
                    }
                    ?>

                </div>

                <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                        </div>
                        <input required name="email" value="<?php if (isset($_GET['activate'])) {
                             echo $_SESSION['email'];
                              } else if(isset($_COOKIE['user_email'])){
                                echo $_COOKIE['user_email'];
                               } ?>" class="form-control" placeholder="Email address" type="email">
                    </div> <!-- form-group// -->
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <input required name="pass" value="<?php if (isset($_GET['activate'])) {
                                                                echo $_SESSION['pass'];
                                                            }else if (isset($_COOKIE['user_pass'])){
                                                                echo $_COOKIE['user_pass'];
                                                            } ?>" class="form-control" placeholder="Create password" type="password">
                    </div> <!-- form-group// -->
                    <label class="container">
                        <input type="checkbox" name="check" <?php if(isset($_COOKIE['check_btn'])){ echo 'checked';} ?> >
                        <span class="checkmark">Remember Me</span>
                    </label>
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-primary btn-block"> Log In </button>
                    </div> <!-- form-group// -->
                    <p class="text-center"> New user? <a href="index.php">Registration First</a> </p>
                </form>
            </article>
        </div> <!-- card.// -->

    </div>
    <!--container end.//-->





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

</body>

</html>