<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>registration</title>

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

    <?php

    include 'connection.php';

    if (isset($_POST['submit'])) {

        $name = mysqli_real_escape_string($connect, $_POST['name']);
        $email = mysqli_real_escape_string($connect, $_POST['email']);
        $phone = mysqli_real_escape_string($connect, $_POST['phone']);
        $pass = mysqli_real_escape_string($connect, $_POST['pass']);
        $cpass = mysqli_real_escape_string($connect, $_POST['cpass']);

        $select_mail = " select * from usertable where email='$email' ";

        $selected_mail = mysqli_query($connect, $select_mail);
        $mail_count = mysqli_num_rows($selected_mail);

        $_SESSION['email'] = $email;
        $_SESSION['pass'] = $pass;

        if ($mail_count > 0) {
            echo "mail is already exist!";
        } else {
            if ($pass === $cpass) {
                $incripted_pass = password_hash($pass, PASSWORD_BCRYPT);
                $token = bin2hex(random_bytes(15));


                $insert = " insert into usertable(name, email, phone, pass, token, active) values ('$name', '$email', '$phone', '$incripted_pass', '$token', 'inactive') ";


                $inserted_into_db = mysqli_query($connect, $insert);

                if ($inserted_into_db) {
                    // echo 'Yes data inserted';
                    // header('location: login.php');
                    $to = $email;
                    $sub = "Varification via email";
                    $body = "Hello {$name}! click for activate  http://localhost:3000/activate.php?token=$token ";
                    $from = "From: mruman649@gmail.com";
                    if (mail($to, $sub, $body, $from)) {
                        $_SESSION['msg'] = "check Your Email to activate account  $email";
                        header('location: login.php');
                    } else {
                        echo "mail not send";
                    }
                } else {
                    echo "data not insrted";
                }
            } else {
                echo "pass is not match";
            }
        }
    }



    ?>



    <div class="container mt-3">

        <div class="card bg-light">
            <article class="card-body mx-auto" style="max-width: 400px;">
                <h4 class="card-title mt-3 text-center">Create Account</h4>
                <p class="text-center ">Create Account</p>
                <p>
                    <a href="" class="btn btn-block bg-danger "> Google</a>
                    <a href="" class="btn btn-block btn-facebook"> <i class="fab fa-facebook-f"></i> Login via facebook</a>
                </p>
                <p class="divider-text">
                    <span class="bg-light">OR</span>
                </p>
                <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                        </div>
                        <input required name="name" class="form-control" placeholder="Full name" type="text">
                    </div> <!-- form-group// -->
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                        </div>
                        <input required name="email" class="form-control" placeholder="Email address" type="email">
                    </div> <!-- form-group// -->
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
                        </div>
                        <input required name="phone" class="form-control" placeholder="Phone number" type="text">
                    </div>
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <input required name="pass" class="form-control" placeholder="Create password" type="password">
                    </div> <!-- form-group// -->
                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <input required name="cpass" class="form-control" placeholder="c peat password" type="password">
                    </div> <!-- form-group// -->
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-primary btn-block"> Create Account </button>
                    </div> <!-- form-group// -->
                    <p class="text-center">Have an account? <a href="login.php">Log In</a> </p>
                </form>
            </article>
        </div> <!-- card.// -->

    </div>
    <!--container end.//-->





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

</body>

</html>