<?php

    session_start();

    include("nav.php");

    if(isset($_SESSION["email"])) {

        $email = $_SESSION["email"];

        $query_account_type = mysqli_query($connections, "SELECT * FROM tbl_user WHERE email='$email'");

        $get_account_type = mysqli_fetch_assoc($query_account_type);

        $account_type = $get_account_type["account_type"];

        if($account_type == 1) {

            echo "<script>window.location.href='./Admin/view_record.php';</script>";

        }else{

            echo "<script>window.location.href='./User/app.php';</script>";

        }

    }
    date_default_timezone_set ("Asia/Manila");
    $date_now = date("m/d/Y");
    $time_now = date("h:i a");
    $notify = $attempt = $log_time = "";

    $end_time = date("h:i A", strtotime("+15 minutes", strtotime($time_now)));

    $email = $password = "";
    $emailErr = $passwordErr = "";

    if(isset($_POST["btnLogin"])) {

        if(empty($_POST["email"])) {

            $emailErr = "Email is required!";
        
        }else{

            $email = $_POST["email"];

        }

        if(empty($_POST["password"])) {

            $passwordErr = "Password is required!";
        
        }else{

            $password = $_POST["password"];

        }

        if($email AND $password) {

            $check_email = mysqli_query($connections, "SELECT * FROM tbl_user WHERE email='$email'");
            $check_row = mysqli_num_rows($check_email);

            if($check_row > 0) {

                $fetch = mysqli_fetch_assoc($check_email);
                $db_password = $fetch["password"];
                $db_attempt = (int)$fetch["attempt"];
                $db_log_time = strtotime($fetch["log_time"]);
                $my_log_time = $fetch["log_time"];
                $new_time = strtotime($time_now);

                $account_type = $fetch["account_type"];

                if($account_type == "1") {

                    if($db_password == $password) {

                        $_SESSION["email"] = $email;

                        echo "<script>window.location.href='./Admin/view_record.php';</script>";

                    }else{

                        $passwordErr = "Hi Admin! Your Password is incorrect!";

                    }
                }else{

                    if($db_log_time <= $new_time) {

                        if($db_password == $password) {

                            $_SESSION["email"] = $email;

                            mysqli_query($connections, "UPDATE tbl_user SET attempt='', log_time='' WHERE email='$email'");

                            echo "<script>window.location.href='loading.php';</script>";
                    
                        }else{

                            $attempt = $db_attempt + 1;

                            if($attempt >= 3) {

                                $attempt = 3;
                                
                                mysqli_query($connections, "UPDATE tbl_user SET attempt='$attempt', log_time='$end_time' WHERE email='$email'");
                                $notify = "You already reach the three (3) times attempt to login. Please Login after 15 minutes: <b>$end_time</b>";

                            }else{

                                mysqli_query($connections, "UPDATE tbl_user SET attempt='$attempt' WHERE email='$email'");

                                $passwordErr = "Password is incorrect!";

                                $notify = "Login Attempt: <b>$attempt</b>";

                            }
                        }
                    }else{

                        $notify = "I'm sorry, You have to wait until: <b>$my_log_time</b> before login";

                    }
                }

            }else{

                $emailErr = "Email is not registered!";

            }
        }

    }

?>

<style>
    .error{
        color:red;
    }
</style>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
  <title>Login</title>
</head>


<body class="d-flex h-100 text-center">
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand float-md-start mb-0" href="index">Code<span style="color:green">Snippet</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="nav nav-masthead justify-content-center float-md-end">
        <a class="btn btn-m btn-outline-success fw-bold border-white" aria-current="page" href="login">Login</a>
        <a class="btn btn-m btn-outline-light fw-bold border-white ms-1" aria-current="page" href="register">Register</a>
        </ul>
        </div>
    </div>
    </nav>


    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
    <img src="./Photos/undraw_login.svg" alt="" class="position-absolute top-50 start-0 translate-middle-y">
    <main class="form-signin w-25 m-auto px-3 position-absolute top-50 start-50 end-0 translate-middle-y">
        <form method="POST">

            <h1 class="h3 mb-3 fw-bold">Log-in</h1>
            
            <div class="form-floating">
            <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" value="<?php echo $email; ?>">
            <span class="error"><?php echo $emailErr; ?></span>
            <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" value="">
            <span class="error"><?php echo $passwordErr; ?></span>
            <label for="floatingPassword">Password</label>
            </div>

            <input class="w-100 btn btn-lg btn-success mt-4" type="submit" name="btnLogin" value="Submit">
            <br>
            <br>
            <span class="error"><?php echo $notify; ?></span>
            <br>
            <a href="register">No account yet? Click here.</a>
                
        </form>
    </main>
    </div>
</body>

</html>













    