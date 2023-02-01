<?php
    $id_user = $_GET["id_user"];

    $query_name = mysqli_query($connections, "SELECT * FROM tbl_user WHERE id_user='$id_user' ");

    $row_ = mysqli_fetch_assoc($query_name);

    $db_first_name = $row_["first_name"];
    $db_middle_name = $row_["middle_name"];
    $db_last_name = $row_["last_name"];
    $db_gender = $row_["gender"];

    $gender_prefix = "";

    if($db_gender == "Male"){
        $gender_prefix = "Mr.";
    }else{
        $gender_prefix = "Ms.";
    }

    $full_name = $gender_prefix . " " . ucfirst($db_first_name) . " " . ucfirst($db_middle_name[0]) . ". " . ucfirst($db_last_name);

    if(isset($_POST["btn_delete"])){
        mysqli_query($connections, "DELETE FROM tbl_user WHERE id_user='$id_user' ");
        echo "<script>window.location.href='view_record?notify=$full_name has been successfully deleted! ';</script>";

    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
  <title>Confirm Delete</title>
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
    <center>
        <form method="POST">
            <br>
            <h4>You are about to delete this user: <font color="red"><?php echo $full_name; ?></font></h4>
                <input type="submit" name="btn_delete" value="Confirm" class="btn btn-primary"> &nbsp; &nbsp; <a href="?" class="btn btn-danger">Cancel</a>
        </form>
    </center>

    <hr>
    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>