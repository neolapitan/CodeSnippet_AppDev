<br>
<br>
<br>
<center>
<table border="0" width="80%">
    <tr>
        <td width="16%"><b>Name</td>
        <td width="10%"><b>Gender</td>
        <td width="16%"><b>Contact</td>
        <td width="16%"><b>Email</td>
        <td width="16%"><b>Password</td>
        <td width="16%"><center><b>Action</td>
    </tr>
</center>




<?php
include("../connections.php");

$retrieve_query = mysqli_query($connections, "SELECT * FROM tbl_user WHERE account_type='2' ");

while($row_users = mysqli_fetch_assoc($retrieve_query)){
    $id_user = $row_users["id_user"];

    $db_first_name = $row_users["first_name"];
    $db_middle_name = $row_users["middle_name"];
    $db_last_name = $row_users["last_name"];

    $db_gender = $row_users["gender"];

    $db_prefix = $row_users["prefix"];
    $db_seven_digit = $row_users["seven_digit"];
    $db_email = $row_users["email"];
    $db_password = $row_users["password"];

    $full_name = ucfirst($db_first_name) . " " . ucfirst($db_middle_name[0]) . ". " . ucfirst($db_last_name);
    $contact = $db_prefix.$db_seven_digit;

    $jScript = md5(rand(1,9));
    $newScript = md5(rand(1,9));
    $getUpdate = md5(rand(1,9));
    $getDelete = md5(rand(1,9));

    echo "
    
    <tr>
        <td>$full_name</td>
        <td>$db_gender</td>
        <td>$contact</td>
        <td>$db_email</td>
        <td>$db_password</td>

        <td>
            <center>
                <br>
                <br>
                <a href='?jScript=$jScript && newScript=$newScript && getUpdate=$getUpdate && id_user=$id_user' class='btn btn-primary'>Update</a>
                &nbsp;
                <a href='?jScript=$jScript && newScript=$newScript && getDelete=$getDelete && id_user=$id_user' class='btn btn-danger'>Delete</a>
                <br>
                <br>
            </center>
        </td>
    </tr>";

    echo "
    
    <tr>
        <td colspan='6'> <hr> </td>
    </tr>
    
    ";
}
?>

</table>

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
        <div class="nav nav-masthead justify-content-center float-md-end">
        <a class="btn btn-m btn-danger fw-bold ms-1" aria-current="page" href="../logout">Logout</a>
        </ul>
        </div>
    </div>
</nav>
    <br>
    <br>
</body>

</html>