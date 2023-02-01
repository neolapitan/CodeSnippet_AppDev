<?php
    session_start();
    include("../connections.php");

    if(isset($_SESSION["email"])){
        $email = $_SESSION["email"];

        $authentication = mysqli_query($connections, "SELECT * FROM tbl_user WHERE email='$email' ");
        $fetch = mysqli_fetch_assoc($authentication);
        $account_type = $fetch["account_type"];

        if($account_type != 1){
            echo "<script>window.location.href='../forbidden';</script>";
        }
    }



?>

<script type="text/javascript" src="js/jQuery.js"></script>

<script type="application/javascript">
setInterval(function(){
    $('#retriever').load('retriever.php');
}, 1000);
</script>

<?php

    if(empty($_GET["getDelete"])){

    }else{
        include("confirm_delete.php");
    }

    if(empty($_GET["getUpdate"])){


?>

<div id="retriever">
    <?php include("retriever.php"); ?>
</div>

<?php
    }else{
        include("updating_user.php");
    }

    if(empty($_GET["notify"])){
        //do nothing here
    }else{
        echo "<font color=green><h3><center>" . $_GET["notify"] . "</center></h3></font>";
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
  <title>Document</title>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container-fluid">
            <a id="liveToastBtn" class="navbar-brand float-md-start mb-0" href="#">Code<span style="color:green">Snippet</span></a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="view_record">View Records</a>
            </li>
            </ul>
            <div class="nav nav-masthead justify-content-center float-md-end">
            <a class="btn btn-m btn-danger fw-bold ms-1" aria-current="page" href="../logout">Logout</a>
            </ul>
            </div>
        </div>
    </nav>
    <br>
    <br>
    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>